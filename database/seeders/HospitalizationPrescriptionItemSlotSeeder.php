<?php

namespace Database\Seeders;

use App\Models\HospitalizationPrescriptionItemSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HospitalizationPrescriptionItemSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // hospitalization_prescription_item_id = 1
        HospitalizationPrescriptionItemSlot::create(['hospitalization_prescription_item_id' => 1, 'scheduled_at' => '2026-01-30 00:00:00',
        'status' => 'given', 'skip_reason' => NULL, 'administered_by_type' => NULL, 'administered_by_id' => NULL, 'administered_at' => NULL, 'slot_order' => 1,]);

        HospitalizationPrescriptionItemSlot::create(['hospitalization_prescription_item_id' => 1, 'scheduled_at' => '2026-01-30 08:00:00',
        'status' => 'skipped', 'skip_reason' =>  'Bemor qarshilik qildi', 'administered_by_type' => NULL, 'administered_by_id' => NULL, 'administered_at' => NULL, 'slot_order' => 2,]);

        HospitalizationPrescriptionItemSlot::create(['hospitalization_prescription_item_id' => 1, 'scheduled_at' => '2026-01-30 16:00:00',
        'status' => 'stopped', 'skip_reason' => 'Dori foyda bemadi', 'administered_by_type' => NULL, 'administered_by_id' => NULL, 'administered_at' => NULL, 'slot_order' => 3,]);

        // hospitalization_prescription_item_id = 2
        HospitalizationPrescriptionItemSlot::create(['hospitalization_prescription_item_id' => 2, 'scheduled_at' => '2026-01-30 00:00:00',
        'status' => 'pending', 'skip_reason' => NULL, 'administered_by_type' => NULL, 'administered_by_id' => NULL, 'administered_at' => NULL, 'slot_order' => 1,]);

        HospitalizationPrescriptionItemSlot::create(['hospitalization_prescription_item_id' => 2, 'scheduled_at' => '2026-01-30 00:00:00',
        'status' => 'pending', 'skip_reason' =>  NULL, 'administered_by_type' => NULL, 'administered_by_id' => NULL, 'administered_at' => NULL, 'slot_order' => 2,]);

        HospitalizationPrescriptionItemSlot::create(['hospitalization_prescription_item_id' => 2, 'scheduled_at' => '2026-01-30 00:00:00',
        'status' => 'pending', 'skip_reason' => NULL, 'administered_by_type' => NULL, 'administered_by_id' => NULL, 'administered_at' => NULL, 'slot_order' => 3,]);

        HospitalizationPrescriptionItemSlot::create(['hospitalization_prescription_item_id' => 2, 'scheduled_at' => '2026-01-30 00:00:00',
        'status' => 'pending', 'skip_reason' => NULL, 'administered_by_type' => NULL, 'administered_by_id' => NULL, 'administered_at' => NULL, 'slot_order' => 4,]);
    }
}
