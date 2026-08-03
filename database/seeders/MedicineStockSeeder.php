<?php

namespace Database\Seeders;

use App\Models\MedicineStock;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MedicineStockSeeder extends Seeder
{
    public function run(): void
    {
        // Barcha dorilarni olamiz
        $medicines = Medicine::all();
        
        // 1-oy (30 kun) uchun
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        // Har 10 kunda bir marta (1, 11, 21)
        $receiveDates = [
            $startDate->copy()->addDays(0),   // 1-kun
            $startDate->copy()->addDays(10),  // 11-kun
            $startDate->copy()->addDays(20),  // 21-kun
        ];

        // User ID lar: 80% 5, 20% 1
        $userIds = [];
        for ($i = 0; $i < 100; $i++) {
            $userIds[] = (rand(1, 100) <= 80) ? 5 : 1;
        }

        foreach ($medicines as $medicine) {
            foreach ($receiveDates as $date) {
                // Har bir dori uchun har 10 kunda 1-5 quti
                $quantityBoxes = rand(1, 5);
                
                // units_per_box dan pieces_per_box ni olamiz
                $piecesPerBox = $medicine->units_per_box;
                
                // Jami dona = quti soni * bir qutidagi dona soni
                $totalPieces = $quantityBoxes * $piecesPerBox;

                // Random user_id (80% 5, 20% 1)
                $userId = $userIds[array_rand($userIds)];

                MedicineStock::create([
                    'medicine_id' => $medicine->id,
                    'quantity_boxes' => $quantityBoxes,
                    'pieces_per_box' => $piecesPerBox,
                    'total_pieces' => $totalPieces,
                    'receive_date' => $date->toDateString(),
                    'status' => 'completed',
                    'user_id' => $userId,
                    'notes' => $this->getRandomNote(),
                ]);
            }
        }
    }

    private function getRandomNote()
    {
        $notes = [
            'Dori omborga qabul qilindi',
            'Yetkazib beruvchidan kelib tushdi',
            'Navbatdagi partiya',
            'Sifat nazoratidan o\'tdi',
            'Yaroqlilik muddati tekshirildi',
            'Qabul qilindi',
            'Omborxona tomonidan qabul qilindi',
            'Farmatsevt tomonidan tekshirildi',
            'Dorixona uchun kelib tushdi',
            'Buyurtma bo\'yicha qabul qilindi',
            null,
        ];

        return $notes[array_rand($notes)];
    }
}