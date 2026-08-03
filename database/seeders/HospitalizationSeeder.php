<?php

namespace Database\Seeders;

use App\Models\Hospitalization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hospitalization::create(['appointment_id' => '1', 'department_id' => '1', 'urgency' => 'emergency',
         'referral_reason' => 'Uyda davolanib bolmaydi, kasalhonada doctor nazoratida bolishi kerak', 'status' => 'waiting_for_bed']);

         Hospitalization::create(['appointment_id' => '2', 'department_id' => '2', 'urgency' => 'urgent',
         'referral_reason' => 'Uyda davolanib bolmaydi, kasalhonada doctor nazoratida bolishi kerak', 'status' => 'waiting_for_bed']);   

         Hospitalization::create(['appointment_id' => '3', 'department_id' => '5', 'urgency' => 'normal',
         'referral_reason' => 'Uyda davolanib bolmaydi, kasalhonada doctor nazoratida bolishi kerak', 'status' => 'waiting_for_bed']);   

         Hospitalization::create(['appointment_id' => '4', 'department_id' => '3', 'urgency' => 'urgent',
        'referral_reason' => 'Qo‘shimcha diagnostika va kuzatuv kerakligi uchun kasalxonada qolishi kerak', 'status' => 'waiting_for_bed']);

        Hospitalization::create(['appointment_id' => '5', 'department_id' => '4', 'urgency' => 'emergency',
        'referral_reason' => 'Zudlik bilan jarrohlik aralashuvi talab etiladi', 'status' => 'waiting_for_bed']);

        Hospitalization::create(['appointment_id' => '6', 'department_id' => '2', 'urgency' => 'normal',
            'referral_reason' => 'Qo‘shimcha kuzatuv va dorilar bilan davolash talab etiladi', 'status' => 'waiting_for_bed']);

        Hospitalization::create(['appointment_id' => '7', 'department_id' => '1', 'urgency' => 'urgent',
            'referral_reason' => 'Yo‘nalish va konsultatsiya uchun kasalxonada kuzatuv kerak', 'status' => 'waiting_for_bed']);

        Hospitalization::create(['appointment_id' => '8', 'department_id' => '3', 'urgency' => 'normal',
            'referral_reason' => 'Keng qamrovli diagnostika va davolash uchun hospitalizatsiya kerak', 'status' => 'waiting_for_bed']);
    }
}
