<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'name_uz' => 'Konditsioner',
                'name_ru' => 'Кондиционер',
                'name_en' => 'Air Conditioner',
                'description_uz' => 'Iqlimni boshqarish tizimi',
                'description_ru' => 'Система климат-контроля',
                'description_en' => 'Climate control system'
            ],
            [
                'name_uz' => 'Smart TV',
                'name_ru' => 'Smart TV',
                'name_en' => 'Smart TV',
                'description_uz' => 'Aqlli televizor',
                'description_ru' => 'Умный телевизор',
                'description_en' => 'Smart television'
            ],
            [
                'name_uz' => 'Wi-Fi Internet',
                'name_ru' => 'Wi-Fi Интернет',
                'name_en' => 'Wi-Fi Internet',
                'description_uz' => 'Tez va bepul internet',
                'description_ru' => 'Быстрый и бесплатный интернет',
                'description_en' => 'Fast and free internet'
            ],
            [
                'name_uz' => 'Xususiy hojatxona',
                'name_ru' => 'Частный туалет',
                'name_en' => 'Private Bathroom',
                'description_uz' => 'Shaxsiy sanitariya',
                'description_ru' => 'Личная гигиена',
                'description_en' => 'Private sanitation'
            ],
            [
                'name_uz' => 'Telefon',
                'name_ru' => 'Телефон',
                'name_en' => 'Telephone',
                'description_uz' => 'Ichki aloqa tizimi',
                'description_ru' => 'Внутренняя связь',
                'description_en' => 'Internal communication system'
            ],
            [
                'name_uz' => 'Mini bar',
                'name_ru' => 'Мини-бар',
                'name_en' => 'Mini Bar',
                'description_uz' => 'Sovuq ichimliklar',
                'description_ru' => 'Прохладительные напитки',
                'description_en' => 'Cold drinks'
            ],
            [
                'name_uz' => 'Seif',
                'name_ru' => 'Сейф',
                'name_en' => 'Safe',
                'description_uz' => 'Qimmatbaho narsalar uchun',
                'description_ru' => 'Для ценных вещей',
                'description_en' => 'For valuables'
            ],
            [
                'name_uz' => 'Nogironlar uchun',
                'name_ru' => 'Для инвалидов',
                'name_en' => 'For Disabled',
                'description_uz' => 'Nogironlar uchun moslashtirilgan',
                'description_ru' => 'Адаптировано для инвалидов',
                'description_en' => 'Adapted for disabled'
            ],
            [
                'name_uz' => 'Balkon',
                'name_ru' => 'Балкон',
                'name_en' => 'Balcony',
                'description_uz' => 'Ochiq havoda dam olish',
                'description_ru' => 'Отдых на свежем воздухе',
                'description_en' => 'Outdoor relaxation'
            ],
            [
                'name_uz' => 'Manzara',
                'name_ru' => 'Вид',
                'name_en' => 'View',
                'description_uz' => 'Chiroyli tabiiy manzara',
                'description_ru' => 'Красивый природный вид',
                'description_en' => 'Beautiful natural view'
            ]
        ];

        foreach ($features as $feature) {
            Feature::create([
                'name_uz' => $feature['name_uz'],
                'name_ru' => $feature['name_ru'],
                'name_en' => $feature['name_en'],
                'description_uz' => $feature['description_uz'],
                'description_ru' => $feature['description_ru'],
                'description_en' => $feature['description_en'],
                'status' => rand(0, 1)
            ]);
        }
    }
}