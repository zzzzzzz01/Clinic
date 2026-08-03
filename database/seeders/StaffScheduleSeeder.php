<?php

namespace Database\Seeders;

use App\Models\StaffSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // ============ DOCTORLAR UCHUN (31 ta) ============
        // Har bir doctor uchun alohida jadval
        // doctor_id = 1 -> a
        // doctor_id = 2 -> b
        // doctor_id = 3 -> c
        // doctor_id = 4 -> d
        // doctor_id = 5 -> e
        // doctor_id = 6 -> f
        // doctor_id = 7 -> g
        // doctor_id = 8 -> a
        // doctor_id = 9 -> b
        // ... va hokazo

        $doctorSchedules = [
            1  => 'a', 2  => 'b', 3  => 'c', 4  => 'd', 5  => 'e',
            6  => 'f', 7  => 'g', 8  => 'a', 9  => 'b', 10 => 'c',
            11 => 'd', 12 => 'e', 13 => 'f', 14 => 'g', 15 => 'a',
            16 => 'b', 17 => 'c', 18 => 'd', 19 => 'e', 20 => 'f',
            21 => 'g', 22 => 'a', 23 => 'b', 24 => 'c', 25 => 'd',
            26 => 'e', 27 => 'f', 28 => 'g', 29 => 'a', 30 => 'b',
            31 => 'c',
        ];

        $schedules = [
            'a' => ['days' => [1, 2, 3, 4, 5], 'start_time' => '09:00', 'end_time' => '17:00'],
            'b' => ['days' => [1, 2, 3, 4, 5], 'start_time' => '13:00', 'end_time' => '19:00'],
            'c' => ['days' => [1, 2, 3, 4, 5], 'start_time' => '07:00', 'end_time' => '12:00'],
            'd' => ['days' => [1, 3, 5], 'start_time' => '09:00', 'end_time' => '17:00'],
            'e' => ['days' => [2, 4, 6], 'start_time' => '09:00', 'end_time' => '17:00'],
            'f' => ['days' => [1, 3, 5], 'start_time' => '13:00', 'end_time' => '19:00'],
            'g' => ['days' => [2, 4, 6], 'start_time' => '07:00', 'end_time' => '12:00'],
        ];

        // DOCTORLAR
        foreach ($doctorSchedules as $doctorId => $scheduleKey) {
            $schedule = $schedules[$scheduleKey];
            
            for ($day = 1; $day <= 7; $day++) {
                $isWorking = in_array($day, $schedule['days']) ? 1 : 0;
                
                StaffSchedule::create([
                    'schedulable_type' => 'App\Models\Doctor',
                    'schedulable_id' => $doctorId,
                    'day_id' => $day,
                    'start_time' => $isWorking ? $schedule['start_time'] : null,
                    'end_time' => $isWorking ? $schedule['end_time'] : null,
                    'lunch_start' => $isWorking ? '12:00' : null,
                    'lunch_end' => $isWorking ? '13:00' : null,
                    'appointment_duration' => $isWorking ? 30 : null,
                    'is_working' => $isWorking,
                ]);
            }
        }

        // ============ NURSELAR (45 ta) ============
        // Nurse lar uchun ham xuddi shunday
        $nurseSchedules = [
            1  => 'a', 2  => 'b', 3  => 'c', 4  => 'd', 5  => 'e',
            6  => 'f', 7  => 'g', 8  => 'a', 9  => 'b', 10 => 'c',
            11 => 'd', 12 => 'e', 13 => 'f', 14 => 'g', 15 => 'a',
            16 => 'b', 17 => 'c', 18 => 'd', 19 => 'e', 20 => 'f',
            21 => 'g', 22 => 'a', 23 => 'b', 24 => 'c', 25 => 'd',
            26 => 'e', 27 => 'f', 28 => 'g', 29 => 'a', 30 => 'b',
            31 => 'c', 32 => 'd', 33 => 'e', 34 => 'f', 35 => 'g',
            36 => 'a', 37 => 'b', 38 => 'c', 39 => 'd', 40 => 'e',
            41 => 'f', 42 => 'g', 43 => 'a', 44 => 'b', 45 => 'c',
        ];

        foreach ($nurseSchedules as $nurseId => $scheduleKey) {
            $schedule = $schedules[$scheduleKey];
            
            for ($day = 1; $day <= 7; $day++) {
                $isWorking = in_array($day, $schedule['days']) ? 1 : 0;
                
                StaffSchedule::create([
                    'schedulable_type' => 'App\Models\Nurse',
                    'schedulable_id' => $nurseId,
                    'day_id' => $day,
                    'start_time' => $isWorking ? $schedule['start_time'] : null,
                    'end_time' => $isWorking ? $schedule['end_time'] : null,
                    'lunch_start' => $isWorking ? '12:00' : null,
                    'lunch_end' => $isWorking ? '13:00' : null,
                    'appointment_duration' => $isWorking ? 30 : null,
                    'is_working' => $isWorking,
                ]);
            }
        }
    }
}