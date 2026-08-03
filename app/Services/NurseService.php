<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User; 
use App\Models\Nurse;
use App\Models\Department;
use App\Models\HospitalizationPrescriptionAdministration;
use App\Models\HospitalizationPrescriptionItem;
use App\Models\HospitalizationPrescriptionItemSlot;
use App\Models\HospitalizationProcedure;
use App\Models\HospitalizationProcedureAdministration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class NurseService
{
    public function getFilteredNurses(Request $request): array
    {
        $query = Nurse::with(['user', 'department']);
    
        // Qidiruv
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
    
        // Holati bo'yicha filter
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('nurses.status', $request->status);
        }
    
        // Bo'lim bo'yicha filter
        if ($request->filled('department') && $request->department != 'all') {
            $query->where('department_id', $request->department);
        }
    
        // Ishga kirgan sana oralig'i
        if ($request->filled('date_from')) {
            $query->whereDate('nurses.created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('nurses.created_at', '<=', $request->date_to);
        }
    
        $nurses = $query->paginate(10)->withQueryString();
        $departments = Department::all();
        
        return [
            'nurses' => $nurses,
            'departments' => $departments,
            'stats' => $this->getStats($nurses),
            'nursesWithStatus' => $this->prepareNursesWithStatus($nurses)
        ];
    }
    
    public function getStats($nurses): array
    {
        return [
            'total' => $nurses->total(),
            'active' => $nurses->where('status', 'active')->count(),
            'on_leave' => $nurses->where('status', 'on_leave')->count(),
            'inactive' => $nurses->where('status', 'inactive')->count()
        ];
    }
    
    public function prepareNursesWithStatus($nurses): array
    {
        $result = [];
        foreach ($nurses as $nurse) {
            $statusInfo = $this->getStatusInfo($nurse->status);

            // Department nomini tilga qarab olish
            $locale = App::getLocale();
            $departmentName = null;
            if ($nurse->department) {
                $departmentName = match($locale) {
                    'uz' => $nurse->department->name_uz,
                    'ru' => $nurse->department->name_ru,
                    'en' => $nurse->department->name_en,
                    default => $nurse->department->name_uz
                };
            }

            $result[] = [
                'id' => $nurse->id,
                'user' => [
                    'name' => $nurse->user->name,
                    'last_name' => $nurse->user->last_name,
                    'middle_name' => $nurse->user->middle_name,
                    'login' => $nurse->user->login,
                    'phone' => $nurse->user->phone,
                    'avatar' => substr($nurse->user->name, 0, 1) . substr($nurse->user->last_name, 0, 1)
                ],
                'department' => $departmentName,
                'experience_years' => $nurse->experience_years,
                'created_at' => [
                    'formatted' => $nurse->created_at->format('d.m.Y'),
                    'diff' => $nurse->created_at->diffForHumans()
                ],
                'status' => $nurse->status,
                'status_text' => $statusInfo['text'],
                'status_bg_color' => $statusInfo['bg_color'],
                'status_text_color' => $statusInfo['text_color'],
                'status_icon' => $statusInfo['icon'],
                'role' => 'Hamshira',
                'unread_notifications' => $nurse->user
                    ? $nurse->user->unreadNotifications()->count()
                    : 0,
                
            ];
        }
        return $result;
    }
    
    public function getStatusInfo(string $status): array
    {
        return match($status) {
            'active' => [
                'text' => 'Faol',
                'bg_color' => 'rgba(46, 204, 113, 0.2)',
                'text_color' => '#27ae60',
                'icon' => 'fas fa-circle-check'
            ],
            'on_leave' => [
                'text' => "Ta'tilda",
                'bg_color' => '#FFFACD',
                'text_color' => '#B8860B',
                'icon' => 'fas fa-umbrella-beach'
            ],
            'inactive' => [
                'text' => 'Nofaol',
                'bg_color' => '#FFCBCB',
                'text_color' => '#dc3545',
                'icon' => 'fas fa-circle-xmark'
            ],
            default => [
                'text' => 'Faol',
                'bg_color' => 'rgba(46, 204, 113, 0.2)',
                'text_color' => '#27ae60',
                'icon' => 'fas fa-circle-check'
            ]
        };
    }

    public function generateLogin(): string
    {
        $lastUser = User::where('login', 'regexp', '^[0-9]+$')
                        ->orderBy('login', 'desc')
                        ->first();
        
        if ($lastUser && is_numeric($lastUser->login)) {
            $newLogin = (int)$lastUser->login + 1;
        } else {
            $newLogin = 440231100200;
        }
        
        while (User::where('login', $newLogin)->exists()) {
            $newLogin = is_numeric($newLogin) ? $newLogin + 1 : 440231100200;
        }
        
        return (string)$newLogin;
    }

    public function clearNursesCache(): void
    {
        Cache::tags(['nurses'])->flush();
    }

    /**
     * Nurse ma'lumotlarini SHOW uchun formatlash
     */
    public function formatNurseForView(Nurse $nurse): object
    {
        $statusConfig = $this->getFullStatusConfig($nurse->status);
        $user = $nurse->user;
        
        $fullName = $user->name . ' ' . $user->last_name;
        $avatarInitials = substr($user->name, 0, 1) . substr($user->last_name, 0, 1);
        
        $createdAt = Carbon::parse($nurse->created_at);
        $updatedAt = Carbon::parse($nurse->updated_at);
        
        $birthDate = null;
        $age = null;
        if ($nurse->birth_date) {
            $birthDateObj = Carbon::parse($nurse->birth_date);
            $birthDate = $birthDateObj->format('d.m.Y');
            $age = $birthDateObj->age;
        }
        
        $email = $user->email ?? $user->login . '@hospital.uz';
        $address = $nurse->address ?? __('words.not_available');
        $description = $nurse->description ?? __('words.no_additional_info');
        $statusChangedAt = $nurse->status_changed_at ? Carbon::parse($nurse->status_changed_at) : null;
        $formattedId = 'NRS-' . str_pad($nurse->id, 5, '0', STR_PAD_LEFT);
        
        $timelineItems = [
            [
                'icon' => 'fas fa-user-plus',
                'title' => __('words.added_to_system'),
                'date' => $createdAt->format('d.m.Y H:i'),
                'description' => __('words.nurse$nurse_added_description')
            ],
            [
                'icon' => 'fas fa-calendar-check',
                'title' => __('words.hired_date'),
                'date' => $createdAt->format('d.m.Y'),
                'description' => __('words.started_professional_activity')
            ]
        ];
        
        if ($statusChangedAt) {
            $timelineItems[] = [
                'icon' => 'fas fa-sync-alt',
                'title' => __('words.status_updated'),
                'date' => $statusChangedAt->format('d.m.Y H:i'),
                'description' => $statusConfig['timeline_text']
            ];
        }
        
        $timelineItems[] = [
            'icon' => 'fas fa-edit',
            'title' => __('words.last_updated'),
            'date' => $updatedAt->format('d.m.Y H:i'),
            'description' => __('words.data_last_updated')
        ];
        
        return (object) [
            'status_text' => $statusConfig['text'],
            'status_badge_style' => $statusConfig['badge_style'],
            'status_icon' => $statusConfig['icon'],
            'full_name' => $fullName,
            'avatar_initials' => $avatarInitials,
            'login' => $user->login,
            'phone' => $user->phone,
            'email' => $email,
            'specialization' => $nurse->specialization ?? __('words.not_specified'),
            'experience_years' => $nurse->experience_years,
            'address' => $address,
            'description' => $description,
            'formatted_id' => $formattedId,
            'created_at_date' => $createdAt->format('d.m.Y'),
            'created_at_datetime' => $createdAt->format('d.m.Y H:i'),
            'updated_at_datetime' => $updatedAt->format('d.m.Y H:i'),
            'birth_date' => $birthDate,
            'age' => $age,
            'has_birth_date' => (bool) $birthDate,
            'has_status_changed' => (bool) $statusChangedAt,
            'status_changed_at' => $statusChangedAt?->format('d.m.Y H:i'),
            'timeline_items' => $timelineItems,
            'print_status_text' => $this->getPrintStatusText($nurse->status),
        ];
    }

    /**
     * Full status konfiguratsiyasi (SHOW uchun)
     */
    private function getFullStatusConfig(string $status): array
    {
        return match($status) {
            'active' => [
                'text' => __('words.active'),
                'badge_style' => 'background-color: rgba(46, 204, 113, 0.15); color: #27ae60; border-color: rgba(46, 204, 113, 0.3);',
                'icon' => 'fas fa-circle-check',
                'timeline_text' => __('words.status_changed_to_active')
            ],
            'inactive' => [
                'text' => __('words.inactive'),
                'badge_style' => 'background-color: rgba(231, 76, 60, 0.15); color: #dc3545; border-color: rgba(231, 76, 60, 0.3);',
                'icon' => 'fas fa-circle-xmark',
                'timeline_text' => __('words.status_changed_to_inactive')
            ],
            'on_leave' => [
                'text' => __('words.on_leave'),
                'badge_style' => 'background-color: rgba(243, 156, 18, 0.15); color: #f39c12; border-color: rgba(243, 156, 18, 0.3);',
                'icon' => 'fas fa-umbrella-beach',
                'timeline_text' => __('words.status_changed_to_on_leave')
            ],
            default => [
                'text' => __('words.active'),
                'badge_style' => 'background-color: rgba(46, 204, 113, 0.15); color: #27ae60; border-color: rgba(46, 204, 113, 0.3);',
                'icon' => 'fas fa-circle-check',
                'timeline_text' => __('words.status_changed_to_active')
            ],
        };
    }

    /**
     * Print uchun status text
     */
    public function getPrintStatusText(string $status): string
    {
        return match($status) {
            'active' => __('words.active'),
            'inactive' => __('words.inactive'),
            'on_leave' => __('words.on_leave'),
            default => __('words.active'),
        };
    }

    // ============================================================
    // NURSE TREATMENT SHEET
    // ============================================================
    
    public function getNurseTreatmentSheet()
    {
        $authUser = auth()->user();
        $nurse = Nurse::where('user_id', $authUser->id)->first();
        $today = Carbon::today();

        // Dorilar va proceduralarni olish
        $medicineSlots = $this->getMedicineSlots($nurse, $today);
        $procedures = $this->getProcedures($nurse, $today);


        // Barchasini bitta kolleksiyaga yig'ish
        $allTreatments = collect()
            ->merge($medicineSlots)
            ->merge($procedures)
            ->sortBy('scheduled_at')
            ->values();

            // dd($allTreatments);

        // Pagination uchun
        $perPage = 15;
        $currentPage = request()->get('page', 1);

        $treatments = new LengthAwarePaginator(
            $allTreatments->forPage($currentPage, $perPage),
            $allTreatments->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        $formattedTreatments = $this->formatTreatments($treatments);

        return [
            'formattedTreatments' => $formattedTreatments,
            'treatments' => $treatments,
        ];
    }

    private function formatTreatments($treatments)
    { 
        $formatted = [];

        foreach ($treatments as $treatment) {
            $type = $treatment['type'];
            // dd($type);
            $slot = $treatment['model'];

            $data = $type === 'procedure'
                ? $this->formatProcedure($slot)
                : $this->formatMedicine($slot);

            $statusInfo = $this->getTreatmentStatusInfo($data['status']);

            $formatted[] = [
                'id' => $slot->id,
                'time' => Carbon::parse($treatment['scheduled_at'])->format('H:i'),
                'room' => $data['room'],
                'bed' => $data['bed'],
                'room_bed' => $data['room'] . ' | ' . $data['bed'],
                'patient_name' => $data['patient_name'],
                'type_text' => $type === 'procedure' ? __('words.procedure_nurse') : __('words.medicine'),
                'name' => $data['name'],
                'dose' => $data['dose'],
                'strength' => $data['strength'],
                'status' => $data['status'],
                'status_text' => $statusInfo['text'],
                'status_color' => $statusInfo['color'],
                'status_bg_color' => $statusInfo['bg_color'],
                'status_text_color' => $statusInfo['text_color'],
                'is_select_disabled' => in_array($data['status'], ['given', 'completed', 'skipped', 'stopped', 'resumed']),
                'skip_reason' => $data['skip_reason'],
                'type' => $type,
                'model' => $slot,
            ];
        }

        return $formatted;
    }

    private function formatProcedure($slot)
    {
        $hospitalization = $slot->hospitalization;
        $appointment = $hospitalization->appointment;
        $patientUser = optional($appointment->patient->user);

        return [
            'room' => $slot->room->number,
            'bed' => data_get($hospitalization, 'currentRoom.bed.bed_number'),
            'patient_name' => $patientUser->last_name . '. ' . strtoupper(substr($patientUser->name, 0, 1)),
            'name' => $slot->procedure->name_uz ?? '-',
            'dose' => ($slot->procedure->duration ?? '-') .  __('words.minutes'),
            'strength' => '-',
            'status' => $slot->status,
            'skip_reason' => $slot->skip_reason ?? '',
        ];
    }

    private function formatMedicine($slot)
    {
        $hospitalization = $slot->item->prescription->hospitalization;
        $appointment = $hospitalization->appointment;
        $patientUser = optional($appointment->patient->user);
        $medicine = optional($slot->item->medicine);
        

        return [
            'room' => data_get($hospitalization, 'currentRoom.bed.room.number'),
            'bed' => data_get($hospitalization, 'currentRoom.bed.bed_number'),
            'patient_name' => $patientUser->last_name . '. ' . strtoupper(substr($patientUser->name, 0, 1)),
            'name' => $medicine->name . ' | ' . $medicine->strength_value . ' ' . $medicine->strength_unit,
            'dose' => $slot->item->dose_amount . ' ' . $medicine->form,
            'strength' => $medicine->strength_value . ' ' . $medicine->strength_unit,
            'status' => $slot->status,
            'skip_reason' => $slot->skip_reason ?? '',
        ];
    }

    private function getMedicineSlots($nurse, $today)
    {
        return HospitalizationPrescriptionItemSlot::whereDate('scheduled_at', $today)
            ->whereHas('item.prescription.hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
                $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
            })
            ->with([
                'item.medicine',
                'item.prescription.hospitalization.appointment.patient.user',
                'item.prescription.hospitalization.currentRoom.bed.room'
            ])
            ->get()
            ->map(function ($slot) {
                return [
                    'type'         => 'medicine',
                    'scheduled_at' => $slot->scheduled_at,
                    'status'       => $slot->status,
                    'model'        => $slot,
                ];
            });
    }

    private function getProcedures($nurse, $today)
    {
        return HospitalizationProcedure::whereDate('assigned_at', $today)
            ->whereHas('hospitalization.hospitalizationStaff', function ($q) use ($nurse) {
                $q->where('staff_id', $nurse->id)->where('staff_type', Nurse::class);
            })
            ->with([
                'procedure',
                'hospitalization.appointment.patient.user',
                'hospitalization.currentRoom.bed.room'
            ])
            ->get()
            ->map(function ($procedure) {
                return [
                    'type'         => 'procedure',
                    'scheduled_at' => $procedure->assigned_at,
                    'status'       => $procedure->status ?? null,
                    'model'        => $procedure,
                ];
            });
    }

    private function getTreatmentStatusInfo($status)
    {
        $statuses = [
            'pending' => [
                'text' => __('words.pending'), 
                'color' => '#ffc107', 
                'bg_color' => '#ffc107', 
                'text_color' => '#856404'
            ],
            'completed' => [
                'text' => __('words.ready'), 
                'color' => '#28a745', 
                'bg_color' => '#28a745', 
                'text_color' => 'white'
            ],

            'given' => [
                'text' => __('words.prescribed'), 
                'color' => '#28a745', 
                'bg_color' => '#28a745', 
                'text_color' => 'white'
            ],

            'resumed' => [
                'text' => __('words.continued'), 
                'color' => '#17a2b8', 
                'bg_color' => '#17a2b8', 
                'text_color' => 'white'
            ],
            'skipped' => [
                'text' => __('words.skipped'), 
                'color' => '#dc3545', 
                'bg_color' => '#dc3545', 
                'text_color' => 'white'
            ],
            'stopped' => [
                'text' => __('words.stopped'), 
                'color' => '#6c757d', 
                'bg_color' => '#6c757d', 
                'text_color' => 'white'
            ],
        ];
        
        return $statuses[$status] ?? $statuses['pending'];
    }

    public function clearTreatmentCache($nurseId = null)
    {
        if ($nurseId) {
            Cache::tags(["nurse_{$nurseId}"])->flush();
        } else {
            $authUser = auth()->user();
            $nurse = Nurse::where('user_id', $authUser->id)->first();
            if ($nurse) {
                Cache::tags(["nurse_{$nurse->id}"])->flush();
            }
        }
    }

    // treatment-sheet store

    public function updateSlot($slotId, $type, $status, $reason = null)
    {
        // dd($slotId, $type, $status, $reason);
        $allowed = ['pending', 'completed', 'given', 'skipped', 'stopped', 'resumed'];
        $needReason = ['skipped', 'stopped'];

        if (!in_array($status, $allowed)) {
            return ['type' => 'error', 'message' => 'Noto\'g\'ri status'];
        }

        return DB::transaction(function () use ($slotId, $type, $status, $reason, $needReason) {

            $skipReason = in_array($status, $needReason) ? $reason : null;

            // ===================== PROCEDURE =====================
            if ($type === 'procedure') {

                $procedure = HospitalizationProcedure::find($slotId);

                if (!$procedure) {
                    return ['type' => 'error', 'message' => 'Procedure topilmadi'];
                }

                if ($procedure->status !== 'pending') {
                    return ['type' => 'error', 'message' => 'Procedure allaqachon bajarilgan'];
                }

                HospitalizationProcedureAdministration::updateOrCreate(
                    [
                        'hospitalization_procedure_id' => $procedure->id,
                    ],
                    [
                        'hospitalization_id'      => $procedure->hospitalization_id,
                        'patient_id'              => $procedure->patient_id,
                        'administered_by_type'    => Nurse::class,
                        'administered_by_id'      => auth()->id(),
                        'administration_at'       => now(),
                        'status'                  => $status,      // given, skipped, stopped...
                        'notes'                   => $skipReason,
                    ]
                );
                
                // Procedure umumiy holatini yangilash
                $procedure->update([
                    'status' => 'completed',
                ]);

                return [
                    'type' => 'success',
                    'message' => 'Procedure muvaffaqiyatli saqlandi'
                ];
            }

            // ===================== MEDICINE =====================
            $slot = HospitalizationPrescriptionItemSlot::find($slotId);

            if (!$slot) {
                return ['type' => 'error', 'message' => 'Slot topilmadi'];
            }

            if ($slot->status !== 'pending') {
                return ['type' => 'error', 'message' => 'Slot allaqachon bajarilgan'];
            }

            HospitalizationPrescriptionAdministration::updateOrCreate(
                [
                    'hospitalization_prescription_item_id' => $slot->hospitalization_prescription_item_id,
                    'hospitalization_prescription_item_slot_id' => $slot->id,
                ],
                [
                    'administered_by_type' => 'Doctor',
                    'administered_by_id' => auth()->id(),
                    'administered_at' => $slot->scheduled_at ?? now(),
                    'status' => $status,
                    'skip_reason' => $skipReason,
                ]
            );

            $slot->update([
                'status' => $status,
                'skip_reason' => $skipReason,
            ]);

            $this->updateItem($slot->hospitalization_prescription_item_id);

            $this->clearCache();

            return [
                'type' => 'success',
                'message' => 'Muvaffaqiyatli saqlandi'
            ];
        });
    }

    private function updateItem($itemId)
    {
        $item = HospitalizationPrescriptionItem::find($itemId);
        
        if (!$item || !$item->slots()->exists()) {
            return;
        }

        $statuses = $item->slots()->pluck('status');
        $hasStopped = $statuses->contains('stopped');
        $hasResumed = $statuses->contains('resumed');
        $lastSlot = $item->slots()->latest('scheduled_at')->first();
        $isLastGiven = $lastSlot && $lastSlot->status === 'given';

        $item->update(
            $hasStopped && !$hasResumed ? ['status' => 'stopped', 'end_at' => now()] :
            ($hasResumed && $item->status === 'stopped' ? ['status' => 'active', 'end_at' => null] :
            ($isLastGiven ? ['status' => 'completed', 'end_at' => now()] :
            (!in_array($item->status, ['stopped', 'completed']) ? ['status' => 'active', 'end_at' => null] : [])))
        );
    }

    private function clearCache()
    {
        $nurse = auth()->user()->nurse;
        
        if ($nurse) {
            Cache::tags(["nurse_{$nurse->id}"])->flush();
        }
    }
}