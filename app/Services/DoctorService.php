<?php

namespace App\Services;

use Carbon\Carbon; 
use App\Models\Doctor;
use App\Models\Department;
use App\Models\StaffSchedule;
use App\Models\AppointmentSlot;
use App\Models\Appointment;
use App\Models\DaysOfWeek;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class DoctorService
{
    /**
     * Doktorlar ro'yxatini olish (filtr bilan) 
     */
    public function getDoctors(array $filters, int $perPage = 10): array 
    {
        $currentLocale = App::getLocale();
        $cacheKey = $this->generateCacheKey($filters, $perPage, $currentLocale);
        
        return Cache::tags(['doctors'])->remember($cacheKey, 300, function () use ($filters, $perPage, $currentLocale) {
            $query = Doctor::with(['user', 'departments']);
            
            if (!empty($filters['search'])) {
                $search = $filters['search'];
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('login', 'like', "%{$search}%");
                });
            }
            
            if (!empty($filters['status']) && $filters['status'] !== 'all') {
                $query->where('doctors.status', $filters['status']);
            }
            
            if (!empty($filters['department']) && $filters['department'] !== 'all') {
                $query->whereHas('departments', function($q) use ($filters) {
                    $q->where('departments.id', $filters['department']);
                });
            }
            
            if (!empty($filters['date_from'])) {
                $query->whereDate('doctors.created_at', '>=', $filters['date_from']);
            }
            
            if (!empty($filters['date_to'])) {
                $query->whereDate('doctors.created_at', '<=', $filters['date_to']);
            }
            
            $doctors = $query->paginate($perPage)->withQueryString();
            $departments = $this->getDepartmentsWithLocalizedName();
            $formattedDoctors = $this->formatDoctorsForList($doctors, $currentLocale);
            
            return [
                'doctors' => $doctors,
                'departments' => $departments,
                'formattedDoctors' => $formattedDoctors
            ];
        });
    }
    
    /**
     * Doktorlarni LIST uchun formatlash (index sahifasi)
     */
    public function formatDoctorsForList($doctors, string $locale = null): array
    {
        $locale = $locale ?? App::getLocale();
        $formattedDoctors = [];
        
        foreach ($doctors as $doctor) {
            $departmentName = $this->getDepartmentLocalizedName($doctor, $locale);
            $statusConfig = $this->getStatusConfig($doctor->status);
            
            $formattedDoctors[] = (object)[
                'id' => $doctor->id,
                'user' => $doctor->user,
                'department_name' => $departmentName,
                'experience_years' => $doctor->experience_years,
                'created_at' => $doctor->created_at,
                'status' => $doctor->status,
                'status_text' => $statusConfig['text'],
                'status_text_color' => $statusConfig['text_color'],
                'status_bg_color' => $statusConfig['bg_color'],
                'status_icon' => $statusConfig['icon'],
                'photo' => $doctor->photo,
                'role' => $doctor->role ?? 'doctor',
                'has_unread_notifications' => 0,
            ];
        }
        
        return $formattedDoctors;
    }
    
    /**
     * Doctor ma'lumotlarini SHOW uchun formatlash
     */
    public function formatDoctorForView(Doctor $doctor): object
    {
        $statusConfig = $this->getFullStatusConfig($doctor->status);
        $user = $doctor->user;
        
        $fullName = $user->name . ' ' . $user->last_name;
        $avatarInitials = substr($user->name, 0, 1) . substr($user->last_name, 0, 1);
        
        $createdAt = Carbon::parse($doctor->created_at);
        $updatedAt = Carbon::parse($doctor->updated_at);
        
        $birthDate = null;
        $age = null;
        if ($doctor->birth_date) {
            $birthDateObj = Carbon::parse($doctor->birth_date);
            $birthDate = $birthDateObj->format('d.m.Y');
            $age = $birthDateObj->age;
        }
        
        $email = $user->email ?? $user->login . '@hospital.uz';
        $address = $doctor->address ?? __('words.not_available');
        $description = $doctor->description ?? __('words.no_additional_info');
        $statusChangedAt = $doctor->status_changed_at ? Carbon::parse($doctor->status_changed_at) : null;
        $formattedId = 'NRS-' . str_pad($doctor->id, 5, '0', STR_PAD_LEFT);
        
        $timelineItems = [
            [
                'icon' => 'fas fa-user-plus',
                'title' => __('words.added_to_system'),
                'date' => $createdAt->format('d.m.Y H:i'),
                'description' => __('words.doctor_added_description')
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
            'specialization' => $doctor->specialization ?? __('words.not_specified'),
            'experience_years' => $doctor->experience_years,
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
            'print_status_text' => $this->getPrintStatusText($doctor->status),
        ];
    }
    
    /**
     * Login generatsiya qilish
     */
    public function generateLogin(): string
    {
        $lastUser = User::where('login', 'regexp', '^[0-9]+$')
                        ->orderBy('login', 'desc')
                        ->first();
        
        if ($lastUser && is_numeric($lastUser->login)) {
            $newLogin = (int)$lastUser->login + 1;
        } else {
            $newLogin = date('Ymd') . rand(100, 999);
        }
        
        while (User::where('login', $newLogin)->exists()) {
            $newLogin = is_numeric($newLogin) ? $newLogin + 1 : date('Ymd') . rand(1000, 9999);
        }
        
        return (string)$newLogin;
    }
    
    /**
     * Bo'lim nomini lokalizatsiya qilish
     */
    private function getDepartmentLocalizedName(Doctor $doctor, string $locale): string
    {
        if (!$doctor->departments || $doctor->departments->isEmpty()) {
            return '-';
        }
        
        $department = $doctor->departments->first();
        
        return match($locale) {
            'ru' => $department->name_ru ?? $department->name_uz ?? '-',
            'en' => $department->name_en ?? $department->name_uz ?? '-',
            default => $department->name_uz ?? '-',
        };
    }
    
    /**
     * Barcha bo'limlarni lokalizatsiya qilingan nom bilan olish
     */
    public function getDepartmentsWithLocalizedName(): array
    {
        $locale = App::getLocale();
        $departments = Department::all();
        
        $formattedDepartments = [];
        foreach ($departments as $department) {
            $name = match($locale) {
                'ru' => $department->name_ru ?? $department->name_uz,
                'en' => $department->name_en ?? $department->name_uz,
                default => $department->name_uz,
            };
            
            $formattedDepartments[] = (object)[
                'id' => $department->id,
                'name' => $name,
            ];
        }
        
        return $formattedDepartments;
    }
    
    /**
     * Status konfiguratsiyasi (LIST uchun)
     */
    private function getStatusConfig(string $status): array
    {
        return match($status) {
            'active' => [
                'text' => __('words.active'),
                'text_color' => '#27ae60',
                'bg_color' => '#e8f8f5',
                'icon' => 'fas fa-circle-check'
            ],
            'on_leave' => [
                'text' => __('words.on_leave'),
                'text_color' => '#f39c12',
                'bg_color' => '#fef9e7',
                'icon' => 'fas fa-umbrella-beach'
            ],
            'inactive' => [
                'text' => __('words.inactive'),
                'text_color' => '#e74c3c',
                'bg_color' => '#fdedec',
                'icon' => 'fas fa-circle-xmark'
            ],
            default => [
                'text' => __('words.unknown'),
                'text_color' => '#95a5a6',
                'bg_color' => '#f5f5f5',
                'icon' => 'fas fa-question-circle'
            ],
        };
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
    
    /**
     * Cache kalitini yaratish
     */
    private function generateCacheKey(array $filters, int $perPage, string $locale): string
    {
        return 'doctors_index_' . md5(json_encode([
            'page' => request()->get('page', 1),
            'per_page' => $perPage,
            'locale' => $locale,
            'search' => $filters['search'] ?? null,
            'status' => $filters['status'] ?? null,
            'department' => $filters['department'] ?? null,
            'date_from' => $filters['date_from'] ?? null,
            'date_to' => $filters['date_to'] ?? null,
        ]));
    }
    
    /**
     * Active filterlar sonini hisoblash
     */
    public function getActiveFiltersCount(array $filters): int
    {
        $count = 0;
        
        if (!empty($filters['search'])) $count++;
        if (!empty($filters['status']) && $filters['status'] !== 'all') $count++;
        if (!empty($filters['department']) && $filters['department'] !== 'all') $count++;
        if (!empty($filters['date_from'])) $count++;
        if (!empty($filters['date_to'])) $count++;
        
        return $count;
    }
    
    /**
     * Cacheni tozalash
     */
    public function clearDoctorsCache(): void
    {
        Cache::tags(['doctors'])->flush();
    }

    /**
     * Doktor ma'lumotlarini tayyorlash
     */
    public function prepareDoctorData(Doctor $doctor): array
    {
        return [
            'id' => $doctor->id,
            'name' => $doctor->user?->name ?? 'Shifokor',
            'last_name' => $doctor->user?->last_name ?? '',
            'full_name' => trim(($doctor->user?->last_name ?? '') . ' ' . ($doctor->user?->name ?? 'Shifokor')),
            'has_user' => $doctor->user !== null
        ];
    }
    
    /**
     * Doktor uchun sanalar ro'yxatini tayyorlash
     */
    public function getDatesList(string $selectedDate): Collection
    {
        $startDate = now();
        $dates = collect();
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dates->push($date);
        }
        
        return $dates;
    }
    
    /**
     * Sana uchun tugma matnini olish
     */
    public function getDateButtonText(string $selectedDate): array
    {
        $selectedDateObj = Carbon::parse($selectedDate);
        $isToday = $selectedDateObj->isToday();
        
        return [
            'isToday' => $isToday,
            'buttonText' => $isToday ? 'Bugun' : $selectedDateObj->format('d.m'),
        ];
    }
    
    /**
     * Kun ma'lumotlarini tayyorlash (locale bilan)
     */
    public function prepareDateData(Carbon $date, string $selectedDate, string $locale = 'uz'): array
    {
        $fullDate = $date->format('Y-m-d');
        $dayKey = strtolower($date->format('l'));
        $dayName = $this->getDayNameInLocale($dayKey, $locale);
        $dayNameShort = $this->getShortDayNameInLocale($dayKey, $locale);
        $dateNumber = $date->format('d');
        $monthName = $date->format('M');
        $isActive = $selectedDate == $fullDate;
        $isToday = now()->format('Y-m-d') == $fullDate;
        $isWeekend = in_array($date->format('w'), [0, 6]);
        
        $dayClass = '';
        if ($isToday && $isWeekend) {
            $dayClass = 'today weekend';
        } elseif ($isToday) {
            $dayClass = 'today';
        } elseif ($isWeekend) {
            $dayClass = 'weekend';
        }
        
        return [
            'fullDate' => $fullDate,
            'dayName' => $dayNameShort,
            'dayNameFull' => $dayName,
            'dateNumber' => $dateNumber,
            'monthName' => $monthName,
            'isActive' => $isActive,
            'isToday' => $isToday,
            'dayClass' => $dayClass
        ];
    }
    
    /**
     * Boshqa tildagi to'liq kun nomini olish
     */
    private function getDayNameInLocale(string $dayKey, string $locale): string
    {
        $translations = [
            'uz' => [
                'monday' => 'Dushanba', 'tuesday' => 'Seshanba', 'wednesday' => 'Chorshanba',
                'thursday' => 'Payshanba', 'friday' => 'Juma', 'saturday' => 'Shanba', 'sunday' => 'Yakshanba'
            ],
            'ru' => [
                'monday' => 'Понедельник', 'tuesday' => 'Вторник', 'wednesday' => 'Среда',
                'thursday' => 'Четверг', 'friday' => 'Пятница', 'saturday' => 'Суббота', 'sunday' => 'Воскресенье'
            ],
            'en' => [
                'monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday',
                'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday'
            ]
        ];
        
        return $translations[$locale][$dayKey] ?? $dayKey;
    }
    
    /**
     * Boshqa tildagi qisqa kun nomini olish
     */
    private function getShortDayNameInLocale(string $dayKey, string $locale): string
    {
        $translations = [
            'uz' => [
                'monday' => 'DU', 'tuesday' => 'SE', 'wednesday' => 'CH',
                'thursday' => 'PAY', 'friday' => 'JU', 'saturday' => 'SHA', 'sunday' => 'YAK'
            ],
            'ru' => [
                'monday' => 'ПН', 'tuesday' => 'ВТ', 'wednesday' => 'СР',
                'thursday' => 'ЧТ', 'friday' => 'ПТ', 'saturday' => 'СБ', 'sunday' => 'ВС'
            ],
            'en' => [
                'monday' => 'MO', 'tuesday' => 'TU', 'wednesday' => 'WE',
                'thursday' => 'TH', 'friday' => 'FR', 'saturday' => 'SA', 'sunday' => 'SU'
            ]
        ];
        
        return $translations[$locale][$dayKey] ?? $dayKey;
    }
    
    /**
     * Doktorning qabul/qaydlarini olish (faqat booked va completed)
     */
    public function getDoctorAppointments(Doctor $doctor, string $selectedDate): Collection
    {
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->whereDate('date', $selectedDate)
            ->whereIn('status', ['booked', 'completed'])
            ->with(['patient.user'])
            ->orderBy('created_at', 'asc')
            ->get();

            // dd($appointments);

        return $appointments;
    }
    
    /**
     * Qabul/qayd ma'lumotlarini tayyorlash
     */
    public function prepareAppointmentData($appointment): array
    {
        $status = $appointment->status ?? 'booked';
        
        switch($status) {
            case 'completed':
                $statusClass = 'completed';
                $statusText = __('words.completed');
                break;
            case 'booked':
                $statusClass = 'booked';
                $statusText = __('words.booked');
                break;
            default:
                return [];
        }
        
        $patientData = [];
        
        if ($appointment->patient && $appointment->patient->user) {
            $patient = $appointment->patient;
            $user = $patient->user;
            
            $patientData = [
                'name' => trim(($user->last_name ?? '') . ' ' . ($user->name ?? __('words.patient'))),
                'phone' => $user->phone ?? '',
                'reason' => $appointment->reason ?? '',
                'passport' => ($patient->passport_series ?? '') . ' ' . ($patient->passport_number ?? ''),
                'birth_date' => $patient->birth_date ? Carbon::parse($patient->birth_date)->format('d.m.Y') : '',
                'age' => $patient->birth_date ? Carbon::parse($patient->birth_date)->age : '',
                'created_at' => $user->created_at ? Carbon::parse($user->created_at)->format('d.m.Y, H:i') : ''
            ];
        }
        
        // Agar appointment_slot dan vaqt olish kerak bo'lsa
        $startTime = '';
        $endTime = '';
        if ($appointment->appointmentSlot) {
            $startTime = Carbon::parse($appointment->appointmentSlot->start_time)->format('H:i');
            $endTime = Carbon::parse($appointment->appointmentSlot->end_time)->format('H:i');
        }

        // dd($startTime, $endTime);
        
        $appointmentJsonData = [
            'id' => $appointment->id,
            'date' => $appointment->date,
            'status' => $status,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'patient' => $patientData,
            'reason' => $appointment->reason,
            'notes' => $appointment->notes,
            'treatment_type' => $appointment->treatment_type
        ];
        
        return [
            'id' => $appointment->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => $status,
            'statusClass' => $statusClass,
            'statusText' => $statusText,
            'patientName' => $patientData['name'] ?? '',
            'patientPhone' => $patientData['phone'] ?? '',
            'patientReason' => $appointment->reason ?? '',
            'patientPassport' => $patientData['passport'] ?? '',
            'patientBirthDate' => $patientData['birth_date'] ?? '',
            'patientAge' => $patientData['age'] ?? '',
            'patientCreatedAt' => $patientData['created_at'] ?? '',
            'patientNameShort' => isset($patientData['name']) ? Str::limit($patientData['name'], 15) : '',
            'patientReasonShort' => isset($appointment->reason) ? Str::limit($appointment->reason, 20) : '',
            'treatment_type' => $appointment->treatment_type ?? '',
            'notes' => $appointment->notes ?? '',
            'jsonData' => json_encode($appointmentJsonData)
        ];
    }
    
    /**
     * Qabul/qaydlar ro'yxatini tayyorlash
     */
    public function prepareAppointmentsData($appointments): array
    {
        $preparedAppointments = [];
        
        foreach ($appointments as $appointment) {
            $prepared = $this->prepareAppointmentData($appointment);
            if (!empty($prepared)) {
                $preparedAppointments[] = $prepared;
            }
        }
        
        return $preparedAppointments;
    }
}