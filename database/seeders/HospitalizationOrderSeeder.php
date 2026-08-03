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

class HospitalizationOrderSeeder extends Seeder
{
    public function run(): void
    {
        // ========== STATUSI UNDER_TREATMENT BO'LGAN HOSPITALIZATIONS ==========
        $hospitalizations = Hospitalization::where('status', 'under_treatment')->get();

        if ($hospitalizations->isEmpty()) {
            $this->command->info('Hech qanday under_treatment hospitalization topilmadi!');
            return;
        }

        $tests = Test::all();
        $panels = Panel::all();

        if ($tests->isEmpty() && $panels->isEmpty()) {
            $this->command->info('Hech qanday test yoki panel topilmadi!');
            return;
        }

        $orderTypes = ['normal', 'urgent', 'emergency'];
        $statuses = ['pending', 'completed'];

        // ========== HOZIRGI OY ==========
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

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

            // ========== 2. ORDER VAQTI (ordered_at) - HOZIRGI OY ORALIG'IDA ==========
            // Agar admitted_at hozirgi oydan oldin bo'lsa, oy boshidan boshlab olamiz
            $startDate = $startOfMonth->copy();
            $endDate = $endOfMonth->copy();
            
            // Agar admitted_at hozirgi oydan keyin bo'lsa (bo'lmaydi lekin tekshirish)
            if ($admittedAt > $startOfMonth) {
                $startDate = $admittedAt->copy();
            }

            // startDate va endDate oralig'ida random sana
            $daysDiff = $startDate->diffInDays($endDate);
            $randomDays = $daysDiff > 0 ? rand(0, $daysDiff) : 0;
            $orderedAt = $startDate->copy()->addDays($randomDays)->addHours(rand(8, 18))->addMinutes(rand(0, 59));
            
            // Agar orderedAt hozirgi vaqtdan katta bo'lsa, hozirgi vaqtga tuzatish
            if ($orderedAt > $now) {
                $orderedAt = $now->copy()->subHours(rand(1, 5));
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
                'status' => 'pending',
                'order_type' => $orderType,
                'total_price' => 0,
                'note' => rand(0, 1) ? 'Standart tekshiruv' : null,
            ]);

            // ========== 6. ORDER ITEMLAR ==========
            $panelCount = rand(1, 2);
            $testCount = rand(1, 2);

            // Panel itemlar
            if ($panels->count() > 0) {
                $randomPanels = $panels->random(min($panelCount, $panels->count()));
                foreach ($randomPanels as $panel) {
                    $price = $panel->price ?? rand(50000, 150000);
                    $totalPrice += $price;

                    $status = $statuses[array_rand($statuses)];

                    $orderItem = HospitalizationOrderItem::create([
                        'hospitalization_order_id' => $order->id,
                        'item_type' => 'panel',
                        'item_id' => $panel->id,
                        'quantity' => 1,
                        'price' => $price,
                        'status' => $status,
                        'order_type' => $orderType,
                    ]);

                    if ($status === 'completed' && $panel->tests) {
                        foreach ($panel->tests as $test) {
                            $this->createTestResult($test, $orderItem, $order, $now, 'completed');
                        }
                    } else {
                        if ($panel->tests) {
                            foreach ($panel->tests as $test) {
                                $this->createTestResult($test, $orderItem, $order, $now, 'pending');
                            }
                        }
                    }
                }
            }

            // Test itemlar
            if ($tests->count() > 0) {
                $randomTests = $tests->random(min($testCount, $tests->count()));
                foreach ($randomTests as $test) {
                    $price = $test->price ?? rand(20000, 80000);
                    $totalPrice += $price;

                    $status = $statuses[array_rand($statuses)];

                    $orderItem = HospitalizationOrderItem::create([
                        'hospitalization_order_id' => $order->id,
                        'item_type' => 'test',
                        'item_id' => $test->id,
                        'quantity' => 1,
                        'price' => $price,
                        'status' => $status,
                        'order_type' => $orderType,
                    ]);

                    $this->createTestResult($test, $orderItem, $order, $now, $status);
                }
            }

            // ========== 7. ORDER STATUS ==========
            $allCompleted = $order->items()->where('status', '!=', 'completed')->doesntExist();
            if ($allCompleted && $order->items()->count() > 0) {
                $order->update(['status' => 'completed']);
            }

            // ========== 8. ORDER TOTAL PRICE UPDATE ==========
            $order->update(['total_price' => $totalPrice]);
        }

        $this->command->info('✅ All under_treatment hospitalizations orders processed successfully!');
    }

    private function createTestResult($test, $orderItem, $order, $now, $status)
    {
        $normalMin = $test->normal_min ?? 0;
        $normalMax = $test->normal_max ?? 100;
        $unit = $test->unit ?? '';

        if ($status === 'completed') {
            $isNormal = rand(1, 100) <= 90;

            if ($isNormal) {
                if ($normalMin == 0 && $normalMax == 0) {
                    $value = rand(1, 100) / 10;
                } else {
                    $value = rand($normalMin * 10, $normalMax * 10) / 10;
                }
            } else {
                if (rand(0, 1) == 0) {
                    $value = rand(1, max(1, $normalMin * 10)) / 10;
                    if ($value < 0) $value = 0;
                } else {
                    $value = rand($normalMax * 10, max($normalMax * 20, $normalMax * 10 + 10)) / 10;
                }
            }

            $value = round($value, 1);

            $resultedAt = $order->ordered_at->copy()->addHours(rand(2, 8))->addMinutes(rand(0, 59));
            
            if ($resultedAt > $now) {
                $resultedAt = $now->copy()->subHours(rand(1, 5));
            }

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
        } else {
            TestResult::create([
                'hospitalization_order_item_id' => $orderItem->id,
                'test_id' => $test->id,
                'value' => null,
                'unit' => $unit,
                'normal_min' => $normalMin,
                'normal_max' => $normalMax,
                'status' => 'pending',
                'resulted_at' => null,
            ]);
        }
    }
}