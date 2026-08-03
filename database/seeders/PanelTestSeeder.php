<?php

namespace Database\Seeders;

use App\Models\PanelTest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PanelTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ======================
        // PANEL 1 (1–12)
        // ======================
        for ($i = 1; $i <= 12; $i++) {
            PanelTest::create([
                'panel_id' => 1,
                'test_id'  => $i,
            ]);
        }

        // ======================
        // PANEL 2 (13–23)
        // ======================
        for ($i = 13; $i <= 23; $i++) {
            PanelTest::create([
                'panel_id' => 2,
                'test_id'  => $i,
            ]);
        }

        // ======================
        // PANEL 3 (24–34)
        // ======================
        for ($i = 24; $i <= 30; $i++) {
            PanelTest::create([
                'panel_id' => 3,
                'test_id'  => $i,
            ]);
        }

        for ($i = 31; $i <= 34; $i++) {
            PanelTest::create([
                'panel_id' => 4,
                'test_id'  => $i,
            ]);
        }
    }
}
