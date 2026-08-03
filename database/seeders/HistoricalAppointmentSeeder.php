<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\AppointmentSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoricalAppointmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1-180 gacha bo'lgan slotlarni olamiz
        $slots = AppointmentSlot::whereBetween('id', [1, 180])->get();

        $treatmentTypes = ['outpatient', 'inpatient'];
        
        $reasons = [
            'Bosh og‘rig‘i',
            'Yurak sanchishi',
            'Ko‘ngil aynishi',
            'Qorin og‘rig‘i',
            'Tish og‘rig‘i',
            'Yo‘tal',
            'Isitma',
            'Allergiya',
            'Bosh aylanishi',
            'Uyqusizlik',
            'Bo‘g‘im og‘rig‘i',
            'Terida toshma',
            'Qon bosimi ko‘tarilishi',
            'Qandli diabet tekshiruvi',
            'Homiladorlik tekshiruvi'
        ];

        $notes = [
            '3 kundan beri davom etmoqda',
            'Dori-darmonlar yordam bermayapti',
            'Shifokor ko‘rigidan o‘tish kerak',
            'Ertalab kuchayadi',
            'Kechasi uyquga xalaqit beradi',
            'Oldin ham shunday bo‘lgan edi',
            'Tez-tez takrorlanmoqda',
            'Og‘riq qoldiruvchi vositalar kerak',
            'Tekshiruv natijalari kerak',
            'Davolanishni davom ettirish kerak'
        ];

        foreach ($slots as $slot) {
            // Slotdagi patient_id ni olamiz
            $patientId = $slot->patient_id;
            
            // Doctor_id ni slot orqali topamiz
            $doctorId = $slot->staffSchedule->schedulable_id ?? null;
            
            if (!$doctorId || !$patientId) {
                continue;
            }

            // Hammasi completed
            $status = 'completed';
            
            // Treatment type: inpatient
            $treatmentType = 'inpatient';
            
            // Duration ni staff_schedule dan olamiz
            $duration = $slot->staffSchedule->appointment_duration ?? 30;

            Appointment::create([
                'patient_id' => $patientId,
                'doctor_id' => $doctorId,
                'appointment_slot_id' => $slot->id,
                'date' => $slot->date,
                'reason' => $reasons[array_rand($reasons)],
                'notes' => $notes[array_rand($notes)],
                'status' => $status,
                'treatment_type' => $treatmentType,
                'duration' => $duration,
            ]);
        }
    }
}