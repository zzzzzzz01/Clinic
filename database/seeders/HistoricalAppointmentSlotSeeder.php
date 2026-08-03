<?php

namespace Database\Seeders;

use App\Models\AppointmentSlot;
use App\Models\StaffSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoricalAppointmentSlotSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================================
        // 1. 13 OY OLDIN - 150 ta completed
        // ============================================================
        $startDate1 = Carbon::now()->subMonths(13)->startOfMonth();
        $endDate1 = Carbon::now()->subMonths(13)->endOfMonth();
        $this->createHistoricalSlots($startDate1, $endDate1, 150, 'completed');

        // ============================================================
        // 2. 2 OY OLDIN - 30 ta completed
        // ============================================================
        $startDate2 = Carbon::now()->subMonths(2)->startOfMonth();
        $endDate2 = Carbon::now()->subMonths(2)->endOfMonth();
        $this->createHistoricalSlots($startDate2, $endDate2, 30, 'completed');
    }

    private function createHistoricalSlots($startDate, $endDate, $count, $status)
    {
        // Barcha doctor schedule larini olamiz
        $schedules = StaffSchedule::where('schedulable_type', 'App\Models\Doctor')
            ->where('is_working', 1)
            ->get();

        if ($schedules->isEmpty()) {
            return;
        }

        // Patient ID lar: 1-99 va 201-500
        $patientIds = array_merge(range(1, 99), range(201, 500));
        
        // Ishlatilgan patient_id larni saqlash uchun
        $usedPatientIds = [];

        $created = 0;
        $maxAttempts = $count * 10;
        $attempts = 0;

        while ($created < $count && $attempts < $maxAttempts) {
            $attempts++;
            
            $schedule = $schedules->random();
            
            $date = Carbon::createFromTimestamp(
                rand($startDate->timestamp, $endDate->timestamp)
            );
            
            $dayOfWeek = $date->dayOfWeek;
            if ($schedule->day_id != $dayOfWeek) {
                continue;
            }

            $startTime = Carbon::parse($schedule->start_time);
            $endTime = Carbon::parse($schedule->end_time);
            $lunchStart = Carbon::parse($schedule->lunch_start);
            $lunchEnd = Carbon::parse($schedule->lunch_end);
            $duration = $schedule->appointment_duration;

            $availableSlots = [];
            $currentTime = $startTime->copy();
            
            while ($currentTime < $endTime) {
                if ($currentTime >= $lunchStart && $currentTime < $lunchEnd) {
                    $currentTime = $lunchEnd->copy();
                    continue;
                }
                $slotEnd = $currentTime->copy()->addMinutes($duration);
                if ($slotEnd > $endTime) break;
                
                $availableSlots[] = [
                    'start' => $currentTime->format('H:i:s'),
                    'end' => $slotEnd->format('H:i:s'),
                ];
                
                $currentTime->addMinutes($duration);
            }

            if (empty($availableSlots)) {
                continue;
            }

            $randomSlot = $availableSlots[array_rand($availableSlots)];

            // Takrorlanmaydigan patient_id tanlaymiz
            $availablePatientIds = array_diff($patientIds, $usedPatientIds);
            
            if (empty($availablePatientIds)) {
                break;
            }
            
            $patientId = $availablePatientIds[array_rand($availablePatientIds)];
            $usedPatientIds[] = $patientId;

            AppointmentSlot::create([
                'staff_schedule_id' => $schedule->id,
                'date' => $date->toDateString(),
                'start_time' => $randomSlot['start'],
                'end_time' => $randomSlot['end'],
                'status' => $status,
                'patient_id' => $patientId,
            ]);
            
            $created++;
        }
    }
}