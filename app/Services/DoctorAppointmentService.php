<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\AppointmentSlot;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class DoctorAppointmentService
{
    public function getDoctorAppointmentSlots(Doctor $doctor, $request)
    {
        $selectedDate = $request->get('date', now()->format('Y-m-d'));

        $doctorSlots = AppointmentSlot::whereHas('staffSchedule', function ($q) use ($doctor) {
                $q->where('schedulable_type', Doctor::class)
                  ->where('schedulable_id', $doctor->id);
            })
            ->with($this->withRelations())
            ->where('date', $selectedDate)
            ->orderBy('start_time')
            ->paginate(20)->withQueryString();

        return [
            'doctorSlots' => $doctorSlots,
            'formattedSlots' => $this->formatSlots($doctorSlots),
            'stats' => $this->getStats($doctorSlots),
            'selectedDate' => $selectedDate,
        ];
    }

    private function withRelations(): array
    {
        return [
            'staffSchedule.schedulable.user:id,name,last_name',
            'staffSchedule.schedulable:id,user_id,specialization,birth_date',
            'staffSchedule.day',
            'appointment.patient.user:id,name,last_name,phone',
            'appointment.patient:id,user_id,birth_date',
        ];
    }

    private function formatSlots($slots)
    {
        return $slots->map(function ($slot, $index) {

            $doctorBirthDate = $slot->staffSchedule->schedulable->birth_date ?? null;

            return [
                'id' => $slot->id,
                'index' => $index + 1,
                'status' => $slot->status,
                'doctor_name' => $slot->staffSchedule->schedulable->user->last_name . ' ' . $slot->staffSchedule->schedulable->user->name,
                'doctor_specialty' => $slot->staffSchedule->schedulable->specialization ?? '',
                'doctor_birth_date' => $doctorBirthDate ? Carbon::parse($doctorBirthDate)->format('d.m.Y') : '-',
                'doctor_avatar' => 'AK',
                'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
                'duration' => $slot->staffSchedule->appointment_duration,
                'is_available' => $slot->status === 'available',
                'patient' => $this->getPatientData($slot), 
                'status_badge' => $this->getStatusBadge($slot->status)
            ];
        });
    }

    private function getPatientData($slot)
    {
        if ($slot->status === 'available' || !$slot->appointment || !$slot->appointment->patient) {
            return null;
        }

        $patient = $slot->patient;
        $user = $patient->user;

        $patientBirthDate = $patient->birth_date ?? null;

        return [
            'avatar' => strtoupper(substr($user->name ?? '', 0, 1)),
            'full_name' => ($user->last_name ?? '--') . ' ' . ($user->name ?? '--'),
            'short_name' => ($user->last_name ?? '--') . ' ' . strtoupper(substr($user->name ?? '', 0, 1)) . '.',
            'birth_date' => $patientBirthDate ? Carbon::parse($patientBirthDate)->format('d.m.Y') : '-',
            'phone' => $user->phone ?? '-'
        ];
    }

    private function getStatusBadge($status)
    {
        $badges = [
            'available' => [
                'class' => 'status-available', 
                'icon' => 'fa-clock', 
                'text' => __('words.available')
            ],
            'completed' => [
                'class' => 'status-completed', 
                'icon' => 'fa-check-circle', 
                'text' => __('words.completed')
            ],
            'booked' => [
                'class' => 'status-booked', 
                'icon' => 'fa-user-clock', 
                'text' => __('words.booked')
            ],
            'pending' => [
                'class' => 'status-pending', 
                'icon' => 'fa-hourglass-half', 
                'text' => __('words.pending')
            ],
        ];

        return (object) ($badges[$status] ?? [
            'class' => 'status-unknown',
            'icon' => 'fa-question-circle',
            'text' => __('words.unknown')
        ]);
    }

    private function getStats($slots)
    {
        return (object) [
            'total' => $slots->count(),
            'available' => $slots->where('status', 'available')->count(),
            'booked' => $slots->where('status', 'booked')->count(),
            'pending' => $slots->filter(function ($slot) {
                return $slot->appointment && $slot->appointment->status === 'pending';
            })->count()
        ];
    }


    // Doctor qabullar Admin uchun 


    
        /**
     * 7 kunlik kalendar kunlarini olish
     */
    public function getWeekDates(string $selectedDate): array
    {
        $dates = [];
        $start = Carbon::today();
        // $start = Carbon::parse($selectedDate)->startOfWeek();
        
        for ($i = 0; $i < 7; $i++) {
            $dates[] = $start->copy()->addDays($i);
        }
        
        return $dates;
    }

    /**
     * Shifokorning slotlarini olish (formatlangan)
     */
    public function getDoctorSlots(Doctor $doctor, string $selectedDate): Collection
    {
        $slots = AppointmentSlot::whereHas('staffSchedule', function ($q) use ($doctor) {
                $q->where('schedulable_id', $doctor->id)
                  ->where('schedulable_type', Doctor::class);
            })
            ->whereDate('date', $selectedDate)
            ->with(['staffSchedule.day', 'appointment.patient.user'])
            ->get();
            // dd($slots);

        return $slots->map(fn($slot) => $this->formatSlot($slot));
    }

    /**
     * Bitta slotni formatlash
     */
    public function formatSlot($slot): array
    {
        $status = 'available';
        $statusClass = 'available';
        $statusText = __('words.available');
        $patientData = null;
        $duration = null;

        // Duration ni olish - avval appointment dan, keyin slot dan
        if ($slot->appointment && $slot->appointment->duration) {
            $duration = $slot->appointment->duration;
        } elseif ($slot->duration) {
            $duration = $slot->duration;
        } elseif ($slot->staffSchedule && $slot->staffSchedule->duration) {
            $duration = $slot->staffSchedule->duration;
        }

        if ($slot->appointment) {
            $slotStatus = $slot->status ?? 'booked';
            
            $statusMap = [
                'pending' => [
                    'class' => 'pending',
                    'text' => __('words.pending')
                ],
                'completed' => [
                    'class' => 'completed',
                    'text' => __('words.completed')
                ],
                'booked' => [
                    'class' => 'booked',
                    'text' => __('words.booked')
                ],
                'confirmed' => [
                    'class' => 'confirmed',
                    'text' => __('words.confirmed')
                ],
                'cancelled' => [
                    'class' => 'cancelled',
                    'text' => __('words.cancelled')
                ],
            ];
            
            if (isset($statusMap[$slotStatus])) {
                $statusClass = $statusMap[$slotStatus]['class'];
                $statusText = $statusMap[$slotStatus]['text'];
                $status = $slotStatus;
            } else {
                $statusClass = 'booked';
                $statusText = __('words.booked');
                $status = 'booked';
            }
            
            if ($slot->appointment->patient && $slot->appointment->patient->user) {
                $patient = $slot->appointment->patient;
                $user = $patient->user;
                
                $patientData = [
                    'name' => $user->last_name . ' ' . $user->name,
                    'phone' => $user->phone ?? '',
                    'passport' => trim(($patient->passport_series ?? '') . ' ' . ($patient->passport_number ?? '')),
                    'birth_date' => $patient->birth_date ? Carbon::parse($patient->birth_date)->format('d.m.Y') : '',
                    'age' => $patient->birth_date ? Carbon::parse($patient->birth_date)->age : null,
                    'created_at' => $user->created_at ? Carbon::parse($user->created_at)->format('d.m.Y, H:i') : '',
                    'reason' => $slot->appointment->reason ?? ''
                ];
            }
        }

        return [
            'id' => $slot->id,
            'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
            'end_time' => Carbon::parse($slot->end_time)->format('H:i'),
            'date' => $slot->date,
            'status' => $status,
            'status_class' => $statusClass,
            'status_text' => $statusText,
            'patient' => $patientData,
            'duration' => $duration,
        ];
    }

    /**
     * Statistik ma'lumotlar
     */
    public function getStatistics(Doctor $doctor, string $selectedDate): array
    {
        $baseQuery = AppointmentSlot::whereHas('staffSchedule', function ($q) use ($doctor) {
            $q->where('schedulable_id', $doctor->id)
              ->where('schedulable_type', Doctor::class);
        });

        return [
            'total' => $baseQuery->count(),
            'today' => $baseQuery->whereDate('date', Carbon::today())->count(),
            'pending' => $baseQuery->whereHas('appointment', fn($q) => $q->where('status', 'booked'))
                                   ->whereDate('date', $selectedDate)
                                   ->count()
        ];
    }

    /**
     * Hafta oralig'ini olish
     */
    public function getWeekRange(array $dates): string
    {
        return "Hafta: {$dates[0]->format('d M')} - {$dates[6]->format('d M')}";
    }

    public function prepareDateButtons(string $selectedDate): array
    {
        $buttons = [];
        $today = Carbon::today();
        $currentLocale = App::getLocale();
        
        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->addDays($i);
            $fullDate = $date->format('Y-m-d');
            $dayKey = strtolower($date->format('l'));
            $isTodayDate = $i === 0;
            $isActive = $selectedDate === $fullDate;
            $isWeekend = in_array($date->format('w'), [0, 6]);
            
            // 3 xil tildagi nomlarni olish
            $uzName = $this->getDayNameInLocale($dayKey, 'uz');
            $ruName = $this->getDayNameInLocale($dayKey, 'ru');
            $enName = $this->getDayNameInLocale($dayKey, 'en');
            
            $shortUz = $this->getShortDayNameInLocale($dayKey, 'uz');
            $shortRu = $this->getShortDayNameInLocale($dayKey, 'ru');
            $shortEn = $this->getShortDayNameInLocale($dayKey, 'en');
            
            $classes = [];
            if ($isTodayDate) $classes[] = 'today';
            if ($isWeekend && !$isTodayDate) $classes[] = 'weekend';
            if ($isActive) $classes[] = 'active';
            
            $buttons[] = [
                'full_date' => $fullDate,
                // Hozirgi til bo'yicha (ko'rsatish uchun)
                'day_name' => $this->getDayNameInLocale($dayKey, $currentLocale),
                'day_name_short' => $this->getShortDayNameInLocale($dayKey, $currentLocale),
                // 3 til to'liq
                'uz_full' => $uzName,
                'ru_full' => $ruName,
                'en_full' => $enName,
                // 3 til qisqa
                'uz_short' => $shortUz,
                'ru_short' => $shortRu,
                'en_short' => $shortEn,
                'date_number' => $date->format('d'),
                'month_name' => $date->format('M'),
                'class' => implode(' ', $classes),
                'is_today' => $isTodayDate,
                'is_active' => $isActive,
                'show_today_badge' => $isTodayDate && !$isActive,
                'show_current_day' => $isTodayDate && $isActive,
            ];
        }
        
        return $buttons;
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
                'thursday' => 'PA', 'friday' => 'JU', 'saturday' => 'SH', 'sunday' => 'YA'
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
     * Selected date ma'lumotlari
     */
    public function getSelectedDateInfo(string $selectedDate): array
    {
        $dateObj = Carbon::parse($selectedDate);
        $isToday = $dateObj->isToday();
        
        return [
            'object' => $dateObj,
            'is_today' => $isToday,
            'button_text' => $isToday ? 'Bugun' : $dateObj->format('d.m'),
            'formatted' => $dateObj->format('d.m.Y'),
        ];
    }


}