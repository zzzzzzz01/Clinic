<?php

namespace App\Services;

use App\Models\StaffSchedule;
use Illuminate\Http\Request;

class ScheduleService
{
    /**
     * Schedulable modelni topish
     */
    public function findSchedulable($type, $id)
    {
        return match($type) {
            'doctor' => \App\Models\Doctor::findOrFail($id),
            'nurse' => \App\Models\Nurse::findOrFail($id),
            default => abort(404),
        };
    }

    /**
     * Validatsiya qoidalari
     */
    public function validationRules(): array
    {
        return [
            'days.*.is_working'           => 'required|boolean',
            'days.*.start_time'           => 'nullable|date_format:H:i',
            'days.*.end_time'             => 'nullable|date_format:H:i|after:days.*.start_time',
            'days.*.lunch_start'          => 'nullable|date_format:H:i',    
            'days.*.lunch_end'            => 'nullable|date_format:H:i|after:days.*.lunch_start',
            'days.*.appointment_duration' => 'nullable|integer|min:1|max:120',
        ];
    }

    /**
     * Ma'lumotlarni tayyorlash
     */
    private function prepareData(array $data): array
    {
        $isWorking = $data['is_working'] ?? false;

        if (!$isWorking) {
            return [
                'is_working' => false,
                'start_time' => null,
                'end_time' => null,
                'lunch_start' => null,
                'lunch_end' => null,
                'appointment_duration' => null,
            ];
        }

        return [
            'is_working' => true,
            'start_time' => !empty($data['start_time']) ? $data['start_time'] : null,
            'end_time' => !empty($data['end_time']) ? $data['end_time'] : null,
            'lunch_start' => !empty($data['lunch_start']) ? $data['lunch_start'] : null,
            'lunch_end' => !empty($data['lunch_end']) ? $data['lunch_end'] : null,
            'appointment_duration' => $data['appointment_duration'] ?? 30,
        ];
    }

    /**
     * Jadvalni saqlash yoki yangilash - FAQAT O'ZGARGAN YANGI MA'LUMOTLARNI SAQLAYDI
     */
    public function saveOrUpdate($schedulable, array $days, $hasExistingSchedule): array
    {
        $savedDays = []; // Yangi yaratilgan kunlar
        $updatedDays = []; // Yangilangan kunlar
        $dayNames = [
            1 => 'Dushanba', 2 => 'Seshanba', 3 => 'Chorshanba', 
            4 => 'Payshanba', 5 => 'Juma', 6 => 'Shanba', 7 => 'Yakshanba'
        ];

        foreach ($days as $dayId => $data) {
            // Mavjud jadvalni topish
            $existingSchedule = StaffSchedule::where([
                'schedulable_id' => $schedulable->id,
                'schedulable_type' => get_class($schedulable),
                'day_id' => $dayId,
            ])->first();

            $newData = $this->prepareData($data);
            
            // Agar ma'lumot o'zgarmagan bo'lsa, skip qilish
            if ($existingSchedule) {
                $currentData = [
                    'is_working' => $existingSchedule->is_working,
                    'start_time' => $existingSchedule->start_time,
                    'end_time' => $existingSchedule->end_time,
                    'lunch_start' => $existingSchedule->lunch_start,
                    'lunch_end' => $existingSchedule->lunch_end,
                    'appointment_duration' => $existingSchedule->appointment_duration,
                ];
                
                // Agar ma'lumotlar bir xil bo'lsa, o'tkazib yuborish
                if ($currentData == $newData) {
                    continue;
                }
            }
            
            // Agar yangi ma'lumot is_working = false va boshqa maydonlar null bo'lsa
            // va eski ma'lumot ham mavjud bo'lmasa, skip qilish
            if (!$newData['is_working'] && 
                $newData['start_time'] === null && 
                $newData['end_time'] === null && 
                !$existingSchedule) {
                continue;
            }

            // Saqlash yoki yangilash
            $schedule = StaffSchedule::updateOrCreate(
                [
                    'schedulable_id' => $schedulable->id,
                    'schedulable_type' => get_class($schedulable),
                    'day_id' => $dayId,
                ],
                $newData
            );

            if ($schedule->wasRecentlyCreated) {
                $savedDays[] = $dayNames[$dayId];
            } elseif ($schedule->wasChanged()) {
                $updatedDays[] = $dayNames[$dayId];
            }
        }

        return [
            'saved' => count($savedDays),
            'updated' => count($updatedDays),
            'saved_days' => $savedDays,
            'updated_days' => $updatedDays,
        ];
    }

    /**
     * Statistik ma'lumotlar
     */
    public function getStatistics($schedules): array
    {
        $workingDaysCount = $schedules->filter(fn($s) => $s->is_working)->count();
        
        $totalWorkingHours = $schedules->reduce(function($carry, $schedule) {
            if (!$schedule->is_working || !$schedule->start_time || !$schedule->end_time) {
                return $carry;
            }
            
            $start = \Carbon\Carbon::parse($schedule->start_time);
            $end = \Carbon\Carbon::parse($schedule->end_time);
            $lunchStart = $schedule->lunch_start ? \Carbon\Carbon::parse($schedule->lunch_start) : null;
            $lunchEnd = $schedule->lunch_end ? \Carbon\Carbon::parse($schedule->lunch_end) : null;
            
            $hours = $end->diffInHours($start);
            
            if ($lunchStart && $lunchEnd) {
                $hours -= $lunchEnd->diffInHours($lunchStart);
            }
            
            return $carry + $hours;
        }, 0);
        
        return [
            'working_days_count' => $workingDaysCount,
            'total_working_hours' => $totalWorkingHours,
        ];
    }

    /**
     * Kun uchun qiymatlar
     */
    public function getDefaultForDay($schedule, $dayId)
    {
        if ($schedule) {
            return (object) [
                'is_working' => $schedule->is_working,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'lunch_start' => $schedule->lunch_start,
                'lunch_end' => $schedule->lunch_end,
                'appointment_duration' => $schedule->appointment_duration,
            ];
        }

        return (object) [
            'is_working' => false,
            'start_time' => null,
            'end_time' => null,
            'lunch_start' => null,
            'lunch_end' => null,
            'appointment_duration' => null,
        ];
    }
}