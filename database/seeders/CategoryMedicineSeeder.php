<?php

namespace Database\Seeders;

use App\Models\CategoryMedicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryMedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_uz' => 'Analgetik ',
                'name_ru' => 'Анальгетик  ',
                'name_en' => 'Analgesic  '
            ],
            [
                'name_uz' => 'Antibiotik',
                'name_ru' => 'Антибиотик',
                'name_en' => 'Antibiotic'
            ],
            [
                'name_uz' => 'Antivirus',
                'name_ru' => 'Антивирусный',
                'name_en' => 'Antiviral'
            ],
            [
                'name_uz' => 'Vitamin va mineral',
                'name_ru' => 'Витамины и минералы',
                'name_en' => 'Vitamins and minerals'
            ],
            [
                'name_uz' => 'Allergiyaga qarshi',
                'name_ru' => 'Противоаллергенный',
                'name_en' => 'Antiallergic'
            ],
            [
                'name_uz' => 'Oshqozon-ichak dorilari',
                'name_ru' => 'Желудочно-кишечные препараты',
                'name_en' => 'Gastrointestinal drugs'
            ],
            [
                'name_uz' => 'Yurak-qon tomir',
                'name_ru' => 'Сердечно-сосудистые',
                'name_en' => 'Cardiovascular'
            ],
            [
                'name_uz' => 'Gormonlar',
                'name_ru' => 'Гормоны',
                'name_en' => 'Hormones'
            ],
            [
                'name_uz' => 'Inyektsiya uchun dorilar',
                'name_ru' => 'Препараты для инъекций',
                'name_en' => 'Injectable drugs'
            ],
            [
                'name_uz' => 'Bolalar uchun dorilar',
                'name_ru' => 'Детские препараты',
                'name_en' => 'Children\'s drugs'
            ],
            [
                'name_uz' => 'Tashqi qo‘llaniladigan dorilar ',
                'name_ru' => 'Наружные препараты ',
                'name_en' => 'Topical drugs'
            ],
            [
                'name_uz' => 'Ko‘z tomchilari',
                'name_ru' => 'Глазные капли',
                'name_en' => 'Eye drops'
            ],
            [
                'name_uz' => 'Burun tomchilari',
                'name_ru' => 'Назальные капли',
                'name_en' => 'Nasal drops'
            ],
            [
                'name_uz' => 'Sirop va suspenziya',
                'name_ru' => 'Сироп и суспензия',
                'name_en' => 'Syrup and suspension'
            ],
            [
                'name_uz' => 'Psixotrop dorilar',
                'name_ru' => 'Психотропные препараты',
                'name_en' => 'Psychotropic drugs'
            ],
        ];

        foreach ($categories as $category) {
            CategoryMedicine::firstOrCreate([
                'name_uz' => $category['name_uz'],
                'name_ru' => $category['name_ru'],
                'name_en' => $category['name_en']
            ]);
        }
    }
}
