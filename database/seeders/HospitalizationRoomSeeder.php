<?php

namespace Database\Seeders;

use App\Models\HospitalizationRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalizationRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HospitalizationRoom::create(['hospitalization_id' => '1', 'bed_id' => '1', 'assigned_at' => '2026-01-01 17:16:00', 'unassigned_at' => '2026-01-02 17:16:00']);
        HospitalizationRoom::create(['hospitalization_id' => '1', 'bed_id' => '2', 'assigned_at' => '2026-01-02 17:16:00', 'unassigned_at' => null ]);
    }
}
