<?php

namespace Database\Seeders;

use App\Models\Day; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $days = [
            [
                'name_uz' => 'Dushanba',
                'name_ru' => 'Понедельник',
                'name_en' => 'Monday',
            ],
            [
                'name_uz' => 'Seshanba',
                'name_ru' => 'Вторник',
                'name_en' => 'Tuesday',
            ],
            [
                'name_uz' => 'Chorshanba',
                'name_ru' => 'Среда',
                'name_en' => 'Wednesday',
            ],
            [
                'name_uz' => 'Payshanba',
                'name_ru' => 'Четверг',
                'name_en' => 'Thursday',
            ],
            [
                'name_uz' => 'Juma',
                'name_ru' => 'Пятница',
                'name_en' => 'Friday',
            ],
            [
                'name_uz' => 'Shanba',
                'name_ru' => 'Суббота',
                'name_en' => 'Saturday',
            ],
            [
                'name_uz' => 'Yakshanba',
                'name_ru' => 'Воскресенье',
                'name_en' => 'Sunday',
            ],
        ];
    
        foreach ($days as $day) {
            Day::create($day);
        }
    }
}
