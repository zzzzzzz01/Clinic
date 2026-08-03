<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\AppointmentSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1 oy uchun
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Faqat booked bo'lgan slotlarni olamiz
        $bookedSlots = AppointmentSlot::where('status', 'booked')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $statuses = ['booked', 'completed', 'cancelled'];
        
        // Reason va notes lar
        $complaints = [
            [
                'reason' => 'Bosh og‘rig‘i',
                'notes' => '3 kundan beri boshim qattiq og‘riyapti, dori ichsam ham o‘tmayapti'
            ],
            [
                'reason' => 'Yurak sanchishi',
                'notes' => 'Ko‘krak qafasida sanchib turadigan og‘riq, nafas olganda kuchayadi'
            ],
            [
                'reason' => 'Ko‘ngil aynishi',
                'notes' => '5 kun dan beri ko‘ngil aynishi ketmayapti, ovqatdan keyin qusish ham bo‘lyapti'
            ],
            [
                'reason' => 'Qorin og‘rig‘i',
                'notes' => 'Qorinning pastki qismida og‘riq, 2 haftadan beri davom etmoqda'
            ],
            [
                'reason' => 'Tish og‘rig‘i',
                'notes' => 'O‘ng tomondagi tish qattiq og‘riyapti, kechalari uyquga xalaqit beradi'
            ],
            [
                'reason' => 'Yo‘tal',
                'notes' => '1 haftadan beri quruq yo‘tal, kechalari kuchayadi, balg‘am chiqmayapti'
            ],
            [
                'reason' => 'Isitma',
                'notes' => '3 kundan beri tana harorati 38-39 daraja, dori ichganimdan keyin pasayib keyin yana ko‘tariladi'
            ],
            [
                'reason' => 'Allergiya',
                'notes' => 'Tanasida toshma paydo bo‘ldi, qichishish juda kuchli, nima qilishni bilmayman'
            ],
            [
                'reason' => 'Bosh aylanishi',
                'notes' => 'O‘rnimdan tursam boshim aylanib ketadi, ko‘zim oldida qorong‘ilashadi'
            ],
            [
                'reason' => 'Uyqusizlik',
                'notes' => '1 oydan beri yaxshi uxlay olmayapman, kechasi 2-3 soatdan ko‘p uxlamayman'
            ],
            [
                'reason' => 'Bo‘g‘im og‘rig‘i',
                'notes' => 'Tizza bo‘g‘imlari og‘riyapti, yurishga qiynalayapman, ertalab qotib qoladi'
            ],
            [
                'reason' => 'Terida toshma',
                'notes' => 'Yuz va qo‘l terisida qizil toshmalar paydo bo‘ldi, qichiydi va yoyilmoqda'
            ],
            [
                'reason' => 'Qon bosimi ko‘tarilishi',
                'notes' => 'Qon bosimim 160/100 ga chiqib qoldi, boshim qattiq og‘riyapti, ko‘nglim ayniyapti'
            ],
            [
                'reason' => 'Qandli diabet tekshiruvi',
                'notes' => 'Qand miqdorim 15 mmol/l dan oshib ketdi, tez-tez hojatxonaga chiqaman, ko‘p suv ichaman'
            ],
            [
                'reason' => 'Homiladorlik tekshiruvi',
                'notes' => '3 oylik homiladorman, qon bosimim ko‘tarilib ketdi, shifokor ko‘rigidan o‘tishim kerak'
            ],
            [
                'reason' => 'Oshqozon og‘rig‘i',
                'notes' => 'Ovqatdan keyin oshqozonim qattiq og‘riyapti, qayta-qayta og‘riq qaytmoqda'
            ],
            [
                'reason' => 'Jigar tekshiruvi',
                'notes' => 'Jigarim og‘riyapti, terim va ko‘zim sarg‘ayib ketgan, 2 haftadan beri shunaqa'
            ],
            [
                'reason' => 'Buyrak og‘rig‘i',
                'notes' => 'Belimning o‘ng tomonida qattiq og‘riq, siydik qilishim qiyin va qon aralash chiqyapti'
            ],
            [
                'reason' => 'Qalqonsimon bez tekshiruvi',
                'notes' => 'Bo‘ynimda shish paydo bo‘ldi, yurak urishim tezlashdi, asabiylashib ketdim'
            ],
            [
                'reason' => 'Ko‘z og‘rig‘i',
                'notes' => 'Ko‘zim qizarib, yoshlanib og‘riyapti, yorug‘likka qarashim qiyin'
            ]
        ];

        foreach ($bookedSlots as $slot) {
            // Slotga tegishli doctor_id ni topamiz
            $doctorId = $slot->staffSchedule->schedulable_id ?? null;
            
            if (!$doctorId) {
                continue;
            }

            // StaffSchedule dan appointment_duration ni olamiz
            $duration = $slot->staffSchedule->appointment_duration ?? 30;

            // Random complaint tanlaymiz
            $complaint = $complaints[array_rand($complaints)];
            
            // Random status tanlaymiz
            $status = $statuses[array_rand($statuses)];
            
            // Agar status 'completed' bo'lsa 'inpatient', aks holda 'outpatient'
            $treatmentType = ($status === 'completed') ? 'inpatient' : 'outpatient';

            Appointment::create([
                'patient_id' => $slot->patient_id,
                'doctor_id' => $doctorId,
                'appointment_slot_id' => $slot->id,
                'date' => $slot->date,
                'reason' => $complaint['reason'],
                'notes' => $complaint['notes'],
                'status' => $status,
                'treatment_type' => $treatmentType,
                'duration' => $duration,
            ]);
        }
    }
}