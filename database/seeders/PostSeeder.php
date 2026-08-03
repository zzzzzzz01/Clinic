<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'user_id' => 1,
                'category_id' => 1,
                'title_uz' => 'Shifoxonamizda yangi kardiologiya bo‘limi ochildi',
                'title_ru' => 'В нашей больнице открылось новое отделение кардиологии',
                'title_en' => 'A New Cardiology Department Has Opened',
                'description_uz' => 'Zamonaviy uskunalar bilan jihozlangan yangi bo‘lim ish boshladi.',
                'description_ru' => 'Новое отделение оснащено современным медицинским оборудованием.',
                'description_en' => 'The new department is equipped with modern medical technology.',
                'content_uz' => 'Shifoxonamizda zamonaviy diagnostika va davolash uskunalari bilan jihozlangan yangi kardiologiya bo‘limi faoliyat boshladi. Endilikda yurak-qon tomir kasalliklarini aniqlash va davolash yanada sifatli amalga oshiriladi.',
                'content_ru' => 'В нашей больнице начало работу новое кардиологическое отделение с современным оборудованием для диагностики и лечения сердечно-сосудистых заболеваний.',
                'content_en' => 'Our hospital has launched a new cardiology department equipped with advanced technology for diagnosing and treating cardiovascular diseases.',
                'photo' => 'imagePost/kardiologiya-bo\'limi.jpg',
                'views' => 10,
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'title_uz' => 'Yurak salomatligini saqlash bo‘yicha tavsiyalar',
                'title_ru' => 'Советы по сохранению здоровья сердца',
                'title_en' => 'Tips for Maintaining Heart Health',
                'description_uz' => 'Kardiologlarning foydali tavsiyalari.',
                'description_ru' => 'Полезные рекомендации кардиологов.',
                'description_en' => 'Useful advice from cardiologists.',
                'content_uz' => 'To‘g‘ri ovqatlanish, muntazam jismoniy faollik va qon bosimini nazorat qilish yurak salomatligini saqlashning asosiy omillaridan hisoblanadi.',
                'content_ru' => 'Правильное питание, физическая активность и контроль артериального давления являются основой здоровья сердца.',
                'content_en' => 'A healthy diet, regular exercise, and blood pressure control are essential for maintaining heart health.',
                'photo' => 'imagePost/Yurak-tavsiyalar.jpg',
                'views' => 12,
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'title_uz' => 'Sog‘lom turmush tarzi bo‘yicha 5 muhim qoida',
                'title_ru' => '5 важных правил здорового образа жизни',
                'title_en' => '5 Essential Healthy Lifestyle Tips',
                'description_uz' => 'Har kuni amal qilish tavsiya etiladi.',
                'description_ru' => 'Рекомендуется соблюдать ежедневно.',
                'description_en' => 'Recommended for everyday life.',
                'content_uz' => 'Kuniga kamida 30 daqiqa harakat qilish, meva-sabzavot iste’molini oshirish va yetarli uyqu sog‘lom hayotning muhim qismidir.',
                'content_ru' => 'Ежедневная физическая активность, употребление овощей и фруктов, а также полноценный сон способствуют здоровому образу жизни.',
                'content_en' => 'Daily exercise, a balanced diet, and sufficient sleep are key elements of a healthy lifestyle.',
                'photo' => 'imagePost/Healthy-lifestyle.avif',
                'views' => 5,
            ],
            [
                'user_id' => 1,
                'category_id' => 4,
                'title_uz' => 'Bepul tibbiy ko‘rik aksiyasi boshlandi',
                'title_ru' => 'Стартовала акция бесплатного медицинского обследования',
                'title_en' => 'Free Medical Check-up Campaign Started',
                'description_uz' => 'Aksiya bir hafta davom etadi.',
                'description_ru' => 'Акция продлится одну неделю.',
                'description_en' => 'The campaign will last one week.',
                'content_uz' => 'Barcha fuqarolar bepul terapevt va kardiolog ko‘rigidan o‘tishlari mumkin. Oldindan ro‘yxatdan o‘tish tavsiya etiladi.',
                'content_ru' => 'Все желающие могут бесплатно пройти осмотр терапевта и кардиолога. Рекомендуется предварительная запись.',
                'content_en' => 'Everyone is welcome to receive a free consultation with a therapist and cardiologist. Prior registration is recommended.',
                'photo' => 'imagePost/Free-medical-check-up.avif',
                'views' => 31,
            ],
            [
                'user_id' => 1,
                'category_id' => 5,
                'title_uz' => 'MRI diagnostika uskunasi ishga tushirildi',
                'title_ru' => 'Запущен новый аппарат МРТ',
                'title_en' => 'New MRI Scanner Launched',
                'description_uz' => 'Yuqori aniqlikdagi zamonaviy diagnostika.',
                'description_ru' => 'Современная диагностика высокой точности.',
                'description_en' => 'High-precision modern diagnostics.',
                'content_uz' => 'Yangi MRI uskunasi murakkab kasalliklarni erta aniqlash imkoniyatini yaratadi va xalqaro standartlarga javob beradi.',
                'content_ru' => 'Новый аппарат МРТ позволяет проводить раннюю диагностику сложных заболеваний и соответствует международным стандартам.',
                'content_en' => 'The new MRI scanner enables early diagnosis of complex diseases and meets international standards.',
                'photo' => 'imagePost/MRI-diagnostic-equipment.jpg',
                'views' => 50,
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'title_uz' => 'Shifoxonamiz xalqaro konferensiyada ishtirok etdi',
                'title_ru' => 'Наша больница приняла участие в международной конференции',
                'title_en' => 'Our Hospital Participated in an International Conference',
                'description_uz' => 'Shifokorlarimiz xalqaro tajriba almashishdi.',
                'description_ru' => 'Наши врачи обменялись международным опытом.',
                'description_en' => 'Our doctors exchanged international experience.',
                'content_uz' => 'Konferensiyada zamonaviy davolash usullari va innovatsion tibbiy texnologiyalar muhokama qilindi. Shifoxonamiz mutaxassislari faol ishtirok etdilar.',
                'content_ru' => 'На конференции обсуждались современные методы лечения и инновационные медицинские технологии. Наши специалисты приняли активное участие.',
                'content_en' => 'Modern treatment methods and innovative medical technologies were discussed at the conference, where our specialists actively participated.',
                'photo' => 'imagePost/international-conference.jpg',
                'views' => 20,
            ],
        ];
        
        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
