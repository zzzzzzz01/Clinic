<?php

namespace Database\Seeders;

use App\Models\HospitalizationStaff;
use App\Models\Hospitalization;
use App\Models\Doctor;
use App\Models\Nurse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoricalHospitalizationStaffSeeder extends Seeder
{
    public function run(): void
    {
        // 1-180 gacha bo'lgan hospitalizationlarni olamiz
        $hospitalizations = Hospitalization::whereBetween('id', [1, 180])->get();

        // Barcha nurse larni olamiz
        $nurses = Nurse::all();

        $doctorRoles = [
            'Asosiy shifokor',
            'Davolovchi shifokor'
        ];

        $nurseRolesDay = [
            'Kunduzgi hamshira',
            'Katta hamshira'
        ];

        $nurseRolesNight = [
            'Tungi hamshira',
            'Navbatchi hamshira'
        ];

        foreach ($hospitalizations as $hospitalization) {
            // Doctor: hospitalization->appointment->doctor dan olamiz
            $doctor = $hospitalization->appointment->doctor;
            
            if (!$doctor) {
                continue;
            }

            // Random nurse (kunduzgi)
            $dayNurse = $nurses->random();
            
            // Random nurse (tungi) - kunduzgi nursedan boshqa
            $nightNurse = $nurses->where('id', '!=', $dayNurse->id)->random();

            // Hospitalization vaqtlarini olamiz
            $admittedAt = Carbon::parse($hospitalization->admitted_at);
            $dischargedAt = $hospitalization->discharged_at ? Carbon::parse($hospitalization->discharged_at) : null;

            // DOCTOR (appointment->doctor)
            $doctorAssignedAt = $admittedAt->copy()->addHours(rand(0, 2))->addMinutes(rand(0, 59));
            
            if ($dischargedAt) {
                $doctorUnassignedAt = $dischargedAt->copy()->subDays(rand(0, 1))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            } else {
                $doctorUnassignedAt = null;
            }

            HospitalizationStaff::create([
                'hospitalization_id' => $hospitalization->id,
                'staff_id' => $doctor->id,
                'staff_type' => 'App\Models\Doctor',
                'role' => $doctorRoles[array_rand($doctorRoles)],
                'assigned_at' => $doctorAssignedAt,
                'unassigned_at' => $doctorUnassignedAt,
            ]);

            // KUNDUZGI NURSE
            $dayNurseAssignedAt = $admittedAt->copy()->addHours(rand(0, 2))->addMinutes(rand(0, 59));
            
            if ($dischargedAt) {
                $dayNurseUnassignedAt = $dischargedAt->copy()->subDays(rand(0, 1))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            } else {
                $dayNurseUnassignedAt = null;
            }

            HospitalizationStaff::create([
                'hospitalization_id' => $hospitalization->id,
                'staff_id' => $dayNurse->id,
                'staff_type' => 'App\Models\Nurse',
                'role' => $nurseRolesDay[array_rand($nurseRolesDay)],
                'assigned_at' => $dayNurseAssignedAt,
                'unassigned_at' => $dayNurseUnassignedAt,
            ]);

            // TUNGI NURSE
            $nightNurseAssignedAt = $admittedAt->copy()->addHours(rand(0, 3))->addMinutes(rand(0, 59));
            
            if ($dischargedAt) {
                $nightNurseUnassignedAt = $dischargedAt->copy()->subDays(rand(0, 1))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            } else {
                $nightNurseUnassignedAt = null;
            }

            HospitalizationStaff::create([
                'hospitalization_id' => $hospitalization->id,
                'staff_id' => $nightNurse->id,
                'staff_type' => 'App\Models\Nurse',
                'role' => $nurseRolesNight[array_rand($nurseRolesNight)],
                'assigned_at' => $nightNurseAssignedAt,
                'unassigned_at' => $nightNurseUnassignedAt,
            ]);
        }
    }
}