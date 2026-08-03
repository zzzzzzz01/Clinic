<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\HospitalizationOrderItem;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class LaboratoryService
{
    /**
     * Laboratoriya testlarini filter va pagination bilan qaytaradi
     */
    public function getFilteredTests(Request $request): array
    {
        $query = HospitalizationOrderItem::with([
            'order.patient.user',
            'order.orderedBy',
            'test',
            'panel',
            'order.hospitalization.hospitalizationRooms.bed.room'
        ]);
        
        // ========== FILTER QISMI ==========
        
        // 1. Qidiruv (search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('order.patient.user', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('last_name', 'like', "%{$search}%");
                })->orWhereHas('test', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })->orWhereHas('panel', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        // 2. Holati filteri (status)
        if ($request->filled('status') && $request->status != 'all') {
            $statusMap = [
                'pending' => 'pending',
                'inprogress' => 'in_progress',
                'completed' => 'completed'
            ];
            if (isset($statusMap[$request->status])) {
                $query->where('status', $statusMap[$request->status]);
            }
        }
        
        // 3. Turi filteri (type)
        if ($request->filled('type') && $request->type != 'all') {
            $query->where('item_type', $request->type);
        }
        
        // 4. Shoshilinchlik filteri (urgency)
        if ($request->filled('urgency') && $request->urgency != 'all') {
            $query->whereHas('order', function($q) use ($request) {
                $q->where('order_type', $request->urgency);
            });
        }
        
         // 5. ✅ ordered_at bo'yicha eskilardan yangilarga (DESC)
         $query->orderBy('created_at', 'desc');
        
         // Pagination
         $items = $query->paginate(10);
        
        // Ma'lumotlarni blade uchun tayyorlash
        return $this->prepareDataForBlade($items, $request);
    }

    /**
     * Blade uchun ma'lumotlarni tayyorlaydi
     */
    private function prepareDataForBlade(LengthAwarePaginator $items, Request $request): array
    {
        $preparedItems = [];
        
        foreach ($items as $item) {
            // Doctor specialty ni olish
            $role = $item->order->orderedBy?->roles->pluck('name')->first() ?? null;
            $specialty = '—';
            if ($role === 'Doctor') {
                $specialty = $item->order->orderedBy?->doctor?->specialization ?? '—';
            } elseif ($role === 'Nurse') {
                $specialty = $item->order->orderedBy?->nurse?->specialization ?? '—';
            }

            // Status va type lar
            $statusConfig = $this->getStatusConfig($item->result_status);
            $urgencyConfig = $this->getUrgencyConfig($item->order_type ?? 'normal');
            $typeConfig = $this->getTypeConfig($item->item_type);
            
            // Patient yoshi
            $age = $item->order->patient->birth_date 
                ? \Carbon\Carbon::parse($item->order->patient->birth_date)->age 
                : '-';

            // Finish at
            $finishAt = $item->finish_at ? $item->finish_at->toIso8601String() : '';

            // Test/panel nomi va description
            $testName = '';
            $testDescription = '';
            $duration = '-';
            
            if ($item->item_type === 'test') {
                $testName = $item->test->name ?? 'Nomaʼlum test';
                $testDescription = $item->test->description ?? 'Nomaʼlum Test';
                $duration = $item->test->duration ?? '-';
            } elseif ($item->item_type === 'panel') {
                $testName = $item->panel->name ?? 'Nomaʼlum panel';
                $testDescription = $item->panel->description ?? 'Nomaʼlum panel';
                $duration = $item->panel->time ?? '-';
            }

            $preparedItems[] = [
                'id' => $item->id,
                'item_type' => $item->item_type,
                'status' => $item->status,
                'result_status' => $item->result_status,
                'order_type' => $item->order_type ?? 'normal',
                'room_number' => $item->order->hospitalization->hospitalizationRooms->last()?->bed?->room?->number ?? '-',
                'patient' => [
                    'name' => ($item->order->patient->user->last_name ?? '') . ' ' . ($item->order->patient->user->name ?? ''),
                    'id' => $item->order->patient->id,
                    'age' => $age,
                    'avatar' => substr($item->order->patient->user->name ?? '?', 0, 1) . substr($item->order->patient->user->last_name ?? '?', 0, 1)
                ],
                'doctor' => [
                    'name' => 'Dr. ' . ($item->order->orderedBy?->last_name ?? '') . ' ' . ($item->order->orderedBy?->name ?? ''),
                    'avatar' => substr($item->order->orderedBy?->name ?? '?', 0, 1) . substr($item->order->orderedBy?->last_name ?? '?', 0, 1),
                    'specialty' => $specialty
                ],
                'test' => [
                    'name' => $testName,
                    'description' => $testDescription,
                    'duration' => $duration
                ],
                'ordered_at' => $item->order->ordered_at ? \Carbon\Carbon::parse($item->order->ordered_at)->format('d.m.y') : '-',
                'ordered_time' => $item->order->ordered_at ? \Carbon\Carbon::parse($item->order->ordered_at)->format('H:i') : '-',
                'finish_at' => $finishAt,
                'status_config' => $statusConfig,
                'urgency_config' => $urgencyConfig,
                'type_config' => $typeConfig,
                'laboratory_show_url' => route('laboratory.show', $item->id),
                'view_url' => route('laboratory.show', $item->id),
            ];
        }

        return [
            'items' => $preparedItems,
            'pagination' => $this->preparePagination($items),
            'stats' => $this->getStatistics(),
            'active_filters' => $this->getActiveFilters($request),
            'filter_count' => $this->getFilterCount($request)
        ];
    }

    /**
     * Pagination ma'lumotlarini tayyorlaydi
     */
    private function preparePagination(LengthAwarePaginator $items): array
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

    /**
     * Status konfiguratsiyasi
     */
    private function getStatusConfig(?string $status): array
    {
        return match($status) {
            'ready' => [
                'icon' => 'fa-regular fa-circle-check',
                'text' => __('words.ready'),
                'class' => 'test-status-badge'
            ],
            'in_progress' => [
                'icon' => 'fas fa-spinner fa-spin',
                'text' => __('words.in_progress'),
                'class' => 'test-status-badge'
            ],
            default => [
                'icon' => 'far fa-clock',
                'text' => __('words.pending'),
                'class' => 'test-status-badge'
            ]
        };
    }

    /**
     * Urgency konfiguratsiyasi
     */
    private function getUrgencyConfig(?string $urgency): array
    {
        return match($urgency) {
            'emergency' => [
                'icon' => 'fas fa-bolt',
                'text' => __('words.emergency'),
                'class' => 'test-type-status type-urgent'
            ],
            'urgent' => [
                'icon' => 'fas fa-exclamation-triangle',
                'text' => __('words.urgent'),
                'class' => 'test-type-status type-high'
            ],
            default => [
                'icon' => 'fas fa-check',
                'text' => __('words.normal'),
                'class' => 'test-type-status type-normal'
            ]
        };
    }

    /**
     * Type konfiguratsiyasi
     */
    private function getTypeConfig(?string $type): array
    {
        return match($type) {
            'panel' => [
                'text' => __('words.panel'),
                'class' => 'test-type-badge type-panel'
            ],
            default => [
                'text' => __('words.test'),
                'class' => 'test-type-badge type-test'
            ]
        };
    }

    /**
     * Statistik ma'lumotlarni qaytaradi
     */
    public function getStatistics(): array
    {
        return [
            'total_tests' => HospitalizationOrderItem::count(),
            'pending_tests' => HospitalizationOrderItem::where('status', 'pending')->count(),
            'in_progress_tests' => HospitalizationOrderItem::where('status', 'in_progress')->count(),
            'completed_tests' => HospitalizationOrderItem::where('status', 'completed')->count(),
        ];
    }

    /**
     * Aktiv filterlarni qaytaradi
     */
    public function getActiveFilters(Request $request): array
    {
        $filters = [];

        if ($request->filled('search') && $request->search != '') {
            $filters['search'] = $request->search;
        }

        if ($request->filled('status') && $request->status != 'all') {
            $statusLabels = [
                'pending' => 'Kutilayotgan',
                'inprogress' => 'Jarayonda',
                'completed' => 'Yakunlangan'
            ];
            $filters['status'] = $statusLabels[$request->status] ?? $request->status;
        }

        if ($request->filled('type') && $request->type != 'all') {
            $typeLabels = [
                'test' => 'Yakka test',
                'panel' => 'Test panel'
            ];
            $filters['type'] = $typeLabels[$request->type] ?? $request->type;
        }

        if ($request->filled('urgency') && $request->urgency != 'all') {
            $urgencyLabels = [
                'emergency' => 'Favqulodda',
                'urgent' => 'Shoshilinch',
                'normal' => 'Oddiy'
            ];
            $filters['urgency'] = $urgencyLabels[$request->urgency] ?? $request->urgency;
        }

        return $filters;
    }

    /**
     * Filterlar sonini qaytaradi
     */
    public function getFilterCount(Request $request): int
    {
        return count($this->getActiveFilters($request));
    }


    // =============================================
// LABORATORY TEST SHOW
// =============================================

public function getLaboratoryTestShowData($item)
{
    // Status konfiguratsiyasi
    $statusConfig = $this->getLaboratoryStatusConfig($item->status);
    
    // Test turi
    $isPanel = !is_null($item->panel);
    $typeConfig = $isPanel ? [
        'badge_class' => 'badge-panel',
        'icon' => 'fas fa-layer-group',
        'label' => __('words.panel')
    ] : [
        'badge_class' => 'badge-single',
        'icon' => 'fas fa-vial',
        'label' => __('words.single_test')
    ];
    
    // Test nomi
    $testName = $isPanel ? ($item->panel->name ?? __('words.panel_test')) : ($item->test->name ?? __('words.test'));
    $pageTitle = $isPanel ? __('words.panel_test_results') . ' - ' . $testName : __('words.test_results') . ' - ' . $testName;
    
    // Bemor ma'lumotlari
    $patient = $item->order->patient->user ?? null;
    $patientName = $patient ? ($patient->last_name ?? '') . ' ' . ($patient->name ?? '') : __('words.n_a');
    $patientShortName = $patient ? ($patient->last_name ?? '') . ' ' . (mb_substr($patient->name ?? '', 0, 1) . '.') : __('words.n_a');
    
    // Shifokor ma'lumotlari
    $doctor = $item->order->doctor->user ?? null;
    $doctorName = $doctor ? ($doctor->last_name ?? '') . ' ' . ($doctor->name ?? '') : __('words.n_a');
    $doctorShortName = $doctor ? ($doctor->last_name ?? '') . ' ' . (mb_substr($doctor->name ?? '', 0, 1) . '.') : __('words.n_a');
    
    // Natijalar
    $results = $this->formatLaboratoryResults($item->results);
    
    // Hospitalization ma'lumotlari
    $hospitalization = $item->order->hospitalization ?? null;
    $roomNumber = $hospitalization ? ($hospitalization->room_number ?? '-') : null;
    
    // Testlar soni
    $testCount = count($item->results);
    
    // Natijalar mavjudligi
    $hasResults = $testCount > 0;
    
    // URL lar
    $backUrl = route('laboratory.test');
    
    return [
        'page_title' => $pageTitle,
        'test_name' => $testName,
        'is_panel' => $isPanel,
        'type_config' => $typeConfig,
        'status_config' => $statusConfig,
        'patient_name' => $patientName,
        'patient_short_name' => $patientShortName,
        'doctor_name' => $doctorName,
        'doctor_short_name' => $doctorShortName,
        'ordered_at' => Carbon::parse($item->order->ordered_at)->format('d.m.Y H:i'),
        'room_number' => $roomNumber,
        'results' => $results,
        'test_count' => $testCount,
        'has_results' => $hasResults,
        'back_url' => $backUrl,
        'item' => $item,
    ];
}

private function getLaboratoryStatusConfig($status)
{
    $statusMap = [
        'pending' => [
            'class' => 'status-pending',
            'text' => __('words.pending')
        ],
        'completed' => [
            'class' => 'status-completed',
            'text' => __('words.completed')
        ],
        'cancelled' => [
            'class' => 'status-cancelled',
            'text' => __('words.cancelled')
        ],
        'in_progress' => [
            'class' => 'status-in-progress',
            'text' => __('words.in_progress')
        ],
    ];
    
    return $statusMap[$status] ?? $statusMap['pending'];
}

private function formatLaboratoryResults($results)
{
    return $results->map(function($result) {
        $test = $result->test;
        $value = $result->value;
        $unit = $result->unit;
        $min = $result->normal_min;
        $max = $result->normal_max;
        
        // Natija holatini aniqlash
        $statusData = $this->getResultStatus($value, $min, $max);
        
        return [
            'id' => $result->id,
            'test_name' => $test->name ?? __('words.test'),
            'test_code' => $test->code ?? 'TEST-' . ($test->id ?? ''),
            'value' => $value,
            'unit' => $unit,
            'normal_min' => $min,
            'normal_max' => $max,
            'status_class' => $statusData['class'],
            'status_text' => $statusData['text'],
            'status_icon' => $statusData['icon'],
            'row_class' => $statusData['row_class'],
            'has_value' => !is_null($value),
        ];
    });
}

private function getResultStatus($value, $min, $max)
{
    if (is_null($value)) {
        return [
            'class' => 'status-pending',
            'text' => __('words.pending'),
            'icon' => '',
            'row_class' => ''
        ];
    }
    
    if (is_numeric($value) && !is_null($min) && !is_null($max)) {
        $numericValue = floatval($value);
        
        if ($numericValue < $min) {
            return [
                'class' => 'status-low',
                'text' => __('words.low'),
                'icon' => '<i class="fa-solid fa-arrow-down"></i>',
                'row_class' => 'low'
            ];
        } elseif ($numericValue > $max) {
            return [
                'class' => 'status-high',
                'text' => __('words.high'),
                'icon' => '<i class="fa-solid fa-arrow-up"></i>',
                'row_class' => 'high'
            ];
        } else {
            return [
                'class' => 'status-normal',
                'text' => __('words.normal'),
                'icon' => '<i class="fa-solid fa-check"></i>',
                'row_class' => 'normal'
            ];
        }
    }
    
    return [
        'class' => 'status-normal',
        'text' => __('words.result'),
        'icon' => '<i class="fa-solid fa-check"></i>',
        'row_class' => 'normal'
    ];
}
}