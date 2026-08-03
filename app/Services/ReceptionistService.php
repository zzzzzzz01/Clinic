<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\AppointmentSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReceptionistService
{
    public function getPatientsList(Request $request): array
    {
        $query = Patient::with(['user', 'appointments']);

        // Search qidiruv
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Jinsi bo'yicha filter
        if ($request->filled('gender') && $request->gender !== 'all') {
            $query->where('gender', $request->gender);
        }

        // Tug'ilgan sana oralig'i bo'yicha filter
        if ($request->filled('birth_date_from')) {
            $query->whereDate('birth_date', '>=', $request->birth_date_from);
        }

        if ($request->filled('birth_date_to')) {
            $query->whereDate('birth_date', '<=', $request->birth_date_to);
        }

        $patients = $query->paginate(10);

        $preparedPatients = [];
        foreach ($patients as $patient) {
            $lastAppointment = $patient->appointments()->latest()->first();
            
            $preparedPatients[] = [
                'id' => $patient->id,
                'name' => ($patient->user->last_name ?? '') . ' ' . ($patient->user->name ?? ''),
                'phone' => $patient->user->phone ?? '-',
                'birth_date' => $patient->birth_date ? Carbon::parse($patient->birth_date)->format('d.m.Y') : '-',
                'gender' => $this->getGenderLabel($patient->gender),
                'last_visit' => $lastAppointment ? Carbon::parse($lastAppointment->date)->format('d.m.Y') : '-',
                'total_visits' => $patient->appointments->count(),
            ];
        }

        return [
            'patients' => $preparedPatients,
            'pagination' => $this->preparePagination($patients),
            'doctors' => $this->getDoctors(),
            'stats' => $this->getStats(),
            'available_slots' => $this->getAvailableSlots(Carbon::today()),
            'today' => Carbon::today()->format('Y-m-d'),
        ];
    }

    // Stats metodini qo'shish
    public function getStats(): array
    {
        $today = Carbon::today();
        $weekAgo = Carbon::today()->subDays(7);

        return [
            'total_patients' => Patient::count(),
            'active_patients' => Patient::whereHas('appointments', function($query) use ($weekAgo) {
                $query->where('date', '>=', $weekAgo);
            })->count(),
            'today_appointments' => Appointment::whereDate('date', $today)->count(),
            'pending_appointments' => Appointment::where('status', 'pending')->count(),
        ];
    }

    private function getGenderLabel(?string $gender): string
    {
        if ($gender === 'male') {
            return __('words.male');
        } elseif ($gender === 'female') {
            return __('words.female');
        }
        return '-';
    }

    public function createAppointment(Request $request): array
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'slot_id' => 'required|exists:appointment_slots,id',
            'reason' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        $slot = AppointmentSlot::find($request->slot_id);
        
        if ($slot->status !== 'available') {
            return [
                'success' => false,
                'message' => 'Bu vaqt allaqachon band qilingan',
            ];
        }

        $appointment = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'appointment_slot_id' => $request->slot_id,
            'date' => $request->date,
            'reason' => $request->reason,
            'notes' => $request->notes,
            'status' => 'booked',
            'treatment_type' => 'outpatient',
            'duration' => $slot->staffSchedule->appointment_duration,
        ]);

        $slot->update(['status' => 'booked']);

        return [
            'success' => true,
            'message' => 'Qabul muvaffaqiyatli yaratildi',
            'appointment_id' => $appointment->id,
        ];
    }

    private function getDoctors()
    {
        return Doctor::with(['user', 'departments'])->get()->map(function($doctor) {
            return [
                'id' => $doctor->id,
                'name' => 'Dr. ' . ($doctor->user->last_name ?? '') . ' ' . ($doctor->user->name ?? ''),
                'department' => $doctor->departments->first()->name ?? '-',
            ];
        });
    }

    private function getAvailableSlots(Carbon $date): array
    {
        $slots = AppointmentSlot::with(['staffSchedule'])
            ->whereDate('date', $date)
            ->where('status', 'available')
            ->get();

        $groupedSlots = [];
        foreach ($slots as $slot) {
            $doctorId = $slot->staffSchedule->schedulable_id ?? null;
            if (!$doctorId) continue;

            $doctor = Doctor::with('user')->find($doctorId);
            if (!$doctor) continue;

            if (!isset($groupedSlots[$doctorId])) {
                $groupedSlots[$doctorId] = [
                    'doctor_name' => 'Dr. ' . ($doctor->user->last_name ?? '') . ' ' . ($doctor->user->name ?? ''),
                    'slots' => []
                ];
            }

            $groupedSlots[$doctorId]['slots'][] = [
                'id' => $slot->id,
                'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
            ];
        }

        return array_values($groupedSlots);
    }

    private function preparePagination($items): array
    {
        return [
            'total' => $items->total(),
            'per_page' => $items->perPage(),
            'current_page' => $items->currentPage(),
            'last_page' => $items->lastPage(),
            'first_item' => $items->firstItem(),
            'last_item' => $items->lastItem(),
            'on_first_page' => $items->onFirstPage(),
            'has_more_pages' => $items->hasMorePages(),
            'previous_page_url' => $items->previousPageUrl(),
            'next_page_url' => $items->nextPageUrl(),
            'url' => function($page) use ($items) {
                return $items->url($page);
            }
        ];
    }
}