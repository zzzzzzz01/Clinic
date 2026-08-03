<?php

namespace Database\Seeders;

use App\Models\HospitalizationRoom;
use App\Models\Hospitalization;
use App\Models\BedRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoricalHospitalizationRoomSeeder extends Seeder
{
    public function run(): void
    {
        // 1-180 gacha bo'lgan hospitalizationlarni olamiz
        $hospitalizations = Hospitalization::whereBetween('id', [1, 180])->get();

        // Barcha bed larni olamiz
        $beds = BedRoom::all();

        foreach ($hospitalizations as $hospitalization) {
            // Random bed tanlaymiz
            $bed = $beds->random();

            // Hospitalization vaqtlarini olamiz
            $admittedAt = Carbon::parse($hospitalization->admitted_at);
            $dischargedAt = $hospitalization->discharged_at ? Carbon::parse($hospitalization->discharged_at) : null;

            // Assigned_at: admitted_at dan 0-2 soat keyin
            $assignedAt = $admittedAt->copy()->addHours(rand(0, 2))->addMinutes(rand(0, 59));

            // Unassigned_at: agar discharged bo'lsa, discharged_at dan 0-2 soat oldin
            if ($dischargedAt) {
                $unassignedAt = $dischargedAt->copy()->subHours(rand(0, 2))->subMinutes(rand(0, 59));
            } else {
                $unassignedAt = null;
            }

            HospitalizationRoom::create([
                'hospitalization_id' => $hospitalization->id,
                'bed_id' => $bed->id,
                'assigned_at' => $assignedAt,
                'unassigned_at' => $unassignedAt,
            ]);
        }
    }
}