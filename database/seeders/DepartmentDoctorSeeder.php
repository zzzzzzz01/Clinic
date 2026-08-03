<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nurse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentDoctorSeeder extends Seeder
{
    public function run(): void
    {
        // ============ DEPARTMENT 1: Kardiologiya (4 doctor) ============
        Doctor::find(1)->departments()->attach(1, ['is_head' => true]);
        Doctor::find(2)->departments()->attach(1, ['is_head' => false]);
        Doctor::find(3)->departments()->attach(1, ['is_head' => false]);
        Doctor::find(4)->departments()->attach(1, ['is_head' => false]);

        // ============ DEPARTMENT 2: Nevrologiya (3 doctor) ============
        Doctor::find(5)->departments()->attach(2, ['is_head' => true]);
        Doctor::find(6)->departments()->attach(2, ['is_head' => false]);
        Doctor::find(7)->departments()->attach(2, ['is_head' => false]);

        // ============ DEPARTMENT 3: Endokrinologiya (2 doctor) ============
        Doctor::find(8)->departments()->attach(3, ['is_head' => true]);
        Doctor::find(9)->departments()->attach(3, ['is_head' => false]);

        // ============ DEPARTMENT 4: Oftalmologiya (2 doctor) ============
        Doctor::find(10)->departments()->attach(4, ['is_head' => true]);
        Doctor::find(11)->departments()->attach(4, ['is_head' => false]);

        // ============ DEPARTMENT 5: Otorinolaringologiya (2 doctor) ============
        Doctor::find(12)->departments()->attach(5, ['is_head' => true]);
        Doctor::find(13)->departments()->attach(5, ['is_head' => false]);

        // ============ DEPARTMENT 6: Pediatriya (3 doctor) ============
        Doctor::find(14)->departments()->attach(6, ['is_head' => true]);
        Doctor::find(15)->departments()->attach(6, ['is_head' => false]);
        Doctor::find(16)->departments()->attach(6, ['is_head' => false]);

        // ============ DEPARTMENT 7: Psixiatriya (2 doctor) ============
        Doctor::find(17)->departments()->attach(7, ['is_head' => true]);
        Doctor::find(18)->departments()->attach(7, ['is_head' => false]);

        // ============ DEPARTMENT 8: Akusherlik va Ginekologiya (2 doctor) ============
        Doctor::find(19)->departments()->attach(8, ['is_head' => true]);
        Doctor::find(20)->departments()->attach(8, ['is_head' => false]);

        // ============ DEPARTMENT 9: Urologiya (2 doctor) ============
        Doctor::find(21)->departments()->attach(9, ['is_head' => true]);
        Doctor::find(22)->departments()->attach(9, ['is_head' => false]);

        // ============ DEPARTMENT 10: Ortopediya (2 doctor) ============
        Doctor::find(23)->departments()->attach(10, ['is_head' => true]);
        Doctor::find(24)->departments()->attach(10, ['is_head' => false]);

        // ============ DEPARTMENT 11: Dermatologiya (2 doctor) ============
        Doctor::find(25)->departments()->attach(11, ['is_head' => true]);
        Doctor::find(26)->departments()->attach(11, ['is_head' => false]);

        // ============ DEPARTMENT 12: Gastroenterologiya (1 doctor) ============
        Doctor::find(27)->departments()->attach(12, ['is_head' => true]);

        // ============ DEPARTMENT 13: Pulmonologiya (1 doctor) ============
        Doctor::find(28)->departments()->attach(13, ['is_head' => true]);

        // ============ DEPARTMENT 14: Nefrologiya (1 doctor) ============
        Doctor::find(29)->departments()->attach(14, ['is_head' => true]);

        // ============ DEPARTMENT 15: Onkologiya (2 doctor) ============
        Doctor::find(30)->departments()->attach(15, ['is_head' => true]);
        Doctor::find(31)->departments()->attach(15, ['is_head' => false]);
    }
}