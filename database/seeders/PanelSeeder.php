<?php

namespace Database\Seeders;

use App\Models\Panel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PanelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $panels = [
            [
                'name_uz' => 'Umumiy Qon Tekshiruvi',
                'name_ru' => 'Общий анализ крови',
                'name_en' => 'Complete Blood Count',
                'code' => 'PANEL01',
                'price' => 1500.00,
                'time' => 8,
                'description_uz' => 'Qonning umumiy tarkibini tekshirish uchun panel.',
                'description_ru' => 'Панель для проверки общего состава крови.',
                'description_en' => 'Panel for checking the general composition of blood.',
                'department_id' => 1,
                'status' => 1,
            ],
            [
                'name_uz' => 'Biokimyo Panel',
                'name_ru' => 'Биохимическая панель',
                'name_en' => 'Biochemistry Panel',
                'code' => 'PANEL02',
                'price' => 2500.00,
                'time' => 12,
                'description_uz' => 'Qon biokimyoviy ko‘rsatkichlarini aniqlash paneli.',
                'description_ru' => 'Панель для определения биохимических показателей крови.',
                'description_en' => 'Panel for determining blood biochemical parameters.',
                'department_id' => 2,
                'status' => 0,
            ],
            [
                'name_uz' => 'Gormonal Panel',
                'name_ru' => 'Гормональная панель',
                'name_en' => 'Hormonal Panel',
                'code' => 'PANEL03',
                'price' => 3000.00,
                'time' => 24,
                'description_uz' => 'Turli gormon darajalarini tekshirish paneli.',
                'description_ru' => 'Панель для проверки уровня различных гормонов.',
                'description_en' => 'Panel for checking various hormone levels.',
                'department_id' => 1,
                'status' => 1,
            ],
            [
                'name_uz' => 'Infeksiya Paneli',
                'name_ru' => 'Инфекционная панель',
                'name_en' => 'Infection Panel',
                'code' => 'PANEL04',
                'price' => 2000.00,
                'time' => 22,
                'description_uz' => 'Turli infektsiyalarni aniqlash uchun panel.',
                'description_ru' => 'Панель для выявления различных инфекций.',
                'description_en' => 'Panel for detecting various infections.',
                'department_id' => 2,
                'status' => 0,
            ],
            [
                'name_uz' => 'Vitamin va Mineral Panel',
                'name_ru' => 'Витаминная и минеральная панель',
                'name_en' => 'Vitamin and Mineral Panel',
                'code' => 'PANEL05',
                'price' => 2200.00,
                'time' => 24,
                'description_uz' => 'Organizmdagi vitamin va minerallar darajasini tekshirish.',
                'description_ru' => 'Проверка уровня витаминов и минералов в организме.',
                'description_en' => 'Checking vitamin and mineral levels in the body.',
                'department_id' => 1,
                'status' => 1,
            ],
        ];

        foreach ($panels as $panelData) {
            Panel::create($panelData);
        }
    }
}