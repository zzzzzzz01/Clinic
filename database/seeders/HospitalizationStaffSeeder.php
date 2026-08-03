<?php

namespace Database\Seeders;

use App\Models\HospitalizationStaff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalizationStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HospitalizationStaff::create(['hospitalization_id' => '1', 'staff_id' => '10', 'staff_type' => 'App\Models\Doctor',
         'role' => 'Asosiy shifokor ', 'assigned_at' => '2026-01-02 08:46:53', 'unassigned_at' => null]);
         
        HospitalizationStaff::create(['hospitalization_id' => '1', 'staff_id' => '5', 'staff_type' => 'App\Models\Doctor',
         'role' => 'Konsultant', 'assigned_at' => '2026-01-02 08:46:53', 'unassigned_at' => null]);

        HospitalizationStaff::create(['hospitalization_id' => '1', 'staff_id' => '4', 'staff_type' => 'App\Models\Nurse',
         'role' => 'Kunduzgi smena', 'assigned_at' => '2026-01-02 08:46:53', 'unassigned_at' => null]);

        HospitalizationStaff::create(['hospitalization_id' => '1', 'staff_id' => '8', 'staff_type' => 'App\Models\Nurse',
         'role' => 'Kechki smena', 'assigned_at' => '2026-01-02 08:46:53', 'unassigned_at' => null]);

    }
}
