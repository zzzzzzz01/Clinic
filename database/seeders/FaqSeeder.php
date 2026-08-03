<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question_uz' => "Qabul vaqtlari qanday?",
                'question_ru' => "Каковы часы приема?",
                'question_en' => "What are the working hours?",
        
                'answer_uz' => "Dushanba-Juma kunlari 08:00 dan 20:00 gacha, Shanba kuni 09:00 dan 17:00 gacha, Yakshanba kuni 09:00 dan 14:00 gacha. Shoshilinch holatlarda 24/7 xizmat ko'rsatamiz.",
                'answer_ru' => "С понедельника по пятницу с 08:00 до 20:00, в субботу с 09:00 до 17:00, в воскресенье с 09:00 до 14:00. В экстренных случаях работаем круглосуточно.",
                'answer_en' => "Monday-Friday from 08:00 to 20:00, Saturday from 09:00 to 17:00, Sunday from 09:00 to 14:00. We operate 24/7 for emergencies.",
        
                'sort_order' => 1,
                'status' => true,
            ],
            [
                'question_uz' => "Qanday shifokorlar qabul qiladi?",
                'question_ru' => "Какие врачи ведут прием?",
                'question_en' => "What doctors are available?",
        
                'answer_uz' => "Bizda terapevt, kardiolog, nevrolog, xirurg, ginekolog, oftalmolog va boshqa ixtisoslashtirilgan shifokorlar qabul qiladi. To'liq ro'yxatni saytimizdan ko'rishingiz mumkin.",
                'answer_ru' => "У нас ведут прием терапевт, кардиолог, невролог, хирург, гинеколог, офтальмолог и другие узкие специалисты. Полный список можно посмотреть на нашем сайте.",
                'answer_en' => "We have therapists, cardiologists, neurologists, surgeons, gynecologists, ophthalmologists and other specialists. Full list is available on our website.",
        
                'sort_order' => 2,
                'status' => true,
            ],
            [
                'question_uz' => "Shifokor qabuliga qanday tayyorgarlik ko'rish kerak?",
                'question_ru' => "Как подготовиться к приему врача?",
                'question_en' => "How to prepare for a doctor's appointment?",
        
                'answer_uz' => "Shaxsni tasdiqlovchi hujjat, oldingi tibbiy xulosalar va tahlil natijalarini olib kelishingiz tavsiya etiladi. Ba'zi mutaxassislar maxsus tayyorgarlik talab qilishi mumkin.",
                'answer_ru' => "Рекомендуется взять с собой удостоверение личности, предыдущие медицинские заключения и результаты анализов. Некоторые специалисты могут требовать специальную подготовку.",
                'answer_en' => "Please bring your ID, previous medical records and test results. Some specialists may require special preparation.",
        
                'sort_order' => 3,
                'status' => true,
            ],
            [
                'question_uz' => "Tahlil natijalari necha kunda tayyor bo'ladi?",
                'question_ru' => "Через сколько дней готовы результаты анализов?",
                'question_en' => "How long does it take to get test results?",
        
                'answer_uz' => "Tahlil turiga qarab natijalar 1-5 ish kuni ichida tayyor bo'ladi. Natijalarni shaxsiy kabinet orqali yoki shifokor qabulida olishingiz mumkin.",
                'answer_ru' => "Результаты анализов готовятся от 1 до 5 рабочих дней в зависимости от типа анализа. Вы можете получить их в личном кабинете или на приеме у врача.",
                'answer_en' => "Test results are ready within 1-5 working days depending on the type of test. Results can be viewed in your account or during a doctor's appointment.",
        
                'sort_order' => 4,
                'status' => true,
            ],
            [
                'question_uz' => "To'lov usullari qanday?",
                'question_ru' => "Какие способы оплаты доступны?",
                'question_en' => "What payment methods are available?",
        
                'answer_uz' => "Bizda naqd pul, bank kartalari (Visa, MasterCard, UnionPay), mobil to'lovlar (Payme, Click, Uzumbank) va onlayn to'lov tizimlari orqali to'lov qilishingiz mumkin.",
                'answer_ru' => "Вы можете оплатить наличными, банковскими картами (Visa, MasterCard, UnionPay), мобильными платежами (Payme, Click, Uzumbank) или через онлайн-платежные системы.",
                'answer_en' => "You can pay by cash, bank cards (Visa, MasterCard, UnionPay), mobile payments (Payme, Click, Uzumbank) or online payment systems.",
        
                'sort_order' => 5,
                'status' => true,
            ],
            [
                'question_uz' => "Chegirmalar mavjudmi?",
                'question_ru' => "Есть ли скидки?",
                'question_en' => "Are there any discounts?",
        
                'answer_uz' => "Ha, nafaqaxo'rlar (15%), invalidlar (20%), ko'p bolali onalar (10%) va doimiy mijozlar (5%) uchun chegirmalar amal qiladi. Chegirmalar asosiy xizmatlar uchun taqdim etiladi.",
                'answer_ru' => "Да, действуют скидки для пенсионеров (15%), инвалидов (20%), многодетных матерей (10%) и постоянных клиентов (5%). Скидки предоставляются на основные услуги.",
                'answer_en' => "Yes, we offer discounts for pensioners (15%), people with disabilities (20%), mothers with many children (10%) and regular customers (5%). Discounts apply to basic services.",
        
                'sort_order' => 6,
                'status' => true,
            ],
            [
                'question_uz' => "Telemeditsina xizmatlari bormi?",
                'question_ru' => "Есть ли услуги телемедицины?",
                'question_en' => "Do you offer telemedicine services?",
        
                'answer_uz' => "Ha, video orqali masofaviy konsultatsiyalar o'tkazamiz. Siz o'zingizga qulay vaqtda shifokor bilan video-aloqa orqali bog'lanishingiz mumkin.",
                'answer_ru' => "Да, мы проводим дистанционные консультации по видео. Вы можете связаться с врачом в удобное для вас время через видеозвонок.",
                'answer_en' => "Yes, we offer remote video consultations. You can connect with a doctor via video call at your convenient time.",
        
                'sort_order' => 7,
                'status' => true,
            ],
        ];

        foreach($faqs as $faq){
            Faq::create($faq);
        }
    }
}