<?php

namespace Database\Seeders;

use App\Models\DepartmentFeature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [

            // ==================== KARDIOLOGIYA ====================
            [
                'department_id' => 1,
                'title_uz' => 'Zamonaviy uskunalar',
                'title_ru' => 'Современное оборудование',
                'title_en' => 'Modern Equipment',
        
                'description_uz' => 'Bo‘limimiz eng so‘nggi avlod EKG, ExoKG va Xolter monitoring uskunalari bilan jihozlangan. Zamonaviy texnologiyalar yurak-qon tomir kasalliklarini erta aniqlash va aniq tashxis qo‘yish imkonini beradi.',
                'description_ru' => 'Отделение оснащено современными аппаратами ЭКГ, ЭхоКГ и Холтер-мониторинга. Новейшие технологии позволяют выявлять сердечно-сосудистые заболевания на ранних стадиях.',
                'description_en' => 'Our department is equipped with modern ECG, Echocardiography and Holter monitoring systems. Advanced technology enables early and accurate diagnosis of cardiovascular diseases.',
        
                'sort_order' => 1,
            ],
            [
                'department_id' => 1,
                'title_uz' => 'Malakali mutaxassislar',
                'title_ru' => 'Квалифицированные специалисты',
                'title_en' => 'Qualified Specialists',
        
                'description_uz' => 'Bo‘limimizda 10 yildan ortiq tajribaga ega kardiologlar faoliyat yuritadi. Shifokorlar muntazam ravishda xalqaro malaka oshirish dasturlarida ishtirok etib, zamonaviy davolash usullarini qo‘llaydilar.',
                'description_ru' => 'В отделении работают опытные кардиологи, регулярно проходящие международное повышение квалификации и использующие современные методы лечения.',
                'description_en' => 'Our experienced cardiologists regularly attend international training programs and apply the latest evidence-based treatment methods.',
        
                'sort_order' => 2,
            ],
            [
                'department_id' => 1,
                'title_uz' => '24/7 shoshilinch yordam',
                'title_ru' => 'Круглосуточная помощь',
                'title_en' => '24/7 Emergency Care',
        
                'description_uz' => 'Yurak bilan bog‘liq favqulodda holatlarda bo‘limimiz tun-u kun xizmat ko‘rsatadi. Zamonaviy reanimatsiya uskunalari va tezkor tibbiy guruh bemorlarga qisqa vaqt ichida yordam ko‘rsatadi.',
                'description_ru' => 'Круглосуточная помощь при экстренных сердечных состояниях. Современное оборудование и опытная команда обеспечивают быстрое лечение.',
                'description_en' => 'Round-the-clock emergency cardiac care with advanced equipment and an experienced medical team.',
        
                'sort_order' => 3,
            ],
            [
                'department_id' => 1,
                'title_uz' => 'Xalqaro standartlar',
                'title_ru' => 'Международные стандарты',
                'title_en' => 'International Standards',
        
                'description_uz' => 'Barcha diagnostika va davolash jarayonlari xalqaro klinik tavsiyalar hamda zamonaviy tibbiyot standartlari asosida amalga oshiriladi.',
                'description_ru' => 'Все процедуры проводятся в соответствии с международными клиническими рекомендациями.',
                'description_en' => 'All diagnostic and treatment procedures follow international clinical guidelines and standards.',
        
                'sort_order' => 4,
            ],
        
            // ==================== NEVROLOGIYA ====================
            [
                'department_id' => 2,
                'title_uz' => 'Yuqori aniqlikdagi diagnostika',
                'title_ru' => 'Высокоточная диагностика',
                'title_en' => 'High-Precision Diagnostics',
        
                'description_uz' => 'EEG va boshqa zamonaviy diagnostika uskunalari yordamida bosh miya hamda asab tizimi kasalliklari yuqori aniqlikda tekshiriladi.',
                'description_ru' => 'Современное оборудование ЭЭГ позволяет точно диагностировать заболевания нервной системы.',
                'description_en' => 'Modern EEG and diagnostic equipment ensure accurate evaluation of neurological disorders.',
        
                'sort_order' => 1,
            ],
            [
                'department_id' => 2,
                'title_uz' => 'Tajribali nevrologlar',
                'title_ru' => 'Опытные неврологи',
                'title_en' => 'Experienced Neurologists',
        
                'description_uz' => 'Nevrolog mutaxassislar insult, epilepsiya, migren va boshqa asab tizimi kasalliklarini zamonaviy usullar asosida davolaydi.',
                'description_ru' => 'Опытные неврологи проводят диагностику и лечение инсульта, эпилепсии и других заболеваний.',
                'description_en' => 'Our neurologists specialize in stroke, epilepsy, migraine and other neurological conditions.',
        
                'sort_order' => 2,
            ],
            [
                'department_id' => 2,
                'title_uz' => 'Kompleks reabilitatsiya',
                'title_ru' => 'Комплексная реабилитация',
                'title_en' => 'Comprehensive Rehabilitation',
        
                'description_uz' => 'Insult va boshqa nevrologik kasalliklardan keyingi tiklanish uchun individual reabilitatsiya dasturlari ishlab chiqiladi.',
                'description_ru' => 'Индивидуальные программы реабилитации после инсульта и других неврологических заболеваний.',
                'description_en' => 'Personalized rehabilitation programs help patients recover after stroke and neurological disorders.',
        
                'sort_order' => 3,
            ],
            [
                'department_id' => 2,
                'title_uz' => 'Individual davolash',
                'title_ru' => 'Индивидуальное лечение',
                'title_en' => 'Personalized Treatment',
        
                'description_uz' => 'Har bir bemor uchun alohida diagnostika va davolash rejasi tuziladi, natijalar muntazam nazorat qilinadi.',
                'description_ru' => 'Для каждого пациента разрабатывается индивидуальный план лечения.',
                'description_en' => 'Every patient receives a personalized diagnosis and treatment plan.',
        
                'sort_order' => 4,
            ],
        
            // ==================== ENDOKRINOLOGIYA ====================
            [
                'department_id' => 3,
                'title_uz' => 'Zamonaviy laboratoriya',
                'title_ru' => 'Современная лаборатория',
                'title_en' => 'Modern Laboratory',
        
                'description_uz' => 'Gormonlar va qondagi glyukoza ko‘rsatkichlari zamonaviy laboratoriya uskunalarida yuqori aniqlik bilan tekshiriladi.',
                'description_ru' => 'Современная лаборатория обеспечивает точные гормональные и биохимические исследования.',
                'description_en' => 'Advanced laboratory equipment provides highly accurate hormone and blood glucose testing.',
        
                'sort_order' => 1,
            ],
            [
                'department_id' => 3,
                'title_uz' => 'Diabet nazorati',
                'title_ru' => 'Контроль диабета',
                'title_en' => 'Diabetes Management',
        
                'description_uz' => 'Qandli diabet bilan yashovchi bemorlar uchun individual kuzatuv, ovqatlanish tavsiyalari va davolash dasturlari ishlab chiqiladi.',
                'description_ru' => 'Комплексное наблюдение и лечение пациентов с сахарным диабетом.',
                'description_en' => 'Comprehensive monitoring and personalized treatment plans for patients with diabetes.',
        
                'sort_order' => 2,
            ],
            [
                'department_id' => 3,
                'title_uz' => 'Malakali endokrinologlar',
                'title_ru' => 'Квалифицированные эндокринологи',
                'title_en' => 'Qualified Endocrinologists',
        
                'description_uz' => 'Endokrin tizim kasalliklarini davolash bo‘yicha katta tajribaga ega mutaxassislar zamonaviy usullardan foydalanadi.',
                'description_ru' => 'Опытные эндокринологи применяют современные методы диагностики и лечения.',
                'description_en' => 'Experienced endocrinologists provide modern diagnosis and treatment for endocrine disorders.',
        
                'sort_order' => 3,
            ],
            [
                'department_id' => 3,
                'title_uz' => 'Kompleks yondashuv',
                'title_ru' => 'Комплексный подход',
                'title_en' => 'Comprehensive Care',
        
                'description_uz' => 'Davolash jarayonida laboratoriya, dietolog va boshqa mutaxassislar bilan hamkorlikda kompleks yondashuv qo‘llaniladi.',
                'description_ru' => 'Комплексное лечение проводится совместно с лабораторией и другими специалистами.',
                'description_en' => 'Treatment is provided through a multidisciplinary approach involving laboratory and clinical specialists.',
        
                'sort_order' => 4,
            ],

            // ==================== OFTALMOLOGIYA ====================
            [
                'department_id' => 4,
                'title_uz' => 'Zamonaviy lazer texnologiyalari',
                'title_ru' => 'Современные лазерные технологии',
                'title_en' => 'Advanced Laser Technology',

                'description_uz' => 'Bo‘limimiz eng so‘nggi avlod lazer uskunalari bilan jihozlangan. Katarakta, glaukoma va boshqa ko‘z kasalliklarini xavfsiz hamda yuqori aniqlik bilan davolash imkoniyati mavjud.',
                'description_ru' => 'Отделение оснащено современными лазерными системами для безопасного и эффективного лечения заболеваний глаз.',
                'description_en' => 'Our department uses advanced laser systems for safe and effective treatment of various eye diseases.',

                'sort_order' => 1,
            ],
            [
                'department_id' => 4,
                'title_uz' => 'Yuqori aniqlikdagi diagnostika',
                'title_ru' => 'Высокоточная диагностика',
                'title_en' => 'High-Precision Diagnostics',

                'description_uz' => 'OCT, autorefraktometr va boshqa zamonaviy diagnostika uskunalari yordamida ko‘z kasalliklari erta bosqichda aniqlanadi.',
                'description_ru' => 'Современное диагностическое оборудование позволяет выявлять заболевания глаз на ранних стадиях.',
                'description_en' => 'Advanced diagnostic equipment enables early detection of eye diseases.',

                'sort_order' => 2,
            ],
            [
                'department_id' => 4,
                'title_uz' => 'Tajribali oftalmologlar',
                'title_ru' => 'Опытные офтальмологи',
                'title_en' => 'Experienced Ophthalmologists',

                'description_uz' => 'Ko‘p yillik tajribaga ega mutaxassislar har bir bemor uchun individual davolash rejasini ishlab chiqadi va zamonaviy usullarni qo‘llaydi.',
                'description_ru' => 'Опытные офтальмологи используют современные методы диагностики и лечения.',
                'description_en' => 'Experienced ophthalmologists provide personalized diagnosis and treatment using modern techniques.',

                'sort_order' => 3,
            ],
            [
                'department_id' => 4,
                'title_uz' => 'Minimal invaziv muolajalar',
                'title_ru' => 'Минимально инвазивные процедуры',
                'title_en' => 'Minimally Invasive Procedures',

                'description_uz' => 'Ko‘plab muolajalar qisqa vaqt ichida, og‘riqsiz va bemor uchun maksimal qulaylik yaratgan holda amalga oshiriladi.',
                'description_ru' => 'Большинство процедур проводится быстро, безопасно и с минимальным дискомфортом.',
                'description_en' => 'Most procedures are performed quickly, safely and with minimal discomfort.',

                'sort_order' => 4,
            ],

            // ==================== OTORINOLARINGOLOGIYA ====================
            [
                'department_id' => 5,
                'title_uz' => 'Endoskopik diagnostika',
                'title_ru' => 'Эндоскопическая диагностика',
                'title_en' => 'Endoscopic Diagnostics',

                'description_uz' => 'Quloq, burun va tomoq kasalliklarini zamonaviy endoskopik uskunalar yordamida tez va aniq tashxislash imkoniyati mavjud.',
                'description_ru' => 'Современная эндоскопическая диагностика обеспечивает точное выявление ЛОР-заболеваний.',
                'description_en' => 'Modern endoscopic equipment ensures accurate diagnosis of ENT disorders.',

                'sort_order' => 1,
            ],
            [
                'department_id' => 5,
                'title_uz' => 'Malakali LOR mutaxassislari',
                'title_ru' => 'Квалифицированные ЛОР-специалисты',
                'title_en' => 'Qualified ENT Specialists',

                'description_uz' => 'Bo‘limimiz shifokorlari bolalar va kattalar orasida uchraydigan barcha LOR kasalliklarini zamonaviy usullar bilan davolaydi.',
                'description_ru' => 'Опытные ЛОР-врачи оказывают помощь детям и взрослым.',
                'description_en' => 'Our ENT specialists provide comprehensive care for both adults and children.',

                'sort_order' => 2,
            ],
            [
                'department_id' => 5,
                'title_uz' => 'Minimal invaziv davolash',
                'title_ru' => 'Минимально инвазивное лечение',
                'title_en' => 'Minimally Invasive Treatment',

                'description_uz' => 'Ko‘plab muolajalar zamonaviy texnologiyalar yordamida og‘riqsiz va tez tiklanish imkonini beradigan usullarda bajariladi.',
                'description_ru' => 'Современные методы лечения обеспечивают быстрое восстановление пациента.',
                'description_en' => 'Modern treatment techniques allow faster recovery with minimal discomfort.',

                'sort_order' => 3,
            ],
            [
                'department_id' => 5,
                'title_uz' => 'Tezkor qabul va yordam',
                'title_ru' => 'Быстрая медицинская помощь',
                'title_en' => 'Fast Medical Assistance',

                'description_uz' => 'Shoshilinch holatlarda bemorlar qisqa vaqt ichida ko‘rikdan o‘tkazilib, zarur davolash choralari ko‘riladi.',
                'description_ru' => 'Пациенты получают своевременную диагностику и лечение без длительного ожидания.',
                'description_en' => 'Patients receive prompt diagnosis and treatment without unnecessary delays.',

                'sort_order' => 4,
            ],

            // ==================== PEDIATRIYA ====================
            [
                'department_id' => 6,
                'title_uz' => 'Bolalar uchun qulay muhit',
                'title_ru' => 'Комфортная атмосфера для детей',
                'title_en' => 'Child-Friendly Environment',

                'description_uz' => 'Bo‘lim bolalar psixologiyasini hisobga olgan holda jihozlangan bo‘lib, kichik bemorlarning o‘zini erkin va xavfsiz his qilishiga yordam beradi.',
                'description_ru' => 'Отделение создано с учетом потребностей детей и обеспечивает комфортную атмосферу.',
                'description_en' => 'Our pediatric department provides a safe and welcoming environment for children.',

                'sort_order' => 1,
            ],
            [
                'department_id' => 6,
                'title_uz' => 'Tajribali pediatrlar',
                'title_ru' => 'Опытные педиатры',
                'title_en' => 'Experienced Pediatricians',

                'description_uz' => 'Pediatrlarimiz yangi tug‘ilgan chaqaloqlardan tortib o‘smirlargacha bo‘lgan bemorlarga malakali tibbiy yordam ko‘rsatadi.',
                'description_ru' => 'Опытные педиатры оказывают медицинскую помощь детям всех возрастов.',
                'description_en' => 'Our pediatricians provide expert care for children of all ages.',

                'sort_order' => 2,
            ],
            [
                'department_id' => 6,
                'title_uz' => 'Tezkor diagnostika',
                'title_ru' => 'Быстрая диагностика',
                'title_en' => 'Rapid Diagnostics',

                'description_uz' => 'Zamonaviy laboratoriya va diagnostika uskunalari yordamida kasalliklar qisqa muddatda aniqlanadi va davolash boshlanadi.',
                'description_ru' => 'Современная диагностика позволяет быстро определить заболевание и начать лечение.',
                'description_en' => 'Modern diagnostic equipment allows rapid detection and treatment of childhood illnesses.',

                'sort_order' => 3,
            ],
            [
                'department_id' => 6,
                'title_uz' => 'Oilaviy yondashuv',
                'title_ru' => 'Семейный подход',
                'title_en' => 'Family-Centered Care',

                'description_uz' => 'Davolash jarayonida ota-onalar bilan yaqin hamkorlik qilinadi hamda bolaning sog‘lom rivojlanishi bo‘yicha tavsiyalar beriladi.',
                'description_ru' => 'Мы тесно сотрудничаем с родителями для достижения лучших результатов лечения.',
                'description_en' => 'We work closely with families to ensure the best outcomes for every child.',

                'sort_order' => 4,
            ],

            // ==================== PSIXIATRIYA ====================
            [
                'department_id' => 7,
                'title_uz' => 'To‘liq maxfiylik',
                'title_ru' => 'Полная конфиденциальность',
                'title_en' => 'Complete Confidentiality',

                'description_uz' => 'Har bir bemorning shaxsiy ma’lumotlari va davolash jarayoni qat’iy maxfiylik tamoyillari asosida himoyalanadi.',
                'description_ru' => 'Мы гарантируем полную конфиденциальность информации каждого пациента.',
                'description_en' => 'We guarantee complete confidentiality for every patient\'s personal information and treatment.',

                'sort_order' => 1,
            ],
            [
                'department_id' => 7,
                'title_uz' => 'Professional psixoterapevtlar',
                'title_ru' => 'Профессиональные психотерапевты',
                'title_en' => 'Professional Psychotherapists',

                'description_uz' => 'Bo‘limimizda tajribali psixiatr va psixoterapevtlar zamonaviy diagnostika hamda davolash usullaridan foydalanadi.',
                'description_ru' => 'Наши специалисты используют современные методы диагностики и психотерапии.',
                'description_en' => 'Our psychiatrists and psychotherapists apply modern diagnostic and therapeutic approaches.',

                'sort_order' => 2,
            ],
            [
                'department_id' => 7,
                'title_uz' => 'Individual terapiya',
                'title_ru' => 'Индивидуальная терапия',
                'title_en' => 'Personalized Therapy',

                'description_uz' => 'Har bir bemorning ruhiy holati chuqur baholanib, uning ehtiyojlariga mos individual davolash dasturi ishlab chiqiladi.',
                'description_ru' => 'Для каждого пациента разрабатывается индивидуальная программа лечения.',
                'description_en' => 'Each patient receives a personalized treatment plan tailored to their needs.',

                'sort_order' => 3,
            ],
            [
                'department_id' => 7,
                'title_uz' => 'Qulay va xavfsiz muhit',
                'title_ru' => 'Комфортная и безопасная атмосфера',
                'title_en' => 'Comfortable and Safe Environment',

                'description_uz' => 'Bemorlarning ruhiy xotirjamligini ta’minlash maqsadida bo‘limimiz tinch, xavfsiz va qulay muhitda tashkil etilgan.',
                'description_ru' => 'Мы создали спокойную и безопасную атмосферу для эффективного восстановления пациентов.',
                'description_en' => 'We provide a calm, secure and supportive environment that promotes mental well-being and recovery.',

                'sort_order' => 4,
            ],
        
        ];

        foreach ($features as $feature) {
            DepartmentFeature::create($feature);
        }
    }
}
