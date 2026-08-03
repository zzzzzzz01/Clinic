<?php

namespace Database\Seeders;

use App\Models\HospitalizationPrescriptionAdministration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalizationPrescriptionAdministrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HospitalizationPrescriptionAdministration::create(['hospitalization_prescription_item_id' => 1, 'hospitalization_prescription_item_slot_id' => 1,
        'administered_by_type' => 'Doctor', 'administered_by_id' => 2, 'administered_at' => '2026-01-30 00:00:00', 'status' => 'given', 'skip_reason' => NULL]);

        HospitalizationPrescriptionAdministration::create(['hospitalization_prescription_item_id' => 1, 'hospitalization_prescription_item_slot_id' => 1,
        'administered_by_type' => 'Doctor', 'administered_by_id' => 2, 'administered_at' => '2026-01-30 08:00:00', 'status' => 'skipped', 'skip_reason' => 1]);

        HospitalizationPrescriptionAdministration::create(['hospitalization_prescription_item_id' => 1, 'hospitalization_prescription_item_slot_id' => 1,
        'administered_by_type' => 'Doctor', 'administered_by_id' => 2, 'administered_at' => '2026-01-30 16:00:00', 'status' => 'skipped', 'skip_reason' => 2]);
    }
}
