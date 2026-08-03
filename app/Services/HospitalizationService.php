<?php

namespace App\Services;

use App\Models\Hospitalization;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Room;
use App\Models\Test;
use App\Models\Panel;
use App\Models\Medicine;
use App\Models\Procedure;
use App\Models\HospitalizationProcedure;
use App\Models\HospitalizationStaff; 
use App\Models\HospitalizationOrder;
use App\Models\HospitalizationOrderItem;
use App\Models\HospitalizationPrescription;
use App\Models\HospitalizationPrescriptionItemSlot;
use App\Models\HospitalizationPrescriptionAdministration;
use App\Models\HospitalizationRoom;
use App\Models\BedRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;

class HospitalizationService
{
    public function getHospitalizations(Request $request, $user)
    {
        $cacheKey = $this->generateCacheKey($request, $user);
        
        return Cache::remember($cacheKey, 600, function () use ($request, $user) { 
            $query = Hospitalization::query();
            
            $this->applyRoleFilter($query, $user);
            $this->applySearchFilter($query, $request);
            $this->applyStatusFilter($query, $request);
            $this->applyDepartmentFilter($query, $request);
            
            return $query->with([
                'appointment.patient.user',
                'department',
                'hospitalizationRooms.bed.room'
            ])
            ->orderByRaw("
                CASE status
                    WHEN 'waiting_for_bed' THEN 1
                    WHEN 'under_treatment' THEN 2
                    WHEN 'discharged' THEN 3
                    ELSE 4
                END
            ")
            ->latest()
            ->paginate(10);
        });
    }
    
    public function getDepartments()
    {
        return Cache::remember('departments_all', 3600, function () {
            return Department::all();
        });
    }
    
    public function getStats($user = null)
    {
        if ($user && !$user->hasRole('admin')) {
            return $this->getUserStats($user);
        }
        
        return Cache::remember('hospitalization_stats', 3600, function () {
            return [
                [
                    'value' => Hospitalization::count(),
                    'label' => 'Jami Bemorlar',
                    'icon' => 'fas fa-procedures',
                    'class' => ''
                ],
                [
                    'value' => Hospitalization::where('status', 'under_treatment')->count(),
                    'label' => 'Faol Bemorlar',
                    'icon' => 'fas fa-heartbeat',
                    'class' => 'underTreatment'
                ],
                [
                    'value' => Hospitalization::where('status', 'waiting_for_bed')->count(),
                    'label' => 'Navbatdagilar',
                    'icon' => 'fas fa-clock',
                    'class' => 'waitForBed'
                ]
            ];
        });
    }
    
    /**
     * ========== HOSPITALIZATION SHOW PAGE METHODS ==========
     */
    
    /**
     * Get all data for hospitalization show page
     */
    public function getShowPageData(Hospitalization $hospitalization)
    {
        $doctors = Doctor::all();
        $nurses = Nurse::all();
        
        $rooms = Room::where('status', '!=', 'full')
            ->whereHas('roomBeds', function ($q) {
                $q->where('status', 'available');
            })
            ->with(['roomBeds' => function ($q) {
                $q->where('status', 'available');
            }])
            ->get();
            
        $tests = Test::all();
        $testPanels = Panel::all();
        $medicines = Medicine::all();
        $procedures = Procedure::all();
    
        $hospitalizationProcedures = HospitalizationProcedure::with([
            'procedure',
            'patient',
            'room',
            'staffType'
        ])
        ->where('hospitalization_id', $hospitalization->id)
        ->get();
    
        $hospitalizationStaff = HospitalizationStaff::with('staff.user')
            ->where('hospitalization_id', $hospitalization->id)
            ->get();
    
        $orderItems = HospitalizationOrderItem::with([
            'order.doctor',
            'results.test',
            'test',
            'panel'
        ])->whereHas('order', function ($q) use ($hospitalization) {
            $q->where('hospitalization_id', $hospitalization->id);
        })->get();
        
        $sortedStaff = $this->getSortedStaff($hospitalization);
        $medicationData = $this->getMedicationItems($hospitalization);
        $medicationModalData = $this->getMedicationModalData($medicationData['prescriptions']);
        $roomAssignments = $this->getRoomAssignments($hospitalization);
        
        $testItems = $this->prepareTestItems($orderItems);
        $procedureItems = $this->prepareProcedureItems($hospitalizationProcedures, $hospitalizationStaff);
    
        return [
            'hospitalization' => $hospitalization,
            'doctors' => $doctors,
            'nurses' => $nurses,
            'rooms' => $rooms,
            'hospitalizationStaff' => $hospitalizationStaff,
            'tests' => $tests,
            'testPanels' => $testPanels,
            'orderItems' => $orderItems,
            'testItems' => $testItems,
            'medicines' => $medicines,
            'procedures' => $procedures,
            'hospitalizationProcedures' => $hospitalizationProcedures,
            'procedureItems' => $procedureItems,
            'sortedStaff' => $sortedStaff,
            'medicationItems' => $medicationData['items'],
            'medicationTotalCount' => $medicationData['totalCount'],
            'medicationPrescriptions' => $medicationData['prescriptions'],
            'medicationModalData' => $medicationModalData,
            'roomAssignments' => $roomAssignments,
        ];
    }

    /**
     * Hospitalization Doctors uchun
     */
    public function getSortedStaff(Hospitalization $hospitalization)
    {
        $rolesOrder = [
            'Asosiy shifokor',
            'Konsultant',
            'Yordamchi shifokor',
            'Kunduzgi smena',
            'Kechki smena',
        ];

        return $hospitalization->hospitalizationStaff
            ->sortBy(fn($item) =>
                array_search($item->role, $rolesOrder) !== false
                    ? array_search($item->role, $rolesOrder)
                    : 999
            )
            ->map(fn($item) => $this->formatStaffItem($item))
            ->values();
    }

    private function formatStaffItem($item): array
    {
        $user = $item->staff->user;

        $firstName = $user->name ?? '';
        $lastName = $user->last_name ?? '';

        return [
            'id' => $item->id,
            'avatar' => mb_substr($firstName, 0, 1) . mb_substr($lastName, 0, 1),
            'full_name' => trim($lastName . ' ' . $firstName),
            'role_text' => $user->roles->pluck('name')->first() ?? '—',
            'specialization' => $item->staff->specialization ?? '—',
            'role_badge' => $item->role ?? '—',
            'type_label' => class_basename($item->staff_type),
            'phone' => $user->phone ?? '—',
        ];
    }

    /**
     * Get prescriptions with items
     */
    public function getPrescriptions(Hospitalization $hospitalization)
    {
        return $hospitalization->prescriptions()
            ->with(['items.medicine', 'prescribedBy.user'])
            ->get();
    }

    /**
     * Hospitalization Medicine(Display) uchun
     */
    public function getMedicationItems(Hospitalization $hospitalization)
    {
        $prescriptions = $this->getPrescriptions($hospitalization);
        $items = [];
        $totalCount = 0;

        foreach ($prescriptions as $prescription) {
            foreach ($prescription->items as $item) {
                $totalCount++;
                
                $status = $this->getpPrescriptionStatus($item);
                $medicineInfo = $this->getMedicineInfo($item);
                $usageText = $this->getUsageText($item);
                $prescribedBy = $this->getPrescribedBy($prescription);
                $prescribedByRole = $this->getPrescribedByRole($prescription);
                $getMedicineDuration = $this->getMedicineDurationInfo($item);
                
                $rowClass = $this->getRowClass($item);
                
                $items[] = [
                    'id' => $item->id,
                    'iteration' => count($items) + 1, 
                    
                    // Medicine Info
                    'medicine_name' => $medicineInfo['medicine_name'],
                    'dosage' => $medicineInfo['dosage'],
                    'form' => $medicineInfo['form'],
                    'status' => $status,

                    // Status
                    'statusColor' => $status['color'],
                    'bgColor' => $status['bg-color'],
                    'statusIcon' => $status['icon'],
                    'statusText' => $status['text'],

                    'usageText' => $usageText,

                    'duration_days' => $getMedicineDuration,

                    'start_at' => $item->start_at,
                    'end_at' => $item->end_at,
                    'prescribedBy' => $prescribedBy,
                    'rowClass' => $rowClass,
                    'start_at_format' => $item->start_at->format('d M'),
                    'end_at_format' => $item->end_at ? $item->end_at->format('d M') : 'hozirgacha',
                    'start_date_format' => $item->start_at->format('d.m.Y'),
                ];
            }
        }
        
        return [
            'items' => $items,
            'totalCount' => $totalCount,
            'prescriptions' => $prescriptions
        ];
    }

    private function getpPrescriptionStatus($item): array
    {
        
        return match ($item->status) {
            'active' => [
                'text' => __('words.active'),
                'color' => '#f39c12',
                'bg-color' => '#fef9e7',
                'icon'  => 'fas fa-clock',
            ],
            'pending' => [
                'text' => __('words.in_progress'),
                'color' => '#f39c12',
                'bg-color' => '#fef9e7',
                'icon'  => 'fas fa-clock',
            ],
            'completed' => [
                'text' => __('words.completed'),
                'color' => '#28a745',
                'bg-color' => '#e8f8f5',
                'icon'  => 'fas fa-check-circle',
            ],
            'stopped' => [
                'text' => __('words.cancelled'),
                'color' => '#e74c3c',
                'bg-color' => '#fdedec',
                'icon'  => 'fas fa-circle-xmark',
            ],
            'as_needed' => [
                'text' => 'Ehtiyoj bo\'lganda',
                'color' => '#00BFFF',
                'bg-color' => '#E6F7FF',
                'icon'  => 'fa-solid fa-calendar-plus',
            ],
            'once' => [
                'text' => 'Bir marta',
                'color' => '#00BFFF',
                'bg-color' => '#E6F7FF',
                'icon'  => 'fa-solid fa-bolt',
            ],
            default => [
                'text' => ucfirst($item->status),
                'class' => 'status-unknown',
                'color' => '#6c757d',
                'bg-color' => '#f8f9fa',
                'icon'  => 'fa-regular fa-circle-question'
            ],
        };
    }

    private function getUsageText($item): string
    {
        $locale = app()->getLocale();
        
        if ($locale == 'uz') {
            if ($item->frequency_type == 'daily') {
                return "Kuniga {$item->frequency_value} marta";
            } elseif ($item->frequency_type == 'hourly') {
                return "Har {$item->frequency_value} soatda";
            } elseif ($item->frequency_type == 'weekly') {
                return "Haftasiga {$item->frequency_value} marta";
            } elseif ($item->frequency_type == 'interval') {
                return "Har {$item->frequency_value} kunda";
            } elseif ($item->frequency_type == 'once') {
                return "Bir marta";
            } elseif ($item->frequency_type == 'as_needed') {
                return "Ehtiyoj bo'lganda";
            }
        } 
        elseif ($locale == 'ru') {
            if ($item->frequency_type == 'daily') {
                return "{$item->frequency_value} раз в день";
            } elseif ($item->frequency_type == 'hourly') {
                return "Каждые {$item->frequency_value} часов";
            } elseif ($item->frequency_type == 'weekly') {
                return "{$item->frequency_value} раз в неделю";
            } elseif ($item->frequency_type == 'interval') {
                return "Каждые {$item->frequency_value} дней";
            } elseif ($item->frequency_type == 'once') {
                return "Один раз";
            } elseif ($item->frequency_type == 'as_needed') {
                return "По необходимости";
            }
        }
        else {
            if ($item->frequency_type == 'daily') {
                return "{$item->frequency_value} times per day";
            } elseif ($item->frequency_type == 'hourly') {
                return "Every {$item->frequency_value} hours";
            } elseif ($item->frequency_type == 'weekly') {
                return "{$item->frequency_value} times per week";
            } elseif ($item->frequency_type == 'interval') {
                return "Every {$item->frequency_value} days";
            } elseif ($item->frequency_type == 'once') {
                return "Once";
            } elseif ($item->frequency_type == 'as_needed') {
                return "As needed";
            }
        }
        
        return '';
    }

    private function getPrescribedBy($prescription): string
    {
        $user = $prescription->prescribedBy->user ?? null;

        return $user
            ? trim(($user->last_name ?? '') . ' ' . ($user->name ?? ''))
            : '';
    }

    private function getPrescribedByRole($prescription): string
    {
        return match ($prescription->prescribed_by_type) {
            'doctor' => 'Shifokor',
            'nurse' => 'Hamshira',
            default => '--',
        };
    }

    private function getMedicineInfo($item): array
    {
        $medicine = $item->medicine;

        return [
            'medicine_name' => $medicine->name,
            'dosage' => $medicine->strength_value . ' ' . $medicine->strength_unit,
            'form' => $medicine->form,
        ];
    }

    private function getMedicineDurationInfo($item): string
    {
        return match ($item->frequency_type) {
            'as_needed' => 'Cheksiz',
            'once' => 'Bir marta',
            default => $item->duration_days .  __('words.days'),
        };
    }

    private function getRowClass($item): string
    {
        return in_array($item->frequency_type, ['as_needed', 'once'])
            ? 'non-scheduled-row'
            : '';
    }

    /**
     * Get medication modal data for all items
     */
    public function getMedicationModalData($prescriptions)
    {
        $modalData = [];
    
        foreach ($prescriptions as $prescription) {
            foreach ($prescription->items as $item) {
    
                $medicine = $item->medicine;
                $dosage = $medicine->strength_value . ' ' . $medicine->strength_unit;
                $form = $medicine->form;
    
                $statusData = $this->getStatusData($item);
                $usageText = $this->getUsageText($item);
                $prescribedBy = $this->getPrescribedBy($prescription);
                $prescribedByRole = $this->getPrescribedByRole($prescription) ?? '--';
                $scheduleInfo = $this->getScheduleInfo($item);
    
                $mainInfo = $this->getMainInfo( $medicine, $dosage, $form, $item );
    
                $slots = $item->slots()
                    ->orderBy('scheduled_at')
                    ->get();
    
                $isItemStopped = $item->status === 'stopped';
                $hasResumedRecord = $slots->where('status', 'resumed')->isNotEmpty();
    
                $slotsData = [];
    
                foreach ($slots as $slot) {
    
                    $slotStatusData = $this->getSlotStatusData($slot->status);
    
                    $slotsData[] = [
                        'id' => $slot->id,
                        'slot_order' => $slot->slot_order,
                        'scheduled_date' => Carbon::parse($slot->scheduled_at)->format('d.m.Y'),
                        'scheduled_time' => Carbon::parse($slot->scheduled_at)->format('H:i'),
                        'status' => $slot->status,
                        'statusText' => $slotStatusData['text'],
                        'bgColor' => $slotStatusData['bg'],
                        'textColor' => $slotStatusData['color'],
                        'isSelectDisabled' => in_array(
                            $slot->status,
                            ['given', 'skipped', 'stopped', 'resumed']
                        ),
                        'skip_reason' => $slot->skip_reason,
                    ];
                }
    
                $administeredHistory = [
                    [
                        'date' => now()->subDays(2)->format('d.m.Y'),
                        'time' => '14:30',
                        'reason' => 'Bosh og\'rig\'i',
                        'administered_by' => 'Dr. Ali Valiyev',
                        'notes' => 'O\'rtacha darajadagi og\'riq',
                    ],
                    [
                        'date' => now()->subDays(1)->format('d.m.Y'),
                        'time' => '10:15',
                        'reason' => 'Tana og\'rig\'i',
                        'administered_by' => 'Hamshira Zaynab',
                        'notes' => 'Kechasi uxlay olmagan',
                    ],
                    [
                        'date' => now()->format('d.m.Y'),
                        'time' => '16:45',
                        'reason' => 'Yurak og\'rig\'i',
                        'administered_by' => 'Dr. Sarvinoz Rahimova',
                        'notes' => 'Qisqa muddatli og\'riq',
                    ],
                ];
    
                $modalData[] = [
                    'id' => $item->id,
                    'medicine_name' => $medicine->name,
                    'dosage' => $dosage,
                    'form' => $form,
    
                    'status' => $statusData['status'],
                    'statusColor' => $statusData['color'],
                    'statusIcon' => $statusData['icon'],
                    'statusText' => $statusData['text'],
    
                    'usageText' => $usageText,
                    'prescribedBy' => $prescribedBy,
                    'prescribedByRole' => $prescribedByRole,
                    'scheduleInfo' => $scheduleInfo,
                    'mainInfo' => $mainInfo,
    
                    'start_date_format' => $item->start_at->format('Y.m.d'),
                    'end_at_format' => $item->end_at
                        ? $item->end_at->format('Y.m.d')
                        : 'hozirgacha',
    
                    'isAsNeeded' => $item->frequency_type === 'as_needed',
                    'isOnce' => $item->frequency_type === 'once',
    
                    'slots' => $slotsData,
    
                    'isItemStopped' => $isItemStopped,
                    'hasResumedRecord' => $hasResumedRecord,
    
                    'administeredHistory' => $administeredHistory,
                ];
            }
        }
    
        return $modalData;
    }

    private function getStatusData($item): array
    {
        if ($item->status === 'stopped') {
            return [
                'status' => 'stopped',
                'color' => '#dc3545',
                'icon' => 'fas fa-stop-circle',
                'text' => "To'xtatilgan",
            ];
        }

        if ($item->end_at && now()->greaterThan($item->end_at)) {
            return [
                'status' => 'completed',
                'color' => '#28a745',
                'icon' => 'fas fa-check-circle',
                'text' => "To'liq ichildi",
            ];
        }

        return [
            'status' => 'in_progress',
            'color' => '#ffc107',
            'icon' => 'fas fa-clock',
            'text' => 'Jarayonda',
        ];
    }

    private function getScheduleInfo($item): string
    {
        return match ($item->frequency_type) {

            'daily' =>
                "{$item->duration_days} kun × kuniga {$item->frequency_value} marta = "
                . ($item->frequency_value * $item->duration_days)
                . " marta beriladi",

            'hourly' =>
                "Har {$item->frequency_value} soatda, {$item->duration_days} kun davomida = "
                . (floor(24 / $item->frequency_value) * $item->duration_days)
                . " marta beriladi",

            'weekly' =>
                ceil($item->duration_days / 7)
                . " hafta × haftasiga {$item->frequency_value} marta = "
                . ($item->frequency_value * ceil($item->duration_days / 7))
                . " marta beriladi",

            'once' =>
                "Bir marta beriladi",

            'as_needed' =>
                "Ehtiyoj bo'lganda beriladi (cheksiz)",

            default => '',
        };
    }

    private function getMainInfo($medicine, $dosage, $form, $item): string
    {
        return "{$medicine->name} ({$dosage}, {$form}) - {$item->dose_amount}";
    }

    private function getSlotStatusData($status): array
    {
        return match ($status) {

            'given' => [
                'text' => 'Berildi ✓',
                'bg' => '#28a745',
                'color' => 'white',
            ],

            'resumed' => [
                'text' => 'Davom etildi',
                'bg' => '#17a2b8',
                'color' => 'white',
            ],

            'skipped' => [
                'text' => "O'tkazib yuborildi",
                'bg' => '#dc3545',
                'color' => 'white',
            ],

            'stopped' => [
                'text' => "To'xtatildi",
                'bg' => '#6c757d',
                'color' => 'white',
            ],

            default => [
                'text' => 'Kutilmoqda',
                'bg' => '#ffc107',
                'color' => '#856404',
            ],
        };
    } 




    

    /**
     *  Hospitalization Test(TestPanel) uchun
     */
    public function prepareTestItems($orderItems)
    {
        $testItems = [];

        foreach ($orderItems as $item) {

            $status = $this->getTestStatus($item);
            $identity = $this->getTestIdentity($item);
            $doctor = $this->getDoctorInfo($item);
            $resultData = $this->getResultData($item);
            $allCompleted = $this->isPanelCompleted($item);

            $testItems[] = [
                'id' => $item->id,
                'isPanel' => $item->item_type === 'panel',

                // TEST INFO
                'testName' => $identity['name'],
                'testCode' => $identity['code'],
                'testDuration' => $identity['duration'],
                'testType'  => $identity['testType'],

                // STATUS
                'statusText' => $status['text'],
                'statusCss' => $status['class'],
                'statusColor' => $status['color'],
                'statusBgColor' => $status['bg-color'],

                // DATE
                'ordered_at' => $item->order?->ordered_at
                        ? Carbon::parse($item->order->ordered_at)->format('Y.m.d'): '-',

                // DOCTOR
                'doctor_name' => $doctor['full_name'],
                'short_name'  => $doctor['short_name'],
                'doctor_role' => $doctor['role'],

                // RESULT
                'resultData' => $resultData,
                'allCompleted' => $allCompleted,

                'note' => $item->order->note ?? null,
            ];
        }

        return $testItems;
    }

    private function getTestStatus($item): array
    {
        return match ($item->status) {
            'pending' => [
                'text' => __('words.waiting'),
                'class' => 'status-pending',
                'color' => '#f39c12',
                'bg-color' => '#fef9e7',
            ],
            'ready', 'completed' => [
                'text' => __('words.ready'),
                'class' => 'status-completed',
                'color' => '#27ae60',
                'bg-color' => '#e8f8f5',
            ],
            'cancelled' => [
                'text' => __('words.cancelled'),
                'class' => 'status-cancelled',
                'color' => '#e74c3c',
                'bg-color' => '#fdedec',
            ],
            default => [
                'text' => ucfirst($item->status),
                'class' => 'status-unknown',
                'color' => '#6c757d',
                'bg-color' => '#f8f9fa',
            ],
        };
    }

    private function getTestIdentity($item): array
    {
        if ($item->item_type === 'test') {
            $first = $item->results->first();

            return [
                'name' => $first?->test->name ?? 'Test nomi',
                'code' => $first?->test->code ?? 'N/A',
                'duration' => $first?->test->duration ?? 'N/A',
                'testType' => 'Test',
            ];
        }

        return [
            'name' => $item->panel->name ?? 'Test panel',
            'code' => $item->panel->code ?? 'N/A',
            'duration' => $item->panel->time ?? 'N/A',
            'testType' => 'Panel',
        ];
    }

    private function getDoctorInfo($item): array
    {
        $doctor = $item->order->doctor->user ?? null;

        return [
            'full_name' => ($doctor->last_name ?? 'Nomaʼlum') . ' ' . ($doctor->name ?? 'Nomaʼlum'),
            'short_name' => ($doctor->last_name ?? 'Nomaʼlum') . ' ' . mb_substr($doctor->name ?? '', 0, 1) . '.',
            'role' => $doctor->roles->pluck('name')->first() ?? '—',
        ];
    }

    private function getResultData($item): ?array
    {
        if ($item->item_type !== 'test') {
            return null;
        }

        $result = $item->results->first();

        $value = $result->value ?? null;
        $min = $result->normal_min ?? null;
        $max = $result->normal_max ?? null;
        $unit = $result->unit ?? null;

        $hasValue = !is_null($value);

        $rangeClass = '';
        $isNormal = true;
        $showNormalBadge = false;
        $indicator = null;

        if ($hasValue && is_numeric($value) && $min !== null && $max !== null) {

            $value = (float) $value;

            if ($value < $min) {
                $isNormal = false;
                $rangeClass = 'below-range';
                $indicator = 'down';
            } elseif ($value > $max) {
                $isNormal = false;
                $rangeClass = 'above-range';
                $indicator = 'up';
            } else {
                $showNormalBadge = true;
            }
        }

        return [
            'value' => $value,
            'unit' => $unit,
            'min' => $min,
            'max' => $max,
            'hasValue' => $hasValue,
            'isNormal' => $isNormal,
            'showNormalBadge' => $showNormalBadge,
            'rangeClass' => $rangeClass,
            'indicator' => $indicator,
        ];
    }

    private function isPanelCompleted($item): bool
    {
        if ($item->item_type !== 'panel') {
            return false;
        }

        return $item->results->every(fn($r) => $r->status !== 'pending');
    }

    /**
     * Hospitalization uchun PROCEDURE 
     */
    public function prepareProcedureItems($hospitalizationProcedures)
    {
        $procedureItems = [];
        
        foreach ($hospitalizationProcedures as $index => $hp) {

            $status = $this->getProcedureStatus($hp); 
            $procedure = $this->getProcedureInfo($hp);
            $staffTypeText = $this->getStaffTypeText($hp);
            
            $procedureItems[] = [
                'iteration' => $index + 1,

                // Status
                'status' => $hp->status,
                'statusText' => $status['text'],
                'statusCss' => $status['class'],
                'statusColor' => $status['color'],
                'statusBgColor' => $status['bg-color'],
                'statusIcon'    => $status['icon'],

                'id' => $hp->id,
                'procedure_name' => $procedure['name'],
                'procedure_description' => $procedure['description'],
                'duration' => $procedure['duration'],
                'room' => $procedure['room'],
                'staff_name' => $procedure['staff_name'],
                'assignedAt' => Carbon::parse($hp->assigned_at)->format('Y.m.d | H:m'),
                'procedurePatient' => ($hp->patient->user->last_name ?? '--') . ' ' . mb_substr($hp->patient->user->name ?? '', 0, 1),

                'notes' => $hp->notes,
                'staff_type_text' => $staffTypeText,
                'isPending' => ($hp->status === 'pending'),
                'procedureInfo' => $hp->procedure->name_uz . " | Hodim: " . $hp->staff->user->last_name . " " . $hp->staff->user->name . " | Sana: " . Carbon::parse($hp->assigned_at)->format('d.m.Y'),
                'mainInfo' => "Bemor: " . $hp->patient->user->last_name . " " . $hp->patient->user->name . " | " . $hp->room->number . " hona | Holati: " . $status['text'],
            ];
        }
        
        return $procedureItems;
    }

    private function getProcedureStatus($hp): array
    {
        return match ($hp->status) {
            'pending' => [
                'text' => __('words.waiting'),
                'class' => 'status-pending',
                'color' => '#f39c12',
                'bg-color' => '#fef9e7',
                'icon' => 'fas fa-clock',
            ],
            'completed' => [
                'text' => __('words.ready'),
                'class' => 'status-completed',
                'color' => '#27ae60',
                'bg-color' => '#e8f8f5',
                'icon' => 'fas fa-circle-check',
            ],
            'cancelled' => [
                'text' => __('words.cancelled'),
                'class' => 'status-cancelled',
                'color' => '#e74c3c',
                'bg-color' => '#fdedec',
                'icon'    => 'fas fa-circle-xmark',
            ],
            default => [
                'text' => ucfirst($hp->status),
                'class' => 'status-unknown',
                'color' => '#6c757d',
                'bg-color' => '#f8f9fa',
                'icon' => 'fa-solid fa-circle-question',
            ],
        };
    }

    private function getProcedureInfo($hp): array
    {
        $procedure = $hp->procedure ?? null;

        return [
            'id' => ($procedure->id ?? '--'),
            'name' => ($procedure->name ?? '--'),
            'description' => Str::limit($procedure->description ?? '-', 30),
            'duration' => ($procedure->duration ?? '--'),
            'room' => ($hp->room->number ?? '--'),
            'staff_name' => ($hp->staff->user->last_name ?? '--') . ' ' . mb_substr($hp->staff->user->name ?? '', 0, 1),
        ];
    }

    private function getStaffTypeText($hp): string
    {
        return match ($hp->staff_type) {
            'App\Models\Doctor' => 'Shifokor',
            'App\Models\Nurse' => 'Hamshira',
            default => 'Nomaʼlum',
        };
    }













    /**
     * Rooms malumotlari uchun
     */
    public function getRoomAssignments(Hospitalization $hospitalization)
    {
        return $hospitalization->hospitalizationRooms()
            ->with(['bed.room.roomType', 'bed.room.department'])
            ->get()
            ->map(function ($room) {

                return [
                    'id' => $room->id,

                    'number' => $room->bed->room->number ?? null,
                    'room_type' => $room->bed->room->roomType->name ?? '—',
                    'floor' => $room->bed->room->floor ?? '—',

                    'bed_number' => $room->bed->bed_number ?? '—',
                    'department_name' => $room->bed->room->department->name ?? '—',

                    'is_current' => is_null($room->unassigned_at),

                    'assigned_at_format' => Carbon::parse($room->assigned_at)->format('d.m.Y'),
                    'unassigned_at_format' => $room->unassigned_at
                        ? Carbon::parse($room->unassigned_at)->format('d.m.Y')
                        : '—',
                ];
            });
    }

    // Room biriktirish
    public function transferRoom(Hospitalization $hospitalization, array $data)
    {
        // 1️⃣ Eski roomni yopish
        $oldRoom = HospitalizationRoom::where('hospitalization_id', $data['hospitalization_id'])
            ->whereNull('unassigned_at')
            ->latest('assigned_at')
            ->first();

        if ($oldRoom) {
            $oldRoom->update([
                'unassigned_at' => now(),
            ]);

            $this->releaseBed($oldRoom->bed_id);
        }

        // 2️⃣ Yangi room assign
        $this->assignNewRoom($hospitalization, $data);

        // 3️⃣ Hospitalization status
        $hospitalization->update([
            'status' => 'under_treatment'
        ]);
    }

    private function assignNewRoom(Hospitalization $hospitalization, array $data)
    {
        HospitalizationRoom::create([
            'hospitalization_id' => $data['hospitalization_id'],
            'bed_id'             => $data['bed_id'],
            'assigned_at'        => $data['assigned_at'],
            'status'             => 'under_treatment',
        ]);

        $this->occupyBed($data['bed_id']);
    }

    private function releaseBed($bedId)
    {
        $bed = BedRoom::find($bedId);

        if (!$bed) return;

        $bed->update(['status' => 'available']);

        $this->updateRoomStatus($bed->room_id);
    }

    private function occupyBed($bedId)
    {
        $bed = BedRoom::find($bedId);

        if (!$bed) return;

        $bed->update(['status' => 'occupied']);

        $this->updateRoomStatus($bed->room_id);
    }

    private function updateRoomStatus($roomId)
    {
        $room = \App\Models\Room::with('roomBeds')->find($roomId);

        if (!$room) return;

        $totalBeds = $room->roomBeds->count();
        $occupiedBeds = $room->roomBeds->where('status', 'occupied')->count();

        if ($totalBeds > 0 && $totalBeds == $occupiedBeds) {
            $room->update(['status' => 'full']);
        } else {
            $room->update(['status' => 'available']);
        }
    }



    


    
    private function applyRoleFilter($query, $user)
    {
        if ($user->hasRole('admin') || $user->hasRole('receptionist')) {
            return;
        }
        
        $staffId = null;
        $staffType = null;
        
        if ($user->hasRole('doctor') && $user->doctor) {
            $staffId = $user->doctor->id;
            $staffType = 'App\\Models\\Doctor';
        } elseif ($user->hasRole('nurse') && $user->nurse) {
            $staffId = $user->nurse->id;
            $staffType = 'App\\Models\\Nurse';
        }
        
        if ($staffId && $staffType) {
            $query->whereHas('hospitalizationStaff', function ($q) use ($staffId, $staffType) {
                $q->where('staff_id', $staffId)->where('staff_type', $staffType);
            });
        } else {
            $query->whereRaw('1 = 0');
        }
    }
    
    private function applySearchFilter($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('appointment.patient.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('login', 'like', "%{$search}%");
            });
        }
    }
    
    private function applyStatusFilter($query, Request $request)
    {
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
    }
    
    private function applyDepartmentFilter($query, Request $request)
    {
        if ($request->filled('department') && $request->department != 'all') {
            $query->where('department_id', $request->department);
        }
    }
    
    private function generateCacheKey(Request $request, $user)
    {
        $role = 'admin';
        if ($user->hasRole('doctor')) {
            $role = 'doctor';
        } elseif ($user->hasRole('nurse')) {
            $role = 'nurse';
        }
        
        return 'hospitalizations_' . $role . '_' . $user->id . '_' . md5($request->fullUrl());
    }
    
    private function getUserStats($user)
    {
        $cacheKey = 'user_' . $user->id . '_hospitalization_stats';
        
        return Cache::remember($cacheKey, 600, function () use ($user) {
            $staffId = $this->getStaffId($user);
            $staffType = $this->getStaffType($user);
            
            if ($staffId && $staffType) {
                $query = Hospitalization::whereHas('hospitalizationStaff', function ($q) use ($staffId, $staffType) {
                    $q->where('staff_id', $staffId)->where('staff_type', $staffType);
                });
                
                return [
                    [
                        'value' => $query->count(),
                        'label' => 'Jami Bemorlar',
                        'icon' => 'fas fa-procedures',
                        'class' => ''
                    ],
                    [
                        'value' => (clone $query)->where('status', 'under_treatment')->count(),
                        'label' => 'Faol Bemorlar',
                        'icon' => 'fas fa-heartbeat',
                        'class' => 'underTreatment'
                    ],
                    [
                        'value' => (clone $query)->where('status', 'waiting_for_bed')->count(),
                        'label' => 'Navbatdagilar',
                        'icon' => 'fas fa-clock',
                        'class' => 'waitForBed'
                    ]
                ];
            }
            
            return [
                ['value' => 0, 'label' => 'Jami Bemorlar', 'icon' => 'fas fa-procedures', 'class' => ''],
                ['value' => 0, 'label' => 'Faol Bemorlar', 'icon' => 'fas fa-heartbeat', 'class' => 'underTreatment'],
                ['value' => 0, 'label' => 'Navbatdagilar', 'icon' => 'fas fa-clock', 'class' => 'waitForBed']
            ];
        });
    }
    
    private function getStaffId($user)
    {
        if ($user->hasRole('doctor') && $user->doctor) {
            return $user->doctor->id;
        }
        
        if ($user->hasRole('nurse') && $user->nurse) {
            return $user->nurse->id;
        }
        
        return null;
    }
    
    private function getStaffType($user)
    {
        if ($user->hasRole('doctor')) {
            return 'App\\Models\\Doctor';
        }
        
        if ($user->hasRole('nurse')) {
            return 'App\\Models\\Nurse';
        }
        
        return null;
    }



    // Test Results sahifasi uchun 
    public function makeViewData($hospitalization, $item): array
    {
        return [
            'panelName' => $item->panel->name ?? 'Test Panel',
            'panelCode' => $item->panel->code ?? 'N/A',
            'status' => $this->getStatus($item),
            'orderedAt' => $this->formatDate($item),
            'doctorName' => $this->getDoctorName($item),
            'patientName' => $this->getPatientName($hospitalization), 
            'results' => $this->formatResults($item->results ?? collect()),
            'testStatus' => $this->getTestStatus($item),
        ];
    }

    private function getStatus($item): array
    {
        $statuses = [
            'pending' => [
                'text' => 'Kutilmoqda',
                'class' => 'status-pending',
                'icon' => 'fas fa-clock',
                'color' => '#856404',
                'bg_color' => '#fff3cd',
            ],

            'completed' => [
                'text' => 'Bajarildi',
                'class' => 'status-completed',
                'icon' => 'fas fa-check-circle',
                'color' => '#27ae60',
                'bg_color' => 'rgba(46, 204, 113, 0.2)',
            ],

            'cancelled' => [
                'text' => 'Bekor qilingan',
                'class' => 'status-cancelled',
                'icon' => 'fas fa-times-circle',
                'color' => '#dc3545',
                'bg_color' => '#FFCBCB',
            ],

            'in_progress' => [
                'text' => 'Jarayonda',
                'class' => 'status-in-progress',
                'icon' => 'fas fa-spinner',
                'color' => '#B8860B',
                'bg_color' => '#FFFACD',
            ],
        ];

        return $statuses[$item->status] ?? [
            'text' => ucfirst($item->status),
            'class' => 'status-pending',
            'icon' => 'fas fa-question-circle',
            'color' => '#6c757d',
            'bg_color' => '#e9ecef',
        ];
    }

    private function formatDate($item): string
    {
        return $item->order?->ordered_at
            ? Carbon::parse($item->order->ordered_at)->format('d.m.Y H:i')
            : '-';
    }

    private function getDoctorName($item): string
    {
        return ($item->order->doctor->user->last_name ?? 'N/A') . ' ' .
               ($item->order->doctor->user->name ?? 'N/A');
    }

    private function getPatientName($hospitalization): string
    {
        return ($hospitalization->appointment->patient->user->name ?? '') . ' ' .
               ($hospitalization->appointment->patient->user->last_name ?? '');
    }

    private function formatResults($results)
    {
        return $results->map(function ($result) {

            $value = $result->value;
            $min = $result->normal_min;
            $max = $result->normal_max;

            $statusClass = 'status-pending';
            $statusText = 'Kutilmoqda';
            $statusIcon = 'fas fa-clock';
            $statusColor = '#6c757d';
            $statusBgColor = 'rgba(108, 117, 125, 0.2)';

            if (!is_null($value)) {

                if (is_numeric($value) && $min !== null && $max !== null) {

                    $valueNum = floatval($value);

                    if ($valueNum < $min) {

                        $statusClass = 'status-low';
                        $statusText = 'Past';
                        $statusIcon = 'fas fa-arrow-down';
                        $statusColor = '#e67e22';
                        $statusBgColor = 'rgba(243, 156, 18, 0.2)';

                    } elseif ($valueNum > $max) {

                        $statusClass = 'status-high';
                        $statusText = 'Yuqori';
                        $statusIcon = 'fas fa-arrow-up';
                        $statusColor = '#c0392b';
                        $statusBgColor = 'rgba(231, 76, 60, 0.2)';

                    } else {

                        $statusClass = 'status-normal';
                        $statusText = 'Normal';
                        $statusIcon = 'fas fa-check-circle';
                        $statusColor = '#27ae60';
                        $statusBgColor = 'rgba(46, 204, 113, 0.2)';
                    }

                } else {

                    $statusClass = 'status-normal';
                    $statusText = 'Natija';
                    $statusIcon = 'fas fa-vial';
                    $statusColor = '#17a2b8';
                    $statusBgColor = 'rgba(23, 162, 184, 0.2)';
                }
            }

            return [
                'test_name' => $result->test->name ?? '-',
                'test_code' => $result->test->code ?? '-',
                'value' => $value,
                'unit' => $result->unit,
                'min' => $min,
                'max' => $max,
                'notes' => $result->notes,

                'status_class' => $statusClass,
                'status_text' => $statusText,

                'status_icon' => $statusIcon,
                'status_color' => $statusColor,
                'status_bg_color' => $statusBgColor,
            ];
        });
    }

    // HospitazlizationPrescriptionStore
    public function storePrescription($data, $hospitalization)
    {
        $prescription = HospitalizationPrescription::create([
            'hospitalization_id' => $hospitalization->id,
            'patient_id' => $data['patient_id'] ?? $hospitalization->appointment->patient->id,
            'prescribed_by_type' => $data['prescribed_by_type'],
            'prescribed_by_id' => $data['prescribed_by_id'],
            'prescribed_at' => $data['start_at'],
            'reason' => 'standard',
            'note' => $data['note'] ?? null,
            'status' => 'active',
        ]);


        $item = $prescription->items()->create([
            'medicine_id' => $data['medicine_id'],
            'frequency_type' => $data['frequency_type'],
            'frequency_value' => $data['frequency_value'] ?? null,
            'dose_amount' => $data['dosage_amount'],
            'duration_days' => $data['duration_days'],
            'start_at' => $data['start_at'],
            'end_at' => Carbon::parse($data['start_at'])
                ->addDays($data['duration_days'] - 1),
            'status' => 'pending',
        ]);


        if (in_array($data['frequency_type'], [
            'daily',
            'hourly',
            'weekly',
            'interval',
            'once'
        ])) {
            $this->createSlotsForItem($item);
        }


        return $prescription;
    }

    private function createSlotsForItem($item)
    {
        $slots = [];
        $order = 1;

        $start = Carbon::parse($item->start_at);


        if ($item->frequency_type == 'hourly') {

            $total = $item->duration_days * 24 / $item->frequency_value;

            for ($i = 0; $i < $total; $i++) {

                $item->slots()->create([
                    'scheduled_at' => $start->copy()
                        ->addHours($i * $item->frequency_value),
                    'slot_order' => $order++,
                    'status' => 'pending'
                ]);
            }
        }


        elseif ($item->frequency_type == 'daily') {

            $total = $item->duration_days * $item->frequency_value;

            for ($i = 0; $i < $total; $i++) {

                $item->slots()->create([
                    'scheduled_at' => $start->copy()
                        ->addDays(floor($i / $item->frequency_value))
                        ->addHours(($i % $item->frequency_value) * (24 / $item->frequency_value)),
                    'slot_order' => $order++,
                    'status' => 'pending'
                ]);
            }
        }


        elseif ($item->frequency_type == 'weekly') {

            $total = ceil($item->duration_days / 7) * $item->frequency_value;

            for ($i = 0; $i < $total; $i++) {

                $item->slots()->create([
                    'scheduled_at' => $start->copy()
                        ->addWeeks(floor($i / $item->frequency_value))
                        ->addDays(($i % $item->frequency_value) * (7 / $item->frequency_value)),
                    'slot_order' => $order++,
                    'status' => 'pending'
                ]);
            }
        }


        elseif ($item->frequency_type == 'interval') {

            $total = ceil($item->duration_days / $item->frequency_value);

            for ($i = 0; $i < $total; $i++) {

                $item->slots()->create([
                    'scheduled_at' => $start->copy()
                        ->addDays($i * $item->frequency_value),
                    'slot_order' => $order++,
                    'status' => 'pending'
                ]);
            }
        }


        elseif ($item->frequency_type == 'once') {

            $item->slots()->create([
                'scheduled_at' => $start,
                'slot_order' => 1,
                'status' => 'pending'
            ]);
        }
    }

    
    // Bemorga dori berish yani HospitazlizationPrescriptionAdministrationStore
    public function handleExecution(array $data)
    {
        if (!empty($data['slots'])) {
            return $this->storeSlots($data['slots']);
        }

        if (!empty($data['administrations'])) {
            return $this->storeAdministrations($data['administrations']);
        }

        return redirect()->back()->with('error', 'Noto\'g\'ri so\'rov');
    }

    private function storeSlots(array $slots)
    {
        $user = auth()->user();
        $savedCount = 0;
        $itemIds = [];

        foreach ($slots as $slotData) {

            $itemId = $slotData['hospitalization_prescription_item_id'];
            $itemIds[] = $itemId;

            if (!in_array($slotData['status'], ['given','skipped','stopped','resumed'])) {
                continue;
            }

            $slot = HospitalizationPrescriptionItemSlot::find($slotData['slot_id']);

            if (!$slot || $slot->status !== 'pending') {
                continue;
            }

            $slot->update([
                'status' => $slotData['status'],
                'skip_reason' => $slotData['skip_reason'] ?? null,
            ]);

            HospitalizationPrescriptionAdministration::updateOrCreate(
                [
                    'hospitalization_prescription_item_id' => $itemId,
                    'hospitalization_prescription_item_slot_id' => $slot->id,
                ],
                [
                    'administered_by_type' => 'Doctor',
                    'administered_by_id' => $user->id,
                    'administered_at' => $slot->scheduled_at,
                    'status' => $slotData['status'],
                    'skip_reason' => $slotData['skip_reason'] ?? null,
                ]
            );

            $savedCount++;
        }

        $this->updateItemsStatus($itemIds);

        return back()->with('success', "$savedCount ta berilish saqlandi");
    }

    private function storeAdministrations(array $administrations)
    {
        $user = auth()->user();
        $savedCount = 0;
        $itemIds = [];

        foreach ($administrations as $data) {

            $itemId = $data['hospitalization_prescription_item_id'];
            $itemIds[] = $itemId;

            if (!in_array($data['status'], ['given','skipped','stopped','resumed'])) {
                continue;
            }

            $administeredAt = $data['scheduled_date'].' '.$data['scheduled_time'].':00';

            if (!empty($data['slot_id'])) {
                $slot = HospitalizationPrescriptionItemSlot::find($data['slot_id']);

                if ($slot && $slot->status === 'pending') {
                    $slot->update([
                        'status' => $data['status'],
                        'skip_reason' => $data['skip_reason'] ?? null,
                    ]);
                }
            }

            HospitalizationPrescriptionAdministration::updateOrCreate(
                [
                    'hospitalization_prescription_item_id' => $itemId,
                    'administered_at' => $administeredAt,
                ],
                [
                    'hospitalization_prescription_item_slot_id' => $data['slot_id'] ?? null,
                    'administered_by_type' => 'Doctor',
                    'administered_by_id' => $user->id,
                    'status' => $data['status'],
                    'skip_reason' => $data['skip_reason'] ?? null,
                ]
            );

            $savedCount++;
        }

        $this->updateItemsStatus($itemIds);

        return back()->with('success', "$savedCount ta berilish saqlandi");
    }

    private function updateItemsStatus($itemIds)
    {
        if (empty($itemIds)) return;
        
        $uniqueItemIds = array_unique($itemIds);
        
        foreach ($uniqueItemIds as $itemId) {
            $item = \App\Models\HospitalizationPrescriptionItem::find($itemId);
            
            if (!$item) continue;
            
            // Agar slot tizimi mavjud bo'lsa, slotlar orqali tekshirish
            if (class_exists('\App\Models\HospitalizationPrescriptionItemSlot') && $item->slots()->exists()) {
                // 1. To'xtatish/davom etish
                $hasStopped = $item->slots()->where('status', 'stopped')->exists();
                $hasResumed = $item->slots()->where('status', 'resumed')->exists();
                
                if ($hasStopped && !$hasResumed) {
                    $item->update(['status' => 'stopped', 'end_at' => now()]);
                    continue;
                } elseif ($hasResumed && $item->status == 'stopped') {
                    $item->update(['status' => 'active', 'end_at' => null]);
                }
                
                // 2. OXIRGI SLOT GIVEN BO'LSA COMPLETED
                $lastSlot = $item->slots()->orderBy('scheduled_at', 'desc')->first();
                
                if ($lastSlot && $lastSlot->status == 'given') {
                    $item->update(['status' => 'completed', 'end_at' => now()]);
                } else {
                    // Aks holda ACTIVE
                    if ($item->status != 'stopped' && $item->status != 'completed') {
                        $item->update(['status' => 'active', 'end_at' => null]);
                    }
                }

                // 2. OXIRGI SLOT GIVEN BO'LSA COMPLETED
                // $lastSlot = $item->slots()->orderBy('scheduled_at', 'desc')->first();

                // if ($lastSlot) {
                //     // Faqat agar oxirgi slot vaqti hozirgi vaqtdan oldin bo‘lsa
                //     if ($lastSlot->scheduled_at <= now() && $lastSlot->status == 'given') {
                //         // barcha slotlar berilgan yoki o'tkazilgan (skipped/stopped) bo'lishini tekshirish
                //         $allSlotsDone = $item->slots()
                //             ->whereIn('status', ['pending'])
                //             ->count() === 0;

                //         if ($allSlotsDone) {
                //             $item->update(['status' => 'completed', 'end_at' => now()]);
                //         } else {
                //             // Agar hali ham pending slotlar mavjud bo‘lsa, ACTIVE qoladi
                //             if ($item->status != 'stopped') {
                //                 $item->update(['status' => 'active', 'end_at' => null]);
                //             }
                //         }
                //     } else {
                //         if ($item->status != 'stopped' && $item->status != 'completed') {
                //             $item->update(['status' => 'active', 'end_at' => null]);
                //         }
                //     }
                // }


            } else {
                // ESKI tizim
                // 1. To'xtatish/davom etish
                $hasStopped = HospitalizationPrescriptionAdministration::where([
                    'hospitalization_prescription_item_id' => $itemId,
                    'status' => 'stopped'
                ])->exists();
                
                $hasResumed = HospitalizationPrescriptionAdministration::where([
                    'hospitalization_prescription_item_id' => $itemId,
                    'status' => 'resumed'
                ])->exists();
                
                if ($hasStopped && !$hasResumed) {
                    $item->update(['status' => 'stopped', 'end_at' => now()]);
                    continue;
                } elseif ($hasResumed && $item->status == 'stopped') {
                    $item->update(['status' => 'active', 'end_at' => null]);
                }
                
                // 2. FAKAT OXIRGI BERILISH GIVEN BO'LSA COMPLETED
                $totalHours = $item->duration_days * 24;
                $interval = $item->frequency_value;
                $totalAdministrations = floor($totalHours / $interval);
                
                // Oxirgi berilish vaqti
                $lastScheduleTime = $item->start_at->copy()->addHours(($totalAdministrations - 1) * $interval);
                $lastScheduledDate = $lastScheduleTime->format('Y-m-d');
                $lastScheduledTime = $lastScheduleTime->format('H:i');
                
                // Oxirgi berilish ma'lumotini olish
                $lastAdministration = HospitalizationPrescriptionAdministration::where([
                    'hospitalization_prescription_item_id' => $itemId,
                ])->whereDate('administered_at', $lastScheduledDate)
                  ->whereTime('administered_at', $lastScheduledTime)
                  ->first();
                
                // Agar oxirgi berilish GIVEN bo'lsa, COMPLETED
                if ($lastAdministration && $lastAdministration->status == 'given') {
                    $item->update(['status' => 'completed', 'end_at' => now()]);
                } else {
                    // Aks holda ACTIVE
                    if ($item->status != 'stopped' && $item->status != 'completed') {
                        $item->update(['status' => 'active', 'end_at' => null]);
                    }
                }
            }
        }
    }
}