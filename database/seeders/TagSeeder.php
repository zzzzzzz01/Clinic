<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            [
                'name_uz' => 'Kardiologiya',
                'name_ru' => 'Кардиология',
                'name_en' => 'Cardiology',
                'slug' => 'cardiology',
            ],
            [
                'name_uz' => 'Nevrologiya',
                'name_ru' => 'Неврология',
                'name_en' => 'Neurology',
                'slug' => 'neurology',
            ],
            [
                'name_uz' => 'Pediatriya',
                'name_ru' => 'Педиатрия',
                'name_en' => 'Pediatrics',
                'slug' => 'pediatrics',
            ],
            [
                'name_uz' => 'Travmatologiya',
                'name_ru' => 'Травматология',
                'name_en' => 'Traumatology',
                'slug' => 'traumatology',
            ],
            [
                'name_uz' => 'Diagnostika',
                'name_ru' => 'Диагностика',
                'name_en' => 'Diagnostics',
                'slug' => 'diagnostics',
            ],
            [
                'name_uz' => 'Profilaktika',
                'name_ru' => 'Профилактика',
                'name_en' => 'Prevention',
                'slug' => 'prevention',
            ],
            [
                'name_uz' => 'Sog‘lom turmush',
                'name_ru' => 'Здоровый образ жизни',
                'name_en' => 'Healthy Lifestyle',
                'slug' => 'healthy-lifestyle',
            ],
            [
                'name_uz' => 'Tibbiy maslahat',
                'name_ru' => 'Медицинский совет',
                'name_en' => 'Medical Advice',
                'slug' => 'medical-advice',
            ],
            [
                'name_uz' => 'Tahlillar',
                'name_ru' => 'Анализы',
                'name_en' => 'Laboratory Tests',
                'slug' => 'laboratory-tests',
            ],
            [
                'name_uz' => 'Shifokor tavsiyasi',
                'name_ru' => 'Рекомендации врача',
                'name_en' => 'Doctor Recommendations',
                'slug' => 'doctor-recommendations',
            ],
        ];
        
        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
