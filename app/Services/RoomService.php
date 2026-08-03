<?php

namespace App\Services;

use App\Models\Room;
use App\Models\Department;
use App\Models\Hospitalization;
use App\Models\HospitalizationRoom;
use Illuminate\Support\Collection;

class RoomService
{
    /**
     * Xonalar va ularga tegishli ma'lumotlarni olish
     */
    public function getRoomsWithData(): array
    {
        $rooms = Room::with([
            'department',
            'features',
            'roomBeds' => function ($query) {
                $query->where('status', 'available');
            },
            'roomBeds.hospitalizationRooms' => function ($query) {
                $query->whereNull('unassigned_at');
            },
            'roomBeds.hospitalizationRooms.hospitalization.appointment.patient.user',
            'roomBeds.hospitalizationRooms.hospitalization.hospitalizationStaff.doctor.user'
        ])->get();

        $departments = Department::all();
        
        // Xona statistikasi
        $stats = $this->getRoomStats($rooms);
        
        // Waiting patients
        $waitingPatients = $this->getWaitingPatients();

        // Har bir xona uchun ma'lumotlarni tayyorlash
        $roomsData = [];
        foreach ($rooms as $room) {
            $roomsData[] = $this->prepareRoomCardData($room);
        }

        return [
            'rooms' => $rooms,
            'roomsData' => $roomsData,
            'departments' => $departments,
            'stats' => $stats,
            'waitingPatients' => $waitingPatients,
        ];
    }

    /**
     * Xona statistikasini hisoblash
     */
    public function getRoomStats(Collection $rooms): array
    {
        $total = $rooms->count();
        $available = $rooms->where('status', 'available')->count();
        $full = $rooms->where('status', 'full')->count();
        $maintenance = $rooms->where('status', 'maintenance')->count();

        return [
            'total' => $total,
            'available' => $available,
            'full' => $full,
            'maintenance' => $maintenance,
        ];
    }

    /**
     * Xonadagi faol bemorlar ro'yxatini olish
     */
    public function getRoomPatients(Room $room): array
    {
        $patients = [];

        foreach ($room->roomBeds as $bed) {
            $activeRooms = $bed->hospitalizationRooms
                ->whereNull('unassigned_at');

            foreach ($activeRooms as $activeHospitalizationRoom) {
                $hospitalization = $activeHospitalizationRoom->hospitalization;

                if (!$hospitalization || !$hospitalization->appointment?->patient?->user) {
                    continue;
                }

                $patientUser = $hospitalization->appointment->patient->user;

                $selectedDoctor = $this->getDoctorForHospitalization($hospitalization);

                $patients[] = [
                    'patient' => $patientUser,
                    'doctor' => $selectedDoctor,
                    'bed_id' => $bed->id,
                    'hospitalization_id' => $hospitalization->id,
                    'bed_number' => $bed->number,
                    'admission_date' => $activeHospitalizationRoom->assigned_at ?? $hospitalization->created_at
                ];
            }
        }

        return $patients;
    }

    /**
     * Hospitalization uchun shifokorni aniqlash
     */
    public function getDoctorForHospitalization($hospitalization): ?object
    {
        $staff = $hospitalization->hospitalizationStaff;

        if (!$staff || $staff->count() === 0) {
            return null;
        }

        $priorityRoles = [
            'Asosiy shifokor',
            'Yordamchi shifokor',
            'Konsultant',
            'Kunduzgi_smena',
            'Kechki_smena',
        ];

        foreach ($priorityRoles as $role) {
            $found = $staff->firstWhere('role', $role);
            if ($found) {
                return $found->doctor?->user;
            }
        }

        return null;
    }

    /**
     * Xona card uchun ma'lumotlar tayyorlash
     */
    public function prepareRoomCardData(Room $room): array
    {
        $patients = $this->getRoomPatients($room);
        
        // Status badge
        $statusBadge = $this->getStatusBadge($room->status);
        
        // Action buttons
        $actionButtons = $this->getActionButtons($room, $patients);
        
        // Feature list HTML
        $featuresHtml = $this->getFeaturesHtml($room);

        // Patient info HTML
        $patientsHtml = $this->getPatientsHtml($patients);

        return [
            'room' => $room,
            'patients' => $patients,
            'patientsHtml' => $patientsHtml,
            'statusBadge' => $statusBadge,
            'actionButtons' => $actionButtons,
            'featuresHtml' => $featuresHtml,
            'isMaintenance' => $room->status === 'maintenance',
            'bedCount' => $room->roomBeds->where('status', 'occupied')->count(),
            'capacity' => $room->capacity,
            'leftBadgeText' => $room->status === 'empty' ? 'Empty' : $statusBadge['text'],
        ];
    }

    /**
     * Status badge ma'lumotlarini olish
     */
    public function getStatusBadge(string $status): array
    {
        $badges = [
            'empty' => ['class' => 'bg-secondary', 'text' => 'Hona bo\'sh'],
            'available' => ['class' => 'bg-success', 'text' => 'Mavjud'],
            'full' => ['class' => 'bg-warning', 'text' => 'To\'liq'],
            'maintenance' => ['class' => 'bg-danger', 'text' => 'Ta\'mirda'],
        ];

        return $badges[$status] ?? $badges['empty'];
    }

    /**
     * Action tugmalarini olish
     */
    public function getActionButtons(Room $room, array $patients): string
    {
        $html = '';
        
        // View va Edit tugmalari (hamma holatda)
        $html .= '<a href=""><button class="btn-icon"><i class="fas fa-eye"></i></button></a>';
        $html .= '<a href=""><button class="btn-icon"><i class="fas fa-edit"></i></button></a>';

        // Statusga mos qo'shimcha tugmalar
        if ($room->status === 'empty' || $room->status === 'available') {
            $html .= sprintf(
                '<button class="action-btn success assign-patient-btn" data-room-id="%d" data-room-number="%s">
                    <i class="fas fa-user-plus"></i> <span>Bemor</span>
                </button>',
                $room->id,
                $room->number
            );
        }

        if ($room->status === 'available' || $room->status === 'full') {
            $patientsJson = json_encode($patients);
            $html .= sprintf(
                '<button class="action-btn warning discharge-room-btn" 
                    onclick=\'openDischargePatientModal("%d", "%s", %s)\'>
                    <i class="fas fa-sign-out-alt"></i> <span>Bo\'shatish</span>
                </button>',
                $room->id,
                $room->number,
                $patientsJson
            );
        }

        if ($room->status === 'maintenance') {
            $html .= sprintf(
                '<button class="action-btn danger" onclick="openCompleteMaintenanceModal(%d, %s)">
                    <i class="fas fa-check"></i> <span>Tamomlash</span>
                </button>',
                $room->id,
                $room->number
            );
        }

        return $html;
    }

    /**
     * Qulayliklar HTML ni olish
     */
    public function getFeaturesHtml(Room $room): string
    {

        $html = '<button class="feature-btn" onclick="toggleFeatures(this)">
                    <i class="fas fa-star"></i>
                    <span>' . $room->features->count() . ' Qulaylik</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="features-list" id="features-' . $room->id . '">';

        foreach ($room->features as $feature) {
            $html .= sprintf(
                '<div class="feature-item">
                    <i class="%s"></i>
                    %s
                </div>',
                $feature->icon ?? 'fas fa-check-circle',
                $feature->name
            );
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Patient info HTML ni olish
     */
    public function getPatientsHtml(array $patients): string
    {
        if (empty($patients)) {
            return '';
        }

        $html = '';
        foreach ($patients as $item) {
            $html .= '<div class="patient-info">';
            $html .= '<strong>';
            $html .= strtoupper(substr($item['patient']->name, 0, 1)) . ' ';
            $html .= $item['patient']->last_name;
            $html .= '</strong>';
            
            if ($item['doctor']) {
                $html .= '<small>';
                $html .= '(' . $item['doctor']->last_name . ' ';
                $html .= strtoupper(substr($item['doctor']->name, 0, 1)) . '.)';
                $html .= '</small>';
            }
            
            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Waiting patients uchun ma'lumotlar
     */
    public function getWaitingPatients(): array
    {
        // HospitalizationRoom orqali kutayotgan bemorlarni olish
        $waitingPatients = Hospitalization::where('status', 'waiting_for_bed')
        ->with(['appointment.patient.user', 'appointment.doctor.user'])
        ->get();

        $result = [];
        foreach ($waitingPatients as $waiting) {
            $hospitalization = $waiting;
            if (!$hospitalization || !$hospitalization->appointment) {
                continue;
            }

            $appointment = $hospitalization->appointment;
            $patient = $appointment->patient;
            
            if (!$patient || !$patient->user) {
                continue;
            }

            $doctor = $this->getDoctorForHospitalization($hospitalization);

            $result[] = [
                'id' => $hospitalization->id,
                'patient_name' => $patient->user->name . ' ' . $patient->user->last_name,
                'patient_phone' => $patient->user->phone ?? '',
                'doctor_name' => $doctor?->last_name . ' ' .   mb_substr($doctor?->name,0,1)?? '--',
                'department_name' => $hospitalization->department->name ?? '',
                'priority' => $urgency = $this->waitingPatientUrgency($hospitalization),
                'waiting_since' => $waiting->created_at?->diffForHumans() ?? '',
                'created_at' => $waiting->created_at?->format('d.m.Y H:i') ?? '',
            ];
        }

        return $result;
    }

    public function waitingPatientUrgency ($hospitalization) {
        $urgency = [
            'normal' => [
                'text' => 'Normal',
            ],
            'urgent' => [
                'text' => 'Shoshilinch',
            ],
            'emergency' => [
                'text' => 'Favqulodda',
            ],

        ];
        return $urgency[$hospitalization->urgency]['text'];
    }

    /**
     * Xonalarni filter qilish
     */
    public function filterRooms(Collection $rooms, array $filters): Collection
    {
        return $rooms->filter(function ($room) use ($filters) {
            $matchFloor = empty($filters['floor']) || $room->floor == $filters['floor'];
            $matchStatus = empty($filters['status']) || $room->status == $filters['status'];
            $matchDepartment = empty($filters['department']) || $room->department_id == $filters['department'];
            
            return $matchFloor && $matchStatus && $matchDepartment;
        });
    }
}