<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;

class DepartmentService
{
    /**
     * Bo'limlar ro'yxatini olish (filtr bilan)
     */
    public function getDepartments(Request $request, int $perPage = 10): array
    {
        $currentLocale = App::getLocale();
        $cacheKey = $this->generateCacheKey($request, $perPage, $currentLocale);
        
        return Cache::tags(['departments'])->remember($cacheKey, 300, function () use ($request, $perPage, $currentLocale) {
            $query = Department::with(['headDoctor.user', 'doctors', 'nurses', 'rooms.roomBeds']);
            
            if ($request->filled('department_search')) {
                $search = $request->department_search;
                $query->where(function($q) use ($search) {
                    $q->where('name_uz', 'like', "%{$search}%")
                      ->orWhere('name_ru', 'like', "%{$search}%")
                      ->orWhere('name_en', 'like', "%{$search}%");
                });
            }
            
            if ($request->filled('department_status') && $request->department_status != 'all') {
                $query->where('status', $request->department_status == 'active' ? 1 : 0);
            }
            
            if ($request->filled('department_floor') && $request->department_floor != 'all') {
                $query->where('floor', $request->department_floor);
            }
            
            $departments = $query->paginate($perPage)->withQueryString();
            $doctors = $this->getAllDoctors();
            $stats = $this->getDepartmentStats($departments);
            $departmentData = $this->prepareDepartmentData($departments, $currentLocale);
            
            return [
                'departments' => $departments,
                'doctors' => $doctors,
                'stats' => $stats,
                'departmentData' => $departmentData
            ];
        });
    }
    
    /**
     * Bo'limlarni LIST uchun formatlash
     */
    public function prepareDepartmentData($departments, string $locale = null): array
    {
        $locale = $locale ?? App::getLocale();
        $data = [];
        
        foreach ($departments as $department) {
            $headDoctor = $department->headDoctor->first();
            $roomsCount = $department->rooms->count();
            $totalBeds = $department->rooms->sum(fn($room) => $room->roomBeds->count());
            $occupiedBeds = $department->rooms->sum(fn($room) => $room->roomBeds->where('status', 'occupied')->count());
            $occupancyPercent = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100) : 0;
            $statusConfig = $this->getStatusConfig($department->status);
            
            $data[] = [
                'id' => $department->id,
                'name' => $department->name,
                'name_uz' => $department->name_uz,
                'name_ru' => $department->name_ru,
                'name_en' => $department->name_en,
                'description' => $department->description,
                'description_uz' => $department->description_uz,
                'description_ru' => $department->description_ru,
                'description_en' => $department->description_en,
                'floor' => $department->floor,
                'head_doctor_name' => $headDoctor && $headDoctor->user ? 'Dr. ' . $headDoctor->user->last_name . ' ' . $headDoctor->user->name : 'Tayinlanmagan',
                'head_doctor_id' => $headDoctor,
                'head_doctor_specialty' => $headDoctor && $headDoctor->user ? ($headDoctor->specialization ?? 'Bosh shifokor') : '-',
                'rooms_count' => $roomsCount,
                'total_beds' => $totalBeds,
                'occupied_beds' => $occupiedBeds,
                'occupancy_percent' => $occupancyPercent,
                'doctor_count' => $department->doctors->count(),
                'nurse_count' => $department->nurses->count(),
                'total_staff' => $department->doctors->count() + $department->nurses->count(),
                'status' => $department->status,
                'status_class' => $department->status == 1 ? 'active' : 'inactive',
                'status_icon' => $statusConfig['icon'],
                'status_text' => $statusConfig['text'],
                'status_text_color' => $statusConfig['text_color'],
                'status_bg_color' => $statusConfig['bg_color'],
            ];
        }
        
        return $data;
    }
    
    /**
     * Status konfiguratsiyasi
     */
    private function getStatusConfig($status): array
    {
        $status = $status == 1 ? 'active' : 'inactive';
        
        return match($status) {
            'active' => [
                'text' => __('words.active'),
                'text_color' => '#27ae60',
                'bg_color' => '#e8f8f5',
                'icon' => 'fa-check-circle'
            ],
            'inactive' => [
                'text' => __('words.inactive'),
                'text_color' => '#e74c3c',
                'bg_color' => '#fdedec',
                'icon' => 'fa-times-circle'
            ],
            default => [
                'text' => __('words.unknown'),
                'text_color' => '#95a5a6',
                'bg_color' => '#f5f5f5',
                'icon' => 'fa-question-circle'
            ],
        };
    }
    
    /**
     * Barcha shifokorlarni olish
     */
    public function getAllDoctors()
    {
        return Doctor::with('user')->get();
    }
    
    /**
     * Department statistikasini hisoblash
     */
    public function getDepartmentStats($departments): array
    {
        return [
            'total' => $departments->total(),
            'active' => $departments->where('status', 1)->count(),
            'inactive' => $departments->where('status', 0)->count(),
            'total_beds' => $departments->sum(function($dept) {
                return $dept->rooms->sum(function($room) {
                    return $room->roomBeds->count();
                });
            })
        ];
    }
    
    /**
     * Department xodimlarini olish (API uchun)
     */
    public function getDepartmentStaff($id): array
    {
        $department = Department::with(['doctors.user', 'nurses.user'])->findOrFail($id);
        $staff = [];
        
        foreach ($department->doctors as $doctor) {
            $staff[] = [
                'name' => $doctor->user->last_name . ' ' . $doctor->user->name,
                'position' => $doctor->position ?? 'Shifokor',
                'role_class' => 'doctor',
                'status' => $this->getStatusData($doctor->status ?? 'active')
            ];
        }
        
        foreach ($department->nurses as $nurse) {
            $staff[] = [
                'name' => $nurse->user->last_name . ' ' . $nurse->user->name,
                'position' => $nurse->position ?? 'Hamshira',
                'role_class' => 'nurse',
                'status' => $this->getStatusData($nurse->status ?? 'active')
            ];
        }
        
        return $staff;
    }

    private function getStatusData($status): array
    {
        $statuses = [
            'active' => [ 
                'icon' => 'fa-check-circle',
                'text' => 'Faol',
                'color' => '#27ae60',
                'bg_color' => '#e8f8f5'
            ],
            'inactive' => [ 
                'icon' => 'fa-times-circle',
                'text' => 'Nofaol',
                'color' => '#e74c3c',
                'bg_color' => '#fdedec'
            ],
            'on_leave' => [ 
                'icon' => 'fa-clock',
                'text' => 'Ta\'tilda',
                'color' => '#f39c12',
                'bg_color' => '#fef9e7'
            ]
        ];
        
        return $statuses[$status] ?? $statuses['active'];
    }
    
    /**
     * Department bo'yicha xonalarni olish
     */
    public function getDepartmentRoomsStats($department): array
    {
        $rooms = $department->rooms;
        
        return [
            'total' => $rooms->count(),
            'available' => $rooms->where('status', 'available')->count(),
            'occupied' => $rooms->where('status', 'occupied')->count(),
            'maintenance' => $rooms->where('status', 'maintenance')->count(),
        ];
    }

    /**
     * Xona status ma'lumotlarini olish
     */
    private function getRoomStatusInfo(string $status, int $totalBeds = 0, int $occupiedBeds = 0): array
    {
        $statusKey = $status;
        
        if ($status === 'empty') {
            if ($totalBeds == 0 || $occupiedBeds == 0) {
                $statusKey = 'available';
            } elseif ($occupiedBeds < $totalBeds) {
                $statusKey = 'partial';
            } elseif ($occupiedBeds == $totalBeds) {
                $statusKey = 'full';
            } else {
                $statusKey = 'occupied';
            }
        }
        
        return match($statusKey) {
            'available' => [
                'text' => __('words.available'),
                'class' => 'available',
                'icon' => 'fa-check-circle',
                'text_color' => '#10b981',
                'bg_color' => 'rgba(16, 185, 129, 0.2)',
            ],
            'occupied' => [
                'text' => __('words.occupied'),
                'class' => 'occupied',
                'icon' => 'fa-circle',
                'text_color' => '#f59e0b',
                'bg_color' => 'rgba(245, 158, 11, 0.2)',
            ],
            'partial' => [
                'text' => __('words.partial'),
                'class' => 'partial',
                'icon' => 'fa-circle-half-stroke',
                'text_color' => '#3b82f6',
                'bg_color' => 'rgba(59, 130, 246, 0.2)',
            ],
            'full' => [
                'text' => __('words.full'),
                'class' => 'full',
                'icon' => 'fa-times-circle',
                'text_color' => '#ef4444',
                'bg_color' => 'rgba(239, 68, 68, 0.2)',
            ],
            'maintenance' => [
                'text' => __('words.maintenance'),
                'class' => 'maintenance',
                'icon' => 'fa-tools',
                'text_color' => '#6b7280',
                'bg_color' => 'rgba(107, 114, 128, 0.2)',
            ],
            default => [
                'text' => __('words.available'),
                'class' => 'available',
                'icon' => 'fa-check-circle',
                'text_color' => '#10b981',
                'bg_color' => 'rgba(16, 185, 129, 0.2)',
            ]
        };
    }

    /**
     * Yotoq status ma'lumotlarini olish
     */
    private function getBedStatusInfo(string $status): array
    {
        return match($status) {
            'available' => [
                'text' => __('words.available'),
                'class' => 'available',
                'icon' => 'fa-check-circle',
            ],
            'occupied' => [
                'text' => __('words.occupied'),
                'class' => 'occupied',
                'icon' => 'fa-circle',
            ],
            'maintenance' => [
                'text' => __('words.maintenance'),
                'class' => 'maintenance',
                'icon' => 'fa-tools',
            ],
            default => [
                'text' => __('words.available'),
                'class' => 'available',
                'icon' => 'fa-check-circle',
            ]
        };
    }

    /**
     * Xona turi badge class
     */
    private function getRoomTypeBadgeClass($room): string
    {
        $typeName = strtolower($room->roomType->name ?? 'standard');
        
        if (strpos($typeName, 'lyuks') !== false || strpos($typeName, 'lux') !== false) {
            return 'lux';
        } elseif (strpos($typeName, 'vip') !== false) {
            return 'vip';
        }
        
        return 'standard';
    }

    /**
     * Yotoqdagagi bemor ma'lumotlari
     */
    private function getBedPatientData($bed): ?array
    {
        if ($bed->status != 'occupied') {
            return null;
        }
        
        $hospitalizationRoom = $bed->hospitalizationRooms()
            ->latest('id')
            ->first();
        
        if (!$hospitalizationRoom || !$hospitalizationRoom->hospitalization) {
            return null;
        }
        
        $hospitalization = $hospitalizationRoom->hospitalization;
        
        if (!$hospitalization->appointment || !$hospitalization->appointment->patient) {
            return null;
        }
        
        $patient = $hospitalization->appointment->patient;
        
        return [
            'name' => $patient->full_name ?? $patient->user->name ?? $patient->first_name . ' ' . $patient->last_name,
            'lastName' => $patient->full_name ?? $patient->user->last_name ?? $patient->last_name,
            'age' => $patient->age ?? ($patient->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->age : 0),
            'diagnosis' => $hospitalization->diagnosis ?? $patient->diagnosis ?? '',
            'admitted_at' => $hospitalization->created_at ? \Carbon\Carbon::parse($hospitalization->created_at)->format('d.m.Y') : '',
        ];
    }

    /**
     * Yotoqlar ma'lumotlarini tayyorlash (Modal uchun)
     */
    public function prepareRoomBeds($room): array
    {
        $beds = [];
        
        foreach ($room->roomBeds as $bed) {
            $patientData = $this->getBedPatientData($bed);
            $statusData = $this->getBedStatusInfo($bed->status);
            
            $beds[] = [
                'id' => $bed->id,
                'number' => $bed->bed_number,
                'status' => $bed->status,
                'status_text' => $statusData['text'],
                'status_class' => $statusData['class'],
                'status_icon' => $statusData['icon'],
                'patient' => $patientData,
            ];
        }
        
        return $beds;
    }

    /**
     * Department xonalarini formatlash (Blade uchun)
     */
    public function prepareDepartmentRooms($department): array
    {
        $rooms = [];
        $counter = 1;
        
        foreach ($department->rooms as $room) {
            $badgeClass = $this->getRoomTypeBadgeClass($room);
            
            $totalBeds = $room->roomBeds->count();
            $occupiedBeds = $room->roomBeds->where('status', 'occupied')->count();
            $statusData = $this->getRoomStatusInfo($room->status, $totalBeds, $occupiedBeds);
            $bedsData = $this->prepareRoomBeds($room);
            
            $rooms[] = [
                'id' => $room->id,
                'counter' => $counter++,
                'number' => $room->number,
                'floor' => $room->floor,
                'type_name' => $room->roomType->name ?? 'Standart',
                'badge_class' => $badgeClass,
                'status' => $statusData,
                'beds' => $bedsData,
                'total_beds' => $totalBeds,
                'occupied_beds' => $occupiedBeds,
            ];
        }
        
        return $rooms;
    }

    /**
     * Department xonalari uchun JSON data (JavaScript uchun)
     */
    public function getDepartmentRoomsJson($department): array
    {
        $roomsData = [];
        
        foreach ($department->rooms as $room) {
            $roomsData[$room->id] = [
                'number' => $room->number,
                'type' => $room->roomType->name ?? 'Standart',
                'floor' => $room->floor,
                'capacity' => $room->roomBeds->count(),
                'beds' => $this->prepareRoomBeds($room),
            ];
        }
        
        return $roomsData;
    }

    /**
     * Department xonalari uchun barcha ma'lumotlarni olish
     */
    public function getDepartmentRoomsData($id): array
    {
        $department = Department::with(['rooms.roomType', 'rooms.roomBeds'])->findOrFail($id);
        
        return [
            'department' => $department,
            'stats' => $this->getDepartmentRoomsStats($department),
            'rooms' => $this->prepareDepartmentRooms($department),
            'rooms_json' => $this->getDepartmentRoomsJson($department),
        ];
    }
    
    /**
     * Cache kalitini yaratish
     */
    private function generateCacheKey(Request $request, int $perPage, string $locale): string
    {
        return 'departments_index_' . md5(json_encode([
            'page' => $request->get('page', 1),
            'per_page' => $perPage,
            'locale' => $locale,
            'search' => $request->get('department_search'),
            'status' => $request->get('department_status'),
            'floor' => $request->get('department_floor'),
        ]));
    }
    
    /**
     * Cacheni tozalash
     */
    public function clearDepartmentsCache(): void
    {
        Cache::tags(['departments'])->flush();
    }
    
    /**
     * Department ma'lumotlarini yangilash
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name_uz' => 'required|string|max:255',
                'name_ru' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'floor' => 'required|integer|min:1|max:4',
                'head_doctor_id' => 'nullable|exists:doctors,id',
                'status' => 'required|boolean',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string'
            ]);
            
            $this->departmentService->updateDepartment($id, $validated);
            
            return redirect()->route('department.index')
                ->with('success', 'Bo\'lim muvaffaqiyatli yangilandi!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }

    public function updateDepartment($id, array $data)
    {
        $department = Department::findOrFail($id);
        $department->update([
            'name_uz' => $data['name_uz'],
            'name_ru' => $data['name_ru'],
            'name_en' => $data['name_en'],
            'floor' => $data['floor'],
            'status' => $data['status'],
            'description_uz' => $data['description_uz'] ?? null,
            'description_ru' => $data['description_ru'] ?? null,
            'description_en' => $data['description_en'] ?? null,
        ]);
        
        // Head doctorni yangilash
        if (isset($data['head_doctor_id'])) {
            // Eski head_doctor ni o'chirish
            DepartmentDoctor::where('department_id', $department->id)
                ->where('is_head', true)
                ->delete();
            
            // Yangi head_doctor qo'shish
            if (!empty($data['head_doctor_id'])) {
                DepartmentDoctor::create([
                    'department_id' => $department->id,
                    'doctor_id' => $data['head_doctor_id'],
                    'is_head' => true,
                ]);
            }
        }
        
        $this->clearDepartmentsCache();
        
        return $department;
    }
    
    /**
     * Departmentni o'chirish
     */
    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);
        $result = $department->delete();
        $this->clearDepartmentsCache();
        
        return $result;
    } 
}