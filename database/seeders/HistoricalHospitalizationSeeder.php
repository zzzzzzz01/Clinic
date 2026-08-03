<?php

namespace Database\Seeders;

use App\Models\Hospitalization;
use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoricalHospitalizationSeeder extends Seeder
{
    public function run(): void
    {
        // 1-180 gacha bo'lgan appointmentlarni olamiz
        $appointments = Appointment::whereBetween('id', [1, 180])->get();

        $urgentTypes = ['normal', 'urgent', 'emergency'];

        $referralReasons = [
            'Uyda davolanib bo\'lmaydi, kasalxonada doctor nazoratida bo\'lishi kerak',
            'Og\'ir ahvolda, shoshilinch yotqizish kerak',
            'Kasalxonada kuzatuv va davolanish zarur',
            'Surunkali kasallik, kasalxonada davolanish kerak',
            'Operatsiya qilish kerak, kasalxonaga yotqizish zarur',
            'Bemor ahvoli og\'ir, shifoxonada davolanish talab etiladi',
            'Tez yordam orqali olib kelindi, shoshilinch yotqizish kerak',
            'Bemorning ahvoli yomonlashmoqda, kasalxonaga yotqizish lozim'
        ];

        foreach ($appointments as $appointment) {
            // Appointment orqali doctor va department ni topamiz
            $doctor = $appointment->doctor;
            $department = $doctor->departments->first();
            
            if (!$department) {
                continue;
            }

            // 180 tasi discharged, 30 tasi under_treatment
            // ID 1-150 -> discharged, 151-180 -> under_treatment
            if ($appointment->id <= 150) {
                $status = 'discharged';
            } else {
                $status = 'under_treatment';
            }

            // Random urgency
            $urgency = $urgentTypes[array_rand($urgentTypes)];

            // Appointment vaqtini olamiz
            $appointmentDate = Carbon::parse($appointment->date);
            $appointmentTime = Carbon::parse($appointment->appointmentSlot->start_time ?? '09:00:00');
            
            // Admitted_at: appointment vaqtidan 5-24 soat keyin
            $hoursToAdd = rand(5, 24);
            $admittedAt = $appointmentDate->copy()
                ->setTime($appointmentTime->hour, $appointmentTime->minute, 0)
                ->addHours($hoursToAdd);
            
            // Discharged_at: agar status discharged bo'lsa, admitted_at dan 3-10 kun keyin
            if ($status === 'discharged') {
                $dischargedAt = $admittedAt->copy()->addDays(rand(3, 10))->addHours(rand(0, 23))->addMinutes(rand(0, 59));
            } else {
                $dischargedAt = null;
            }

            Hospitalization::create([
                'appointment_id' => $appointment->id,
                'department_id' => $department->id,
                'urgency' => $urgency,
                'referral_reason' => $referralReasons[array_rand($referralReasons)],
                'status' => $status,
                'admitted_at' => $admittedAt,
                'discharged_at' => $dischargedAt,
            ]);
        }
    }
}