<?php

namespace Database\Seeders;

use App\Models\HospitalizationPrescriptionItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalizationPrescriptionItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HospitalizationPrescriptionItem::create(['hospitalization_prescription_id' => 1, 'medicine_id' => 1, 'frequency_type' => 'daily', 'frequency_value' => '3',
         'dose_amount' => 1.00, 'duration_days' => 1, 'start_at' => '2026-01-30 00:00:00', 'end_at' => '2026-01-30 00:00:00', 'status' => 'stopped', 'stopped_at' => NULL]);

        HospitalizationPrescriptionItem::create(['hospitalization_prescription_id' => 2, 'medicine_id' => 6, 'frequency_type' => 'weekly', 'frequency_value' => '2',
         'dose_amount' => 1.00, 'duration_days' => 14, 'start_at' => '2026-01-30 00:00:00', 'end_at' => '2026-02-12 00:00:00', 'status' => 'pending', 'stopped_at' => NULL]);

        HospitalizationPrescriptionItem::create(['hospitalization_prescription_id' => 3, 'medicine_id' => 7, 'frequency_type' => 'as_needed', 'frequency_value' => '1',
         'dose_amount' => 1.00, 'duration_days' => 1, 'start_at' => '2026-01-30 00:00:00', 'end_at' => '2026-02-12 00:00:00', 'status' => 'pending', 'stopped_at' => NULL]);

        HospitalizationPrescriptionItem::create(['hospitalization_prescription_id' => 4, 'medicine_id' => 7, 'frequency_type' => 'interval', 'frequency_value' => '2',
         'dose_amount' => 1.00, 'duration_days' => 10, 'start_at' => '2026-01-30 00:00:00', 'end_at' => '2026-02-12 00:00:00', 'status' => 'pending', 'stopped_at' => NULL]);

        HospitalizationPrescriptionItem::create(['hospitalization_prescription_id' => 5, 'medicine_id' => 10, 'frequency_type' => 'once', 'frequency_value' => '1',
         'dose_amount' => 1.00, 'duration_days' => 1, 'start_at' => '2026-01-30 00:00:00', 'end_at' => '2026-02-12 00:00:00', 'status' => 'pending', 'stopped_at' => NULL]);
    }
}
