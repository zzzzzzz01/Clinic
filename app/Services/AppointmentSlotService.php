<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\StaffSchedule;
use App\Models\AppointmentSlot;

class AppointmentSlotService
{
    public function generateSlotsForPeriod($schedulable, string $startDate, string $endDate): array
    {
        $period = CarbonPeriod::create($startDate, $endDate);

        // Bitta query bilan barcha jadvallarni olib, day_id bo'yicha guruhlaymiz (N+1 muammosini hal qiladi)
        $schedules = StaffSchedule::where('schedulable_id', $schedulable->id)
            ->where('schedulable_type', get_class($schedulable))
            ->get()
            ->keyBy('day_id');

        $days = [];

        $weekdays = [
            1 => __('words.monday'),
            2 => __('words.tuesday'),
            3 => __('words.wednesday'),
            4 => __('words.thursday'),
            5 => __('words.friday'),
            6 => __('words.saturday'),
            7 => __('words.sunday'),
        ];

        foreach ($period as $date) {
            $carbonDay = $date->dayOfWeek;
            // Carbon: 0 (Yakshanba) - 6 (Shanba)
            // Bizning day_id: 1 (Dushanba) - 7 (Yakshanba)
            $dayId = $carbonDay === 0 ? 7 : $carbonDay;

            $schedule = $schedules->get($dayId);
            $isWorking = $schedule?->is_working ?? 0;

            $days[] = [
                'date'       => $date->format('Y-m-d'),
                'weekday' => $weekdays[$dayId],
                'is_working' => $isWorking,
                'start_time' => $schedule->start_time ?? null,
                'end_time'   => $schedule->end_time ?? null,
                'duration'   => $schedule->appointment_duration ?? null,
                'slots'      => $isWorking ? $this->generateSlots($schedule) : [],
                'slot_count' => $isWorking ? count($this->generateSlots($schedule)) : 0,
            ];
        }

        return $days;
    }

    private function generateSlots(StaffSchedule $schedule): array
    {
        if (!$schedule->start_time || !$schedule->end_time || !$schedule->appointment_duration) {
            return [];
        }

        // Carbon::parse() loop tashqarisida bir marta chaqiriladi
        $start   = Carbon::parse($schedule->start_time);
        $end     = Carbon::parse($schedule->end_time);
        $current = $start->copy();

        $lunchStart = $schedule->lunch_start ? Carbon::parse($schedule->lunch_start) : null;
        $lunchEnd   = $schedule->lunch_end   ? Carbon::parse($schedule->lunch_end)   : null;

        $slots = [];

        while ($current < $end) {
            $next = $current->copy()->addMinutes($schedule->appointment_duration);

            if ($next > $end) {
                break;
            }

            // Tushlik tanaffusiga to'g'ri kelsa o'tkazib yuboramiz
            if ($lunchStart && $lunchEnd && $current < $lunchEnd && $next > $lunchStart) {
                $current = $lunchEnd->copy();
                continue;
            }

            $slots[] = [
                'start' => $current->format('H:i'),
                'end'   => $next->format('H:i'),
            ];

            $current = $next;
        }

        return $slots;
    }

    /**
     * Slotlarni saqlash (switch bilan ishlaydi)
     */
    public function storeSlots($schedulable, array $selectedSlotsData, array $workingDays): array
    {
         // 1. OLDINGI available slotlarni o‘chirish
        AppointmentSlot::whereHas('staffSchedule', function ($q) use ($schedulable) {
            $q->where('schedulable_id', $schedulable->id)
            ->where('schedulable_type', get_class($schedulable));
        })
        ->where('status', 'available')
        ->delete();

        $savedCount = 0;
        $skippedCount = 0;
        $disabledCount = 0;
        $slotsToCreate = [];

        foreach ($selectedSlotsData as $date => $selectedSlotsString) {
            // Switch o'chirilgan kunlarni tekshirish
            $isWorking = isset($workingDays[$date]) && $workingDays[$date] == 1;
            
            if (!$isWorking) {
                $disabledCount++;
                continue; // Bu kun uchun slot yaratilmaydi
            }

            $selectedSlots = empty($selectedSlotsString) ? [] : explode(',', $selectedSlotsString);

            $dayId = Carbon::parse($date)->dayOfWeek;
            $dayId = $dayId == 0 ? 7 : $dayId;

            $staffSchedule = StaffSchedule::where('schedulable_id', $schedulable->id)
                ->where('schedulable_type', get_class($schedulable))
                ->where('day_id', $dayId)
                ->first();

            if (!$staffSchedule || !$staffSchedule->is_working) {
                continue;
            }

            $slots = $this->generateSlotsForDate($staffSchedule, $date);
            
            foreach ($slots as $slot) {
                $slotKey = $date . '_' . $slot['start'];
                
                if (!in_array($slotKey, $selectedSlots)) {
                    $slotsToCreate[] = [
                        'staff_schedule_id' => $staffSchedule->id,
                        'date'              => $date,
                        'start_time'        => $slot['start'],
                        'end_time'          => $slot['end'],
                        'status'            => 'available',
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ];
                }
            }
        }

        // Duplicate check va insert
        if (!empty($slotsToCreate)) {
            $result = $this->insertUniqueSlots($slotsToCreate); 
            $savedCount = $result['saved'];
            $skippedCount = $result['skipped'];
        }

        return [
            'saved' => $savedCount,
            'skipped' => $skippedCount,
            'disabled' => $disabledCount
        ];
    }

    /**
     * Kun uchun slotlarni generate qilish (cache bilan)
     */
    private function generateSlotsForDate(StaffSchedule $schedule, string $date): array
    {
        $cacheKey = "slots_{$schedule->id}_{$date}";
        
        return cache()->remember($cacheKey, now()->addHours(6), function() use ($schedule) {
            return $this->generateSlots($schedule);
        });
    }

    /**
     * Unikal slotlarni insert qilish
     */
    private function insertUniqueSlots(array $slotsToCreate): array
    {
        $savedCount = 0;
        $skippedCount = 0;

        foreach ($slotsToCreate as $index => $slot) {
            $exists = AppointmentSlot::where('staff_schedule_id', $slot['staff_schedule_id'])
                ->where('date', $slot['date'])
                ->where('start_time', $slot['start_time'])
                ->exists();

            if ($exists) {
                $skippedCount++;
                unset($slotsToCreate[$index]);
            }
        }

        if (!empty($slotsToCreate)) {
            AppointmentSlot::insert(array_values($slotsToCreate));
            $savedCount = count($slotsToCreate);
        }

        return [
            'saved' => $savedCount,
            'skipped' => $skippedCount
        ];
    }
}