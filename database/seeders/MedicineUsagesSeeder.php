<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\MedicineUsage;
use App\Models\MedicineUsageItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MedicineUsagesSeeder extends Seeder
{
    public function run(): void
    {
        // Barcha dorilarni olamiz
        $medicines = Medicine::all();
        
        // Payment method lar
        $paymentMethods = ['cash', 'card', 'transfer', 'insurance'];
        
        // 30 kunlik davr
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Har bir kun uchun 3-8 ta usage yaratamiz
        for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
            // Kuniga 3-8 ta usage
            $usageCount = rand(3, 8);
            
            for ($i = 0; $i < $usageCount; $i++) {
                // user_id faqat 2
                $userId = 2;
                
                // Random payment method
                $paymentMethod = $paymentMethods[array_rand($paymentMethods)];
                
                // Random vaqt (8:00 dan 18:00 gacha)
                $hour = rand(8, 18);
                $minute = rand(0, 59);
                
                // Usage yaratamiz
                $usage = MedicineUsage::create([
                    'total_price' => 0,
                    'payment_method' => $paymentMethod,
                    'given_at' => $date->copy()->setTime($hour, $minute, 0),
                    'user_id' => $userId,
                ]);

                // Har bir usage uchun 1-4 ta item
                $itemCount = rand(1, 4);
                $totalPrice = 0;
                
                // Tasodifiy dorilarni tanlaymiz
                $randomMedicines = $medicines->random(min($itemCount, $medicines->count()));
                
                foreach ($randomMedicines as $medicine) {
                    // Random: box yoki piece
                    $unit = rand(0, 1) == 0 ? 'box' : 'piece';
                    
                    if ($unit == 'box') {
                        // Box bo'lsa, 1-3 quti
                        $quantity = rand(1, 3);
                        // Box narxi = medicine->price (to'liq quti narxi)
                        $price = $medicine->price;
                    } else {
                        // Piece bo'lsa, 1-5 dona (qutidagi donadan kam)
                        $quantity = rand(1, 5);
                        // Bir dona narxi = quti narxi / qutidagi dona soni
                        $price = $medicine->price / $medicine->units_per_box;
                        $price = round($price, 2);
                    }
                    
                    $itemTotal = $quantity * $price;
                    $totalPrice += $itemTotal;
                    
                    MedicineUsageItem::create([
                        'medicine_usage_id' => $usage->id,
                        'medicine_id' => $medicine->id,
                        'unit' => $unit,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total_price' => $itemTotal,
                    ]);
                }
                
                // Total price ni yangilaymiz
                $usage->update(['total_price' => $totalPrice]);
            }
        }
    }
}