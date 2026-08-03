<?php

namespace Database\Seeders;

use App\Models\Hospitalization;
use App\Models\HospitalizationOrder;
use App\Models\HospitalizationOrderItem;
use App\Models\HospitalizationStaff;
use App\Models\Test;
use App\Models\Panel;
use App\Models\TestResult;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HistoricalHospitalizationOrderSeeder extends Seeder
{
    public function run(): void
    {
        // ========== STATUSI DISCHARGED BO'LGAN HOSPITALIZATIONS ==========
        $hospitalizations = Hospitalization::where('status', 'discharged')->get();

        if ($hospitalizations->isEmpty()) {
            $this->command->info('Hech qanday discharged hospitalization topilmadi!');
            return;
        }

        $tests = Test::all();
        $panels = Panel::all();

        if ($tests->isEmpty() && $panels->isEmpty()) {
            $this->command->info('Hech qanday test yoki panel topilmadi!');
            return;
        }

        $orderTypes = ['normal', 'urgent', 'emergency'];

        foreach ($hospitalizations as $hospitalization) {
            // ========== 1. DOCTOR STAFF ==========
            $doctorStaff = HospitalizationStaff::where('hospitalization_id', $hospitalization->id)
                ->where('staff_type', 'App\Models\Doctor')
                ->first();

            if (!$doctorStaff) {
                continue;
            }

            $doctor = Doctor::find($doctorStaff->staff_id);
            if (!$doctor) {
                continue;
            }

            $patientId = $hospitalization->appointment->patient_id;
            $admittedAt = Carbon::parse($hospitalization->admitted_at);
            $dischargedAt = Carbon::parse($hospitalization->discharged_at);

            // ========== 2. ORDER VAQTI (ordered_at) ==========
            $orderedAt = $admittedAt->copy()->addDays(rand(0, 3))->addHours(rand(8, 18))->addMinutes(rand(0, 59));
            
            if ($orderedAt > $dischargedAt) {
                $orderedAt = $dischargedAt->copy()->subDays(rand(1, 3))->setTime(10, 0, 0);
            }

            // ========== 3. ORDER TYPE ==========
            $orderType = $orderTypes[array_rand($orderTypes)];

            // ========== 4. TOTAL PRICE ==========
            $totalPrice = 0;

            // ========== 5. ORDER YARATISH ==========
            $order = HospitalizationOrder::create([
                'hospitalization_id' => $hospitalization->id,
                'ordered_by' => $doctor->id,
                'ordered_to' => $patientId,
                'ordered_at' => $orderedAt,
                'status' => 'completed',
                'order_type' => $orderType,
                'total_price' => 0,
                'note' => rand(0, 1) ? 'Standart tekshiruv' : null,
            ]);

            // ========== 6. ORDER ITEMLAR ==========
            $itemCount = rand(3, 4);
            $panelCount = 2;
            $testCount = $itemCount - $panelCount;

            // Panel itemlar
            $randomPanels = $panels->random(min($panelCount, $panels->count()));
            foreach ($randomPanels as $panel) {
                $price = $panel->price ?? rand(50000, 150000);
                $totalPrice += $price;

                $orderItem = HospitalizationOrderItem::create([
                    'hospitalization_order_id' => $order->id,
                    'item_type' => 'panel',
                    'item_id' => $panel->id,
                    'quantity' => 1,
                    'price' => $price,
                    'status' => 'completed',
                    'order_type' => $orderType,
                ]);

                // Panel ichidagi testlar uchun test_results yaratamiz
                if ($panel->tests) {
                    foreach ($panel->tests as $test) {
                        $this->createTestResult($test, $orderItem, $order, $dischargedAt);
                    }
                }
            }

            // Test itemlar
            $randomTests = $tests->random(min($testCount, $tests->count()));
            foreach ($randomTests as $test) {
                $price = $test->price ?? rand(20000, 80000);
                $totalPrice += $price;

                $orderItem = HospitalizationOrderItem::create([
                    'hospitalization_order_id' => $order->id,
                    'item_type' => 'test',
                    'item_id' => $test->id,
                    'quantity' => 1,
                    'price' => $price,
                    'status' => 'completed',
                    'order_type' => $orderType,
                ]);

                // Test uchun test_result yaratamiz
                $this->createTestResult($test, $orderItem, $order, $dischargedAt);
            }

            // ========== 7. ORDER TOTAL PRICE UPDATE ==========
            $order->update(['total_price' => $totalPrice]);
        }

        $this->command->info('✅ All discharged hospitalizations orders processed successfully!');
    }

    private function createTestResult($test, $orderItem, $order, $dischargedAt)
    {
        // ========== TEST NATIJASI ==========
        $normalMin = $test->normal_min ?? 0;
        $normalMax = $test->normal_max ?? 100;
        $unit = $test->unit ?? '';

        // 90% normal, 10% abnormal
        $isNormal = rand(1, 100) <= 90;

        if ($isNormal) {
            // Normal qiymat: normal_min va normal_max orasida
            $value = rand($normalMin * 10, $normalMax * 10) / 10;
        } else {
            // Abnormal qiymat: normal_min dan kam yoki normal_max dan ko'p
            if (rand(0, 1) == 0) {
                // Past
                $value = rand(1, $normalMin * 10) / 10;
                if ($value < 0) $value = 0;
            } else {
                // Yuqori
                $value = rand($normalMax * 10, $normalMax * 20) / 10;
            }
        }

        // Qiymatni formatlash
        $value = round($value, 1);

        // Resulted at - ordered_at va discharged_at oralig'ida
        $resultedAt = $order->ordered_at->copy()->addHours(rand(2, 8))->addMinutes(rand(0, 59));
        
        if ($resultedAt > $dischargedAt) {
            $resultedAt = $dischargedAt->copy()->subHours(rand(1, 5));
        }

        // TestResult yaratish
        TestResult::create([
            'hospitalization_order_item_id' => $orderItem->id,
            'test_id' => $test->id,
            'value' => $value,
            'unit' => $unit,
            'normal_min' => $normalMin,
            'normal_max' => $normalMax,
            'status' => 'ready',
            'resulted_at' => $resultedAt,
        ]);
    }
}