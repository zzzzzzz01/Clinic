<?php

namespace App\Services;

use App\Models\User;
use App\Models\Panel;
use App\Models\Test;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Medicine;
use App\Models\Room;
use App\Models\Usage;
use App\Models\MedicineUsage;
use App\Models\MedicineUsageItem;
use App\Models\Prescription;
use App\Models\HospitalizationPrescriptionItemSlot;
use App\Models\HospitalizationProcedure;
use App\Models\HospitalizationOrder;
use App\Models\HospitalizationOrderItem;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminService
{
    public function getDashboardData()
    {
        // Ohirgi 10 kun (bugundan boshlab 10 kun) - HAQIQIY APPOINTMENTLAR
        $appointmentsLast10Days = collect(range(9, 0))->map(function ($i) {
            $date = Carbon::now()->subDays($i);
        
            return [
                'day' => $date->format('d M'),
                'count' => Appointment::whereDate('date', $date)->count(),
            ];
        });
    
        return [
            'totalPatients' => $this->getTotalPatients(),
            'patientsPercent' => $this->getPatientsPercent(),
            'totalDoctors' => $this->getTotalDoctors(),
            'newDoctors' => $this->getNewDoctors(),
            'totalAppointments' => $this->getTotalAppointments(),
            'todayAppointments' => $this->getTodayAppointments(),
            'totalDepartments' => $this->getTotalDepartments(),
            'totalRooms' => $this->getTotalRooms(),
            'occupiedRooms' => $this->getOccupiedRooms(),
            'totalMedicines' => $this->getTotalMedicines(),
            'lowStockMedicines' => $this->getLowStockMedicines(),
            'totalMedicinesSold' => $this->getTotalMedicinesSold(),
            'totalRevenue' => $this->getTotalRevenue(),
            'topMedicines' => $this->getTopMedicines(),
            'dailyMedicineSales' => $this->getDailyMedicineSales(),
            'todayAppointmentsList' => $this->getTodayAppointmentsList(),
            'appointmentsLast10Days' => $appointmentsLast10Days,
            'statusCounts' => $this->getStatusCounts(),
            'statusPercentages' => $this->getStatusPercentages(),
            'notifications' => $this->getNotifications(),
            'recentActivities' => $this->getRecentActivities(),
        ];
    }

    // =============================================
    // DOCTOR DASHBOARD
    // =============================================

    public function getDoctorDashboardData(Request $request)
    {
        $doctorId = auth()->user()->doctor->id ?? null;
        
        if (!$doctorId) {
            abort(403, 'Doctor not found');
        }

        $selectedDate = $request->get('date') 
            ? Carbon::parse($request->get('date')) 
            : Carbon::today();

        return [
            'totalAppointments' => $this->getDoctorTotalAppointments($doctorId),
            'todayAppointments' => $this->getDoctorTodayAppointments($doctorId),
            'totalPrescriptions' => $this->getDoctorTotalPrescriptions($doctorId),
            'appointmentsByDate' => $this->getDoctorAppointmentsByDate($doctorId, $selectedDate),
            'selectedDate' => $selectedDate,
            'appointmentsLast10Days' => $this->getDoctorAppointmentsLast10Days($doctorId),
            'last10DaysAppointments' => $this->getDoctorLast10DaysAppointments($doctorId),
            'statusCounts' => $this->getDoctorStatusCounts($doctorId),
            'statusPercentages' => $this->getDoctorStatusPercentages($doctorId),
            'calendarDays' => $this->getCalendarDays($selectedDate, $doctorId),
            'currentMonth' => $selectedDate->format('F Y'),
            'prevMonth' => $selectedDate->copy()->subMonth()->format('Y-m-d'),
            'nextMonth' => $selectedDate->copy()->addMonth()->format('Y-m-d'),
        ];
    }

    private function getDoctorTotalAppointments($doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)->count();
    }

    private function getDoctorTodayAppointments($doctorId)
    {
        return Appointment::where('doctor_id', $doctorId)
            ->whereDate('date', Carbon::today())
            ->count();
    }

    private function getDoctorTotalPrescriptions($doctorId)
    {
        return Prescription::whereHas('appointment', function($q) use ($doctorId) {
            $q->where('doctor_id', $doctorId);
        })->count();
    }

    private function getDoctorAppointmentsByDate($doctorId, $date)
    {
        return Appointment::with(['patient', 'appointmentSlot'])
            ->where('doctor_id', $doctorId)
            ->whereDate('date', $date)
            ->orderBy('date')
            ->get()
            ->map(fn($a) => [
                'time' => Carbon::parse($a->appointmentSlot->start_time)->format('H:i'),
                'patient' => $this->getFullName($a->patient->user),
                'status' => $a->status,
                'status_config' => $this->getAppointmentStatusConfig($a->status),
                'id' => $a->id,
            ]);
    }

    private function getDoctorAppointmentsLast10Days($doctorId)
    {
        return collect(range(9, 0))->map(fn($i) => [
            'day' => Carbon::now()->subDays($i)->format('d M'),
            'count' => Appointment::where('doctor_id', $doctorId)
                ->whereDate('date', Carbon::now()->subDays($i))
                ->count(),
        ]);
    }

    private function getDoctorLast10DaysAppointments($doctorId)
    {
        $appointments = Appointment::with(['patient', 'appointmentSlot'])
            ->where('doctor_id', $doctorId)
            ->whereDate('date', '>=', Carbon::now()->subDays(9))
            ->whereDate('date', '<=', Carbon::now())
            ->orderBy('date', 'desc')
            ->orderBy('appointment_slot_id', 'asc')
            ->limit(6)
            ->get();
    
        if ($appointments->isEmpty()) {
            return collect([]);
        }
    
        return $appointments->map(fn($a) => [
            'date' => Carbon::parse($a->date)->format('d.m.Y'),
            'time' => Carbon::parse($a->appointmentSlot->start_time)->format('H:i'),
            'patient' => $this->getFullName($a->patient->user),
            'status' => $a->status,
            'status_config' => $this->getAppointmentStatusConfig($a->status),
            'id' => $a->id,
        ]);
    }

    private function getDoctorStatusCounts($doctorId)
    {
        return [
            'pending' => Appointment::where('doctor_id', $doctorId)
                ->where('status', 'booked')->count(),
            'completed' => Appointment::where('doctor_id', $doctorId)
                ->where('status', 'completed')->count(),
            'cancelled' => Appointment::where('doctor_id', $doctorId)
                ->where('status', 'cancelled')->count(),
        ];
    }

    private function getDoctorStatusPercentages($doctorId)
    {
        $counts = $this->getDoctorStatusCounts($doctorId);
        $total = array_sum($counts);
        return collect($counts)->map(fn($v) => $total > 0 ? round(($v / $total) * 100) : 0)->toArray();
    }

    private function getCalendarDays($selectedDate, $doctorId)
    {
        $days = [];
        $firstDay = $selectedDate->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $lastDay = $selectedDate->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        
        for ($date = $firstDay; $date <= $lastDay; $date->addDay()) {
            $hasAppointment = Appointment::where('doctor_id', $doctorId)
                ->whereDate('date', $date)
                ->exists();
            
            $days[] = [
                'day' => $date->day,
                'date' => $date->format('Y-m-d'),
                'isToday' => $date->isToday(),
                'isSelected' => $date->isSameDay($selectedDate),
                'hasAppointment' => $hasAppointment,
                'isCurrentMonth' => $date->month == $selectedDate->month,
            ];
        }
        
        return $days;
    }

    // =============================================
    // STATUS CONFIG FUNCTIONS
    // =============================================

    private function getAppointmentStatusConfig(string $status): array
    {
        return match($status) {
            'booked' => [
                'text' => __('words.pending'),
                'text_color' => '#856404',
                'bg_color' => '#fff3cd',
                'class' => 'status-booked',
                'icon' => 'fas fa-door-closed'
            ],
            'completed' => [
                'text' => __('words.completed'),
                'text_color' => '#27ae60',
                'bg_color' => '#e8f8f5',
                'class' => 'status-completed',
                'icon' => 'fas fa-circle-check'
            ],
            'cancelled' => [
                'text' => __('words.cancelled'),
                'text_color' => '#e74c3c',
                'bg_color' => '#fdedec',
                'class' => 'status-cancelled',
                'icon' => 'fas fa-circle-xmark'
            ],
            default => [
                'text' => __('words.unknown'),
                'text_color' => '#95a5a6',
                'bg_color' => '#f5f5f5',
                'class' => 'status-unknown'
            ],
        };
    }

    // =============================================
    // OLD FUNCTIONS (Usage bilan ishlaydigan)
    // =============================================

    private function getTotalMedicinesSold()
    {
        return MedicineUsageItem::whereHas('usage', function($q) {
            $q->whereMonth('given_at', Carbon::now()->month)
                ->whereYear('given_at', Carbon::now()->year);
        })->sum('quantity');
    }

    private function getTotalRevenue()
    {
        return MedicineUsageItem::whereHas('usage', function($q) {
            $q->whereMonth('given_at', Carbon::now()->month)
                ->whereYear('given_at', Carbon::now()->year);
        })->sum(DB::raw('quantity * price'));
    }

    private function getTopMedicines()
    {
        return MedicineUsageItem::with(['medicine', 'usage'])
            ->select('medicine_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(quantity * price) as revenue'))
            ->whereHas('usage', function($q) {
                $q->whereMonth('given_at', Carbon::now()->month)
                    ->whereYear('given_at', Carbon::now()->year);
            })
            ->groupBy('medicine_id')
            ->orderBy('total_sold', 'desc')
            ->limit(6)
            ->get()
            ->map(fn($item) => [
                'name' => $item->medicine->name ?? 'Noma\'lum',
                'total_sold' => $item->total_sold,
                'revenue' => $item->revenue,
                'stock' => $item->medicine->stock_boxes ?? 0,
            ]);
    }

    private function getDailyMedicineSales()
    {
        return collect(range(6, 0))->map(fn($i) => [
            'day' => Carbon::now()->subDays($i)->format('D'),
            'count' => MedicineUsageItem::whereHas('usage', function($q) use ($i) {
                $q->whereDate('given_at', Carbon::now()->subDays($i));
            })->sum(DB::raw('quantity * price')), // summa bo'yicha
        ]);
    }

    // =============================================
    // OLD FUNCTIONS
    // =============================================

    private function getTotalPatients()
    {
        return User::whereHas('roles', function($q) {
            $q->where('name', 'patient');
        })->count();
    }

    private function getPatientsPercent()
    {
        $total = $this->getTotalPatients();
        $growth = User::whereHas('roles', function($q) {
            $q->where('name', 'patient');
        })->where('created_at', '>=', Carbon::now()->subMonth())->count();
        return $total > 0 ? round(($growth / $total) * 100) : 0;
    }

    private function getTotalDoctors()
    {
        return User::whereHas('roles', function($q) {
            $q->where('name', 'doctor');
        })->count();
    }

    private function getNewDoctors()
    {
        return User::whereHas('roles', function($q) {
            $q->where('name', 'doctor');
        })->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
    }

    private function getTotalAppointments()
    {
        return Appointment::count();
    }

    private function getTodayAppointments()
    {
        return Appointment::whereDate('created_at', Carbon::today())->count();
    }

    private function getTotalDepartments()
    {
        return Department::count();
    }

    private function getTotalRooms()
    {
        return Room::count();
    }

    private function getOccupiedRooms()
    {
        return Room::where('status', 'occupied')->count();
    }

    private function getTotalMedicines()
    {
        return Medicine::count();
    }

    private function getLowStockMedicines()
    {
        return Medicine::where('stock_boxes', '<=', 10)->count();
    }

    private function getTodayAppointmentsList()
    {
        return Appointment::with(['patient', 'doctor', 'doctor.departments', 'appointmentSlot'])
            ->whereDate('date', Carbon::today())
            ->orderBy('date')->take(5)
            ->get()
            ->map(fn($a) => [
                'time' => Carbon::parse($a->appointmentSlot->start_time)->format('H:i'),
                'patient' => $this->getFullName($a->patient->user),
                'doctor' => 'Dr. ' . $this->getFullName($a->doctor->user),
                'department' => $a->doctor->departments->first()->name ?? 'N/A',
                'id' => $a->id,
            ]);
    }

    private function getAppointmentsLast9Months()
    {
        return collect(range(8, 0))->map(fn($i) => [
            'month' => Carbon::now()->subMonths($i)->format('M'),
            'count' => Appointment::whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                ->whereYear('created_at', Carbon::now()->subMonths($i)->year)
                ->count(),
        ]);
    }

    private function getStatusCounts()
    {
        return [
            'pending' => Appointment::where('status', 'booked')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];
    }

    private function getStatusPercentages()
    {
        $counts = $this->getStatusCounts();
        $total = array_sum($counts);
        return collect($counts)->map(fn($v) => $total > 0 ? round(($v / $total) * 100) : 0)->toArray();
    }

    private function getNotifications()
    {
        $notifications = [];

        Medicine::where('stock_boxes', '<=', 10)->limit(3)->get()->each(fn($item) => 
            $notifications[] = [
                'message' => "Medicine \"{$item->name}\" is low in stock",
                'time' => Carbon::now()->subMinutes(rand(1, 60))->diffForHumans(),
                'type' => 'warning'
            ]
        );

        $pending = Appointment::where('status', 'pending')->count();
        if ($pending > 0) {
            $notifications[] = [
                'message' => "{$pending} appointments are waiting for confirmation",
                'time' => Carbon::now()->subMinutes(25)->diffForHumans(),
                'type' => 'info'
            ];
        }

        Room::where('status', 'occupied')->limit(3)->get()->each(fn($room) => 
            $notifications[] = [
                'message' => "Room {$room->number} is occupied",
                'time' => Carbon::now()->subMinutes(rand(1, 120))->diffForHumans(),
                'type' => 'info'
            ]
        );

        return $notifications;
    }

    private function getRecentActivities()
    {
        $activities = [];

        User::whereHas('roles', fn($q) => $q->where('name', 'patient'))
            ->latest()->limit(2)->get()
            ->each(fn($p) => $activities[] = [
                'action' => "New patient \"{$p->name}\" registered",
                'time' => $p->created_at->format('H:i'),
                'type' => 'patient'
            ]);

        Appointment::with(['patient', 'doctor'])->latest()->limit(2)->get()
            ->each(fn($a) => $activities[] = [
                'action' => "Appointment created for \"{$a->patient->name}\"",
                'time' => $a->created_at->format('H:i'),
                'type' => 'appointment'
            ]);

        Prescription::with(['appointment.patient'])->latest()->limit(1)->get()
            ->each(fn($p) => $activities[] = [
                'action' => "Prescription added for \"{$p->appointment->patient->name}\"",
                'time' => $p->created_at->format('H:i'),
                'type' => 'prescription'
            ]);

        usort($activities, fn($a, $b) => strtotime($b['time']) - strtotime($a['time']));
        return array_slice($activities, 0, 5);
    }

    private function getFullName($user)
    {
        if (!$user) return 'Noma\'lum';
        $name = $user->last_name ?? 'Noma\'lum';
        if (isset($user->name) && $user->name !== '') {
            $name .= ' ' . mb_strtoupper(mb_substr($user->name, 0, 1));
        }
        return $name;
    }










    // =============================================
    // NURSE DASHBOARD
    // =============================================

    public function getNurseDashboardData(Request $request)
    {
        $authUser = auth()->user();
        $nurse = Nurse::where('user_id', $authUser->id)->first();
        
        if (!$nurse) {
            abort(403, 'Nurse not found');
        }

        $selectedDate = $request->get('date') 
            ? Carbon::parse($request->get('date')) 
            : Carbon::today();

        // Stats
        $stats = $this->getNurseStats($nurse, $selectedDate);

        // Medications & Procedures (7 kun)
        $weeklyData = $this->getNurseWeeklyData($nurse);

        // Calendar
        $calendarDays = $this->getNurseCalendarDays($selectedDate, $nurse);

        // Selected Date's Medications (5 ta) - TANLANGAN KUN UCHUN
        $todayMedications = $this->getNurseMedicationsByDate($nurse, $selectedDate, 5);

        // Selected Date's Procedures (5 ta) - TANLANGAN KUN UCHUN
        $todayProcedures = $this->getNurseProceduresByDate($nurse, $selectedDate, 5);

        return [
            'stats' => $stats,
            'weeklyData' => $weeklyData,
            'selectedDate' => $selectedDate,
            'calendarDays' => $calendarDays,
            'currentMonth' => $selectedDate->format('F Y'),
            'prevMonth' => $selectedDate->copy()->subMonth()->format('Y-m-d'),
            'nextMonth' => $selectedDate->copy()->addMonth()->format('Y-m-d'),
            'todayMedications' => $todayMedications,
            'todayProcedures' => $todayProcedures,
        ];
    }

    private function getNurseStats($nurse, $selectedDate)
    {
        $today = Carbon::today();

        $totalMedications = HospitalizationPrescriptionItemSlot::whereHas('item.prescription.hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
            $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
        })->count();

        // TANLANGAN KUN UCHUN dori soni
        $todayMedications = HospitalizationPrescriptionItemSlot::whereHas('item.prescription.hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
            $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
        })->whereDate('scheduled_at', $selectedDate)->count();

        $totalProcedures = HospitalizationProcedure::whereHas('hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
            $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
        })->count();

        // TANLANGAN KUN UCHUN protsedura soni
        $todayProcedures = HospitalizationProcedure::whereHas('hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
            $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
        })->whereDate('assigned_at', $selectedDate)->count();

        return [
            'total_medications' => $totalMedications,
            'today_medications' => $todayMedications,
            'total_procedures' => $totalProcedures,
            'today_procedures' => $todayProcedures,
        ];
    }

    private function getNurseMedicationsByDate($nurse, $date, $limit = 5)
    {
        return HospitalizationPrescriptionItemSlot::whereDate('scheduled_at', $date)
            ->whereHas('item.prescription.hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
                $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
            })
            ->with([
                'item.medicine',
                'item.prescription.hospitalization.appointment.patient.user',
                'item.prescription.hospitalization.currentRoom.bed.room'
            ])
            ->orderBy('scheduled_at')
            ->limit($limit)
            ->get()
            ->map(fn($slot) => [
                'time' => Carbon::parse($slot->scheduled_at)->format('H:i'),
                'patient' => $this->getFullName($slot->item->prescription->hospitalization->appointment->patient->user),
                'room' => data_get($slot->item->prescription->hospitalization, 'currentRoom.bed.room.number'),
                'bed' => data_get($slot->item->prescription->hospitalization, 'currentRoom.bed.bed_number'),
                'medicine' => $slot->item->medicine->name ?? '-',
                'dose' => $slot->item->dose_amount . ' ' . ($slot->item->medicine->form ?? ''),
                'status' => $slot->status,
                'status_config' => $this->getTreatmentStatusConfig($slot->status),
                'id' => $slot->id,
            ]);
    }

    private function getNurseProceduresByDate($nurse, $date, $limit = 5)
    {
        return HospitalizationProcedure::whereDate('assigned_at', $date)
            ->whereHas('hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
                $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
            })
            ->with([
                'procedure',
                'hospitalization.appointment.patient.user',
                'hospitalization.currentRoom.bed.room'
            ])
            ->orderBy('assigned_at')
            ->limit($limit)
            ->get()
            ->map(fn($procedure) => [
                'time' => Carbon::parse($procedure->assigned_at)->format('H:i'),
                'patient' => $this->getFullName($procedure->hospitalization->appointment->patient->user),
                'room' => $procedure->room->number ?? '-', 
                'procedure' => $procedure->procedure->name ?? '-',
                'duration' => ($procedure->procedure->duration ?? '-') . ' min',
                'status' => $procedure->status ?? 'pending',
                'status_config' => $this->getTreatmentStatusConfig($procedure->status ?? 'pending'),
                'id' => $procedure->id,
            ]);
    }

    private function getNurseWeeklyData($nurse)
    {
        $medications = [];
        $procedures = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayName = $date->format('D');

            $medCount = HospitalizationPrescriptionItemSlot::whereHas('item.prescription.hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
                $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
            })->whereDate('scheduled_at', $date)->count();

            $procCount = HospitalizationProcedure::whereHas('hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
                $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
            })->whereDate('assigned_at', $date)->count();

            $medications[] = [
                'day' => $dayName,
                'count' => $medCount,
            ];

            $procedures[] = [
                'day' => $dayName,
                'count' => $procCount,
            ];
        }

        return [
            'medications' => $medications,
            'procedures' => $procedures,
        ];
    }

    private function getNurseCalendarDays($selectedDate, $nurse)
    {
        $days = [];
        $firstDay = $selectedDate->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $lastDay = $selectedDate->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        
        for ($date = $firstDay; $date <= $lastDay; $date->addDay()) {
            $hasMedication = HospitalizationPrescriptionItemSlot::whereHas('item.prescription.hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
                $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
            })->whereDate('scheduled_at', $date)->exists();

            $hasProcedure = HospitalizationProcedure::whereHas('hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
                $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
            })->whereDate('assigned_at', $date)->exists();
            
            $days[] = [
                'day' => $date->day,
                'date' => $date->format('Y-m-d'),
                'isToday' => $date->isToday(),
                'isSelected' => $date->isSameDay($selectedDate),
                'hasEvent' => $hasMedication || $hasProcedure,
                'isCurrentMonth' => $date->month == $selectedDate->month,
            ];
        }
        
        return $days;
    }

    private function getTreatmentStatusConfig(string $status): array
    {
        return match($status) {
            'pending' => [
                'text' => __('words.pending'),
                'text_color' => '#856404',
                'bg_color' => '#fff3cd',
                'class' => 'status-pending'
            ],
            'completed' => [
                'text' => __('words.ready'),
                'text_color' => '#155724',
                'bg_color' => '#d4edda',
                'class' => 'status-completed'
            ],
            'given' => [
                'text' => __('words.prescribed'),
                'text_color' => '#155724',
                'bg_color' => '#d4edda',
                'class' => 'status-given'
            ],
            'resumed' => [
                'text' => __('words.continued'),
                'text_color' => '#0c5460',
                'bg_color' => '#d1ecf1',
                'class' => 'status-resumed'
            ],
            'skipped' => [
                'text' => __('words.skipped'),
                'text_color' => '#721c24',
                'bg_color' => '#f8d7da',
                'class' => 'status-skipped'
            ],
            'stopped' => [
                'text' => __('words.stopped'),
                'text_color' => '#383d41',
                'bg_color' => '#e2e3e5',
                'class' => 'status-stopped'
            ],
            default => [
                'text' => __('words.unknown'),
                'text_color' => '#95a5a6',
                'bg_color' => '#f5f5f5',
                'class' => 'status-unknown'
            ],
        };
    }


    // =============================================
    // PHARMACIST DASHBOARD
    // =============================================

    public function getPharmacistDashboardData(Request $request)
    {
        $pharmacistId = auth()->user()->id ?? null;
        
        if (!$pharmacistId) {
            abort(403, 'Pharmacist not found');
        }

        $selectedDate = $request->get('date') 
            ? Carbon::parse($request->get('date')) 
            : Carbon::today();

        // Stats
        $stats = $this->getPharmacistStats();

        // Weekly Data (qutida)
        $weeklyData = $this->getPharmacistWeeklyData();

        // Selected Date Prescriptions (5 ta)
        $selectedPrescriptions = $this->getPharmacistPrescriptionsByDate($selectedDate, 5);

        // Low Stock Medicines (5 ta)
        $lowStockMedicines = $this->getPharmacistLowStockMedicines(5);

        // Pharmacy Overview (Doughnut)
        $pharmacyOverview = $this->getPharmacistPharmacyOverview();

        // Medicine Categories
        $categoryStats = $this->getPharmacistCategoryStats();

        // Calendar Days
        $calendarDays = $this->getPharmacistCalendarDays($selectedDate);

        return [
            'stats' => $stats,
            'weeklyData' => $weeklyData,
            'selectedPrescriptions' => $selectedPrescriptions,
            'lowStockMedicines' => $lowStockMedicines,
            'pharmacyOverview' => $pharmacyOverview,
            'categoryStats' => $categoryStats,
            'selectedDate' => $selectedDate,
            'calendarDays' => $calendarDays,
            'currentMonth' => $selectedDate->format('F Y'),
            'prevMonth' => $selectedDate->copy()->subMonth()->format('Y-m-d'),
            'nextMonth' => $selectedDate->copy()->addMonth()->format('Y-m-d'),
            'totalMedicines' => $stats['total_medicines'],
            'selectedDateLabel' => $selectedDate->format('d.m.Y'),
        ];
    }

    private function getPharmacistStats()
    {
        $today = Carbon::today();

        $totalMedicines = Medicine::count();
        $lowStock = Medicine::where('stock_units', '<=', DB::raw('min_stock * units_per_box'))->count();
        $todayUsages = MedicineUsage::whereDate('given_at', $today)->count();
        $totalRevenue = MedicineUsage::sum('total_price');

        return [
            'total_medicines' => $totalMedicines,
            'low_stock' => $lowStock,
            'today_usages' => $todayUsages,
            'total_revenue' => $totalRevenue,
        ];
    }

    private function getPharmacistWeeklyData()
    {
        $boxUsages = [];
        $revenues = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayName = $date->format('D');

            // Quti bo'yicha sotuv (unit_per_box ga bo'lib) - yaxlit son
            $boxCount = MedicineUsageItem::whereHas('usage', function($q) use ($date) {
                $q->whereDate('given_at', $date);
            })->with('medicine')
            ->get()
            ->sum(function($item) {
                return ceil($item->quantity / ($item->medicine->units_per_box ?? 1));
            });

            // Daromad
            $revenue = MedicineUsage::whereDate('given_at', $date)->sum('total_price');

            $boxUsages[] = [
                'day' => $dayName,
                'count' => $boxCount,
            ];

            $revenues[] = [
                'day' => $dayName,
                'amount' => $revenue,
            ];
        }

        return [
            'box_usages' => $boxUsages,
            'revenues' => $revenues,
        ];
    }

    private function getPharmacistPrescriptionsByDate($date, $limit = 5)
    {
        return MedicineUsage::whereDate('given_at', $date)
            ->with(['user', 'items.medicine'])
            ->orderBy('given_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(fn($usage) => [
                'id' => $usage->id,
                'time' => Carbon::parse($usage->given_at)->format('H:i'),
                'pharmacist' => $this->getFullName($usage->user),
                'total_items' => $usage->items->sum('quantity'),
                'total_price' => $usage->total_price,
                'payment_method' => $usage->payment_method ?? '-',
                'items' => $usage->items->map(fn($item) => [
                    'name' => $item->medicine->name ?? 'Noma\'lum',
                    'quantity' => $item->quantity,
                    'unit' => $item->medicine->form ?? 'dona',
                    'units_per_box' => $item->medicine->units_per_box ?? 1,
                    'strength_value' => $item->medicine->strength_value ?? '',
                    'strength_unit' => $item->medicine->strength_unit ?? '',
                    'display_text' => ($item->medicine->name ?? 'Noma\'lum') . ' ' . 
                        ($item->medicine->strength_value ?? '') . ' ' . 
                        ($item->medicine->strength_unit ?? '') . ' x ' . 
                        $item->quantity . ' ' . 
                        ($item->quantity > 1 ? 'dona' : 'dona'),
                ]),
            ]);
    }

    private function getPharmacistLowStockMedicines($limit = 5)
    {
        return Medicine::where('stock_units', '<=', DB::raw('min_stock * units_per_box'))
            ->orderBy('stock_units', 'asc')
            ->limit($limit)
            ->get()
            ->map(fn($medicine) => [
                'id' => $medicine->id,
                'name' => $medicine->name . ' x ' . $medicine->strength_value . ' ' . $medicine->strength_unit,
                'stock_units' => $medicine->stock_units,
                'min_stock' => $medicine->min_stock * $medicine->units_per_box,
                'units_per_box' => $medicine->units_per_box,
                'stock_boxes' => ceil($medicine->stock_units / $medicine->units_per_box),
            ]);
    }

    private function getPharmacistPharmacyOverview()
    {
        $total = Medicine::count();
        
        $inStock = Medicine::where('stock_units', '>', DB::raw('min_stock * units_per_box * 2'))->count();
        $lowStock = Medicine::where('stock_units', '<=', DB::raw('min_stock * units_per_box'))->where('stock_units', '>', 0)->count();
        $outOfStock = Medicine::where('stock_units', '<=', 0)->count();
        $others = $total - ($inStock + $lowStock + $outOfStock);

        return [
            'labels' => [__('words.in_stock'), __('words.low_stock'), __('words.out_of_stock'), __('words.others')],
            'data' => [
                round(($inStock / $total) * 100, 1),
                round(($lowStock / $total) * 100, 1),
                round(($outOfStock / $total) * 100, 1),
                round(($others / $total) * 100, 1),
            ],
            'colors' => ['#2ecc71', '#f39c12', '#e74c3c', '#3498db'],
            'totals' => [
                $inStock, $lowStock, $outOfStock, $others
            ]
        ];
    }

    private function getPharmacistCategoryStats()
    {
        return Medicine::with('category')
            ->select('medicine_category_id', DB::raw('count(*) as total'))
            ->whereNotNull('medicine_category_id')
            ->groupBy('medicine_category_id')
            ->get()
            ->map(fn($item) => [
                'category' => $item->category->name ?? 'Noma\'lum',
                'total' => $item->total,
                'percentage' => round(($item->total / Medicine::count()) * 100, 1),
            ]);
    }

    private function getPharmacistCalendarDays($selectedDate)
    {
        $days = [];
        $firstDay = $selectedDate->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $lastDay = $selectedDate->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        
        for ($date = $firstDay; $date <= $lastDay; $date->addDay()) {
            $hasUsage = MedicineUsage::whereDate('given_at', $date)->exists();
            
            $days[] = [
                'day' => $date->day,
                'date' => $date->format('Y-m-d'),
                'isToday' => $date->isToday(),
                'isSelected' => $date->isSameDay($selectedDate),
                'hasEvent' => $hasUsage,
                'isCurrentMonth' => $date->month == $selectedDate->month,
            ];
        }
        
        return $days;
    }

   // =============================================
    // LABORATORY DASHBOARD
    // =============================================

    public function getLaboratoryDashboardData(Request $request)
    {
        $selectedDate = $request->get('date') 
            ? Carbon::parse($request->get('date')) 
            : Carbon::today();

        return [
            // Statistika kartalari
            'laboratoryTotalTests' => $this->laboratoryGetTotalTests(),
            'laboratoryCompletedTests' => $this->laboratoryGetCompletedTests(), 
            'laboratoryPendingTests' => $this->laboratoryGetPendingTests(),
            'laboratoryUrgentTests' => $this->laboratoryGetUrgentTests(),
            'laboratoryTotalPatients' => $this->laboratoryGetTotalPatients(),
            'laboratoryTotalDoctors' => $this->laboratoryGetTotalDoctors(),

            // Jadval (tanlangan sana bo'yicha)
            'laboratoryRequests' => $this->laboratoryGetRequestsByDate($selectedDate),
            'laboratorySelectedDate' => $selectedDate,

            // Oxirgi 7 kun bajarilgan tahlillar charti
            'laboratoryCompletedLast7Days' => $this->laboratoryGetCompletedLast7Days(),

            // Tahlil turlari statistikasi
            'laboratoryTestCategories' => $this->laboratoryGetTestCategories(),

            // So'nggi bajarilgan natijalar
            'laboratoryRecentResults' => $this->laboratoryGetRecentResults(),

            // Eng ko'p buyurilgan testlar (Donut Chart)
            'laboratoryTopTests' => $this->laboratoryGetTopTests(),

            // Kalendar uchun so'rov bor kunlar
            'laboratoryRequestDates' => $this->laboratoryGetRequestDates(),
        ];
    }

    // =============================================
    // LABORATORY PRIVATE METHODS
    // =============================================

    private function laboratoryGetTotalTests()
    {
        return HospitalizationOrderItem::whereIn('item_type', ['panel', 'test'])->count();
    }

    private function laboratoryGetCompletedTests()
    {
        return HospitalizationOrderItem::whereIn('item_type', ['panel', 'test'])
            ->where('status', 'completed')
            ->count();
    }

    private function laboratoryGetPendingTests()
    {
        return HospitalizationOrderItem::whereIn('item_type', ['panel', 'test'])
            ->where('status', 'pending')
            ->count();
    }

    private function laboratoryGetUrgentTests()
    {
        return HospitalizationOrderItem::whereIn('item_type', ['panel', 'test'])
            ->where('status', 'pending')
            ->whereHas('order', function($q) {
                $q->where('order_type', 'emergency');
            })
            ->count();
    }

    private function laboratoryGetTotalPatients()
    {
        return Patient::count();
    }

    private function laboratoryGetTotalDoctors()
    {
        return Doctor::count();
    }

    private function laboratoryGetRequestsByDate($date)
    {
        $items = HospitalizationOrderItem::with([
            'order.hospitalization.appointment.patient.user',
            'order.hospitalization.appointment.doctor.user',
        ])
        ->whereIn('item_type', ['panel', 'test'])
        ->whereHas('order', function($q) use ($date) {
            $q->whereDate('ordered_at', $date);
        })
        ->orderBy('created_at', 'asc')
        ->paginate(6);

        return $items->map(fn($item) => [
            'id' => $item->id,
            'patient' => $this->getFullName($item->order->hospitalization->appointment->patient->user ?? null),
            'patient_id' => $item->order->hospitalization->appointment->patient->medical_id ?? 'P-' . str_pad($item->order->hospitalization->appointment->patient_id ?? 0, 6, '0', STR_PAD_LEFT),
            'test' => $this->laboratoryGetItemName($item),
            'doctor' => 'Dr. ' . $this->getFullName($item->order->hospitalization->appointment->doctor->user ?? null),
            'priority' => $item->order->order_type ?? 'normal',
            'priority_config' => $this->laboratoryGetPriorityConfig($item->order->order_type ?? 'normal'),
            'status' => $item->status ?? 'pending',
            'status_config' => $this->laboratoryGetStatusConfig($item->status ?? 'pending'),
            'requested_at' => Carbon::parse($item->order->ordered_at ?? $item->created_at)->format('d.m.Y H:i'),
        ]);
    }

    private function laboratoryGetCompletedLast7Days()
    {
        return collect(range(6, 0))->map(fn($i) => [
            'day' => Carbon::now()->subDays($i)->format('d M'),
            'count' => HospitalizationOrderItem::whereIn('item_type', ['panel', 'test'])
                ->where('status', 'completed')
                ->whereHas('order', function($q) use ($i) {
                    $q->whereDate('ordered_at', Carbon::now()->subDays($i));
                })
                ->count(),
        ]);
    }

    private function laboratoryGetTestCategories()
    {
        // Real ma'lumotlarni item_type bo'yicha guruhlash
        $categories = HospitalizationOrderItem::whereIn('item_type', ['panel', 'test'])
            ->select('item_type', DB::raw('count(*) as total'))
            ->groupBy('item_type')
            ->get();

        $total = $categories->sum('total');

        if ($total == 0) {
            return collect([]);
        }

        return $categories->map(fn($item) => [
            'name' => $item->item_type == 'panel' ? 'Panel' : 'Test',
            'count' => $item->total,
            'percentage' => round(($item->total / $total) * 100),
        ]);
    }

    private function laboratoryGetRecentResults()
    {
        $items = HospitalizationOrderItem::with([
            'order.hospitalization.appointment.patient.user'
        ])
        ->whereIn('item_type', ['panel', 'test'])
        ->where('status', 'completed')
        ->whereHas('order', function($q) {
            $q->whereNotNull('ordered_at');
        }) 
        ->limit(4)
        ->get();

        return $items->map(fn($item) => [
            'patient' => $this->getFullName($item->order->hospitalization->appointment->patient->user ?? null),
            'test' => $this->laboratoryGetItemName($item),
            'time' => Carbon::parse($item->order->ordered_at ?? $item->updated_at)->format('H:i'),
        ]);
    }

    private function laboratoryGetTopTests()
    {
        $topTests = HospitalizationOrderItem::whereIn('item_type', ['panel', 'test'])
            ->select('item_id', 'item_type', DB::raw('count(*) as total'))
            ->groupBy('item_id', 'item_type')
            ->orderBy('total', 'desc')
            ->limit(6)
            ->get();

        $colors = ['#0dcaf0', '#198754', '#ffc107', '#dc3545', '#0d6efd', '#6c757d'];

        if ($topTests->isEmpty()) {
            return collect([]);
        }

        return $topTests->map(fn($item, $index) => [
            'name' => $this->laboratoryGetItemName($item),
            'count' => $item->total,
            'color' => $colors[$index % count($colors)],
        ]);
    }

    private function laboratoryGetRequestDates()
    {
        $dates = HospitalizationOrderItem::whereIn('item_type', ['panel', 'test'])
            ->whereHas('order', function($q) {
                $q->whereNotNull('ordered_at');
            })
            ->select(DB::raw('DATE(orders.ordered_at) as date'))
            ->join('hospitalization_orders as orders', 'hospitalization_order_items.hospitalization_order_id', '=', 'orders.id')
            ->distinct()
            ->pluck('date')
            ->toArray();

        if (empty($dates)) {
            return [now()->format('Y-m-d')];
        }

        return $dates;
    }

    private function laboratoryGetItemName($item)
    {
        // Agar item_type panel bo'lsa, Panel modelidan nom olish
        if ($item->item_type == 'panel') {
            try {
                $panel = Panel::find($item->item_id);
                return $panel->name ?? 'Panel #' . $item->item_id;
            } catch (\Exception $e) {
                return 'Panel #' . $item->item_id;
            }
        }
        
        // Agar item_type test bo'lsa, Test modelidan nom olish
        if ($item->item_type == 'test') {
            try {
                $test = Test::find($item->item_id);
                return $test->name ?? 'Test #' . $item->item_id;
            } catch (\Exception $e) {
                return 'Test #' . $item->item_id;
            }
        }

        return 'Noma\'lum';
    }

    private function laboratoryGetPriorityConfig($priority)
    {
        return match($priority) {
            'emergency', 'high' => ['text' => 'Yuqori', 'badge' => 'bg-danger'],
            'normal' => ['text' => 'Oddiy', 'badge' => 'bg-info'],
            'low' => ['text' => 'Past', 'badge' => 'bg-secondary'],
            default => ['text' => 'Oddiy', 'badge' => 'bg-info'],
        };
    }

    private function laboratoryGetStatusConfig($status)
    {
        return match($status) {
            'pending' => ['text' => 'Kutilmoqda', 'badge' => 'bg-warning'],
            'in_progress' => ['text' => 'Jarayonda', 'badge' => 'bg-primary'],
            'completed' => ['text' => 'Bajarildi', 'badge' => 'bg-success'],
            'cancelled' => ['text' => 'Bekor qilindi', 'badge' => 'bg-danger'],
            default => ['text' => 'Kutilmoqda', 'badge' => 'bg-warning'],
        };
    }
}