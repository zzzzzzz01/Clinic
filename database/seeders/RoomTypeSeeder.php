<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomTypes = [
            [
                'name_uz' => 'VIP palata',
                'name_ru' => 'VIP палата',
                'name_en' => 'VIP Room',
            ],
            [
                'name_uz' => 'Shaxsiy palata',
                'name_ru' => 'Индивидуальная палата',
                'name_en' => 'Private Room',
            ],
            [
                'name_uz' => 'Ikki kishilik palata',
                'name_ru' => 'Двухместная палата',
                'name_en' => 'Semi-Private Room',
            ],
            [
                'name_uz' => 'Umumiy palata',
                'name_ru' => 'Общая палата',
                'name_en' => 'General Ward',
            ],
            [
                'name_uz' => 'Izolyatsiya palatasi',
                'name_ru' => 'Изолятор',
                'name_en' => 'Isolation Room',
            ],
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::create($roomType);
        }
    }
}