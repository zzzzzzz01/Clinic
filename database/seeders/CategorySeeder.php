<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name_uz' => 'Shifoxona yangiliklari',
                'name_ru' => 'Новости больницы',
                'name_en' => 'Hospital News',
                'slug' => 'hospital-news',
            ],
            [
                'name_uz' => 'Tibbiy maslahatlar',
                'name_ru' => 'Медицинские советы',
                'name_en' => 'Medical Advice',
                'slug' => 'medical-advice',
            ],
            [
                'name_uz' => 'Sog‘lom turmush tarzi',
                'name_ru' => 'Здоровый образ жизни',
                'name_en' => 'Healthy Lifestyle',
                'slug' => 'healthy-lifestyle',
            ],
            [
                'name_uz' => 'Tadbirlar va aksiyalar',
                'name_ru' => 'Мероприятия и акции',
                'name_en' => 'Events and Promotions',
                'slug' => 'events-and-promotions',
            ],
            [
                'name_uz' => 'Yangi texnologiyalar',
                'name_ru' => 'Новые технологии',
                'name_en' => 'New Technologies',
                'slug' => 'new-technologies',
            ],
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
