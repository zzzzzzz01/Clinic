<?php

namespace Database\Seeders;

use App\Models\DepartmentDisease;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentDiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $diseases = [

            // ==================== KARDIOLOGIYA ====================
            ['department_id'=>1,'name_uz'=>'Ishemik yurak kasalligi','name_ru'=>'Ишемическая болезнь сердца','name_en'=>'Ischemic Heart Disease','sort_order'=>1],
            ['department_id'=>1,'name_uz'=>'Yurak yetishmovchiligi','name_ru'=>'Сердечная недостаточность','name_en'=>'Heart Failure','sort_order'=>2],
            ['department_id'=>1,'name_uz'=>'Aritmiya','name_ru'=>'Аритмия','name_en'=>'Arrhythmia','sort_order'=>3],
            ['department_id'=>1,'name_uz'=>'Yurak qopqog‘i kasalliklari','name_ru'=>'Заболевания клапанов сердца','name_en'=>'Heart Valve Disease','sort_order'=>4],
            ['department_id'=>1,'name_uz'=>'Arterial gipertoniya','name_ru'=>'Артериальная гипертензия','name_en'=>'Hypertension','sort_order'=>5],
            ['department_id'=>1,'name_uz'=>'Kardiomiopatiya','name_ru'=>'Кардиомиопатия','name_en'=>'Cardiomyopathy','sort_order'=>6],
            ['department_id'=>1,'name_uz'=>'Yurak shovqinlari','name_ru'=>'Шумы в сердце','name_en'=>'Heart Murmur','sort_order'=>7],
            ['department_id'=>1,'name_uz'=>'Vaskulit','name_ru'=>'Васкулит','name_en'=>'Vasculitis','sort_order'=>8],
        
            // ==================== NEVROLOGIYA ====================
            ['department_id'=>2,'name_uz'=>'Insult','name_ru'=>'Инсульт','name_en'=>'Stroke','sort_order'=>1],
            ['department_id'=>2,'name_uz'=>'Epilepsiya','name_ru'=>'Эпилепсия','name_en'=>'Epilepsy','sort_order'=>2],
            ['department_id'=>2,'name_uz'=>'Migren','name_ru'=>'Мигрень','name_en'=>'Migraine','sort_order'=>3],
            ['department_id'=>2,'name_uz'=>'Parkinson kasalligi','name_ru'=>'Болезнь Паркинсона','name_en'=>'Parkinson Disease','sort_order'=>4],
            ['department_id'=>2,'name_uz'=>'Altsgeymer kasalligi','name_ru'=>'Болезнь Альцгеймера','name_en'=>'Alzheimer Disease','sort_order'=>5],
            ['department_id'=>2,'name_uz'=>'Nevralgiya','name_ru'=>'Невралгия','name_en'=>'Neuralgia','sort_order'=>6],
            ['department_id'=>2,'name_uz'=>'Nevrit','name_ru'=>'Неврит','name_en'=>'Neuritis','sort_order'=>7],
            ['department_id'=>2,'name_uz'=>'Ko‘p skleroz','name_ru'=>'Рассеянный склероз','name_en'=>'Multiple Sclerosis','sort_order'=>8],
        
            // ==================== ENDOKRINOLOGIYA ====================
            ['department_id'=>3,'name_uz'=>'1-tip diabet','name_ru'=>'Сахарный диабет 1 типа','name_en'=>'Type 1 Diabetes','sort_order'=>1],
            ['department_id'=>3,'name_uz'=>'2-tip diabet','name_ru'=>'Сахарный диабет 2 типа','name_en'=>'Type 2 Diabetes','sort_order'=>2],
            ['department_id'=>3,'name_uz'=>'Gipotireoz','name_ru'=>'Гипотиреоз','name_en'=>'Hypothyroidism','sort_order'=>3],
            ['department_id'=>3,'name_uz'=>'Gipertireoz','name_ru'=>'Гипертиреоз','name_en'=>'Hyperthyroidism','sort_order'=>4],
            ['department_id'=>3,'name_uz'=>'Qalqonsimon bez tugunlari','name_ru'=>'Узлы щитовидной железы','name_en'=>'Thyroid Nodules','sort_order'=>5],
            ['department_id'=>3,'name_uz'=>'Semizlik','name_ru'=>'Ожирение','name_en'=>'Obesity','sort_order'=>6],
            ['department_id'=>3,'name_uz'=>'Metabolik sindrom','name_ru'=>'Метаболический синдром','name_en'=>'Metabolic Syndrome','sort_order'=>7],
            ['department_id'=>3,'name_uz'=>'Osteoporoz','name_ru'=>'Остеопороз','name_en'=>'Osteoporosis','sort_order'=>8],
        
            // ==================== OFTALMOLOGIYA ====================
            ['department_id'=>4,'name_uz'=>'Katarakta','name_ru'=>'Катаракта','name_en'=>'Cataract','sort_order'=>1],
            ['department_id'=>4,'name_uz'=>'Glaukoma','name_ru'=>'Глаукома','name_en'=>'Glaucoma','sort_order'=>2],
            ['department_id'=>4,'name_uz'=>'Konyunktivit','name_ru'=>'Конъюнктивит','name_en'=>'Conjunctivitis','sort_order'=>3],
            ['department_id'=>4,'name_uz'=>'Quruq ko‘z sindromi','name_ru'=>'Синдром сухого глаза','name_en'=>'Dry Eye Syndrome','sort_order'=>4],
            ['department_id'=>4,'name_uz'=>'Retinopatiya','name_ru'=>'Ретинопатия','name_en'=>'Retinopathy','sort_order'=>5],
            ['department_id'=>4,'name_uz'=>'Miyopiya','name_ru'=>'Близорукость','name_en'=>'Myopia','sort_order'=>6],
            ['department_id'=>4,'name_uz'=>'Gipermetropiya','name_ru'=>'Дальнозоркость','name_en'=>'Hyperopia','sort_order'=>7],
            ['department_id'=>4,'name_uz'=>'Astigmatizm','name_ru'=>'Астигматизм','name_en'=>'Astigmatism','sort_order'=>8],
        
            // ==================== OTORINOLARINGOLOGIYA ====================
            ['department_id'=>5,'name_uz'=>'Otit','name_ru'=>'Отит','name_en'=>'Otitis','sort_order'=>1],
            ['department_id'=>5,'name_uz'=>'Sinusit','name_ru'=>'Синусит','name_en'=>'Sinusitis','sort_order'=>2],
            ['department_id'=>5,'name_uz'=>'Tonzillit','name_ru'=>'Тонзиллит','name_en'=>'Tonsillitis','sort_order'=>3],
            ['department_id'=>5,'name_uz'=>'Faringit','name_ru'=>'Фарингит','name_en'=>'Pharyngitis','sort_order'=>4],
            ['department_id'=>5,'name_uz'=>'Laringit','name_ru'=>'Ларингит','name_en'=>'Laryngitis','sort_order'=>5],
            ['department_id'=>5,'name_uz'=>'Burun poliplari','name_ru'=>'Полипы носа','name_en'=>'Nasal Polyps','sort_order'=>6],
            ['department_id'=>5,'name_uz'=>'Eshitish pasayishi','name_ru'=>'Снижение слуха','name_en'=>'Hearing Loss','sort_order'=>7],
            ['department_id'=>5,'name_uz'=>'Burun to‘sig‘i qiyshayishi','name_ru'=>'Искривление носовой перегородки','name_en'=>'Deviated Nasal Septum','sort_order'=>8],
        
            // ==================== PEDIATRIYA ====================
            ['department_id'=>6,'name_uz'=>'O‘RVI','name_ru'=>'ОРВИ','name_en'=>'Acute Respiratory Viral Infection','sort_order'=>1],
            ['department_id'=>6,'name_uz'=>'Bronxit','name_ru'=>'Бронхит','name_en'=>'Bronchitis','sort_order'=>2],
            ['department_id'=>6,'name_uz'=>'Pnevmoniya','name_ru'=>'Пневмония','name_en'=>'Pneumonia','sort_order'=>3],
            ['department_id'=>6,'name_uz'=>'Anemiya','name_ru'=>'Анемия','name_en'=>'Anemia','sort_order'=>4],
            ['department_id'=>6,'name_uz'=>'Ichak infeksiyalari','name_ru'=>'Кишечные инфекции','name_en'=>'Intestinal Infections','sort_order'=>5],
            ['department_id'=>6,'name_uz'=>'Allergik kasalliklar','name_ru'=>'Аллергические заболевания','name_en'=>'Allergic Diseases','sort_order'=>6],
            ['department_id'=>6,'name_uz'=>'Raxit','name_ru'=>'Рахит','name_en'=>'Rickets','sort_order'=>7],
            ['department_id'=>6,'name_uz'=>'Bronxial astma','name_ru'=>'Бронхиальная астма','name_en'=>'Bronchial Asthma','sort_order'=>8],
        
            // ==================== PSIXIATRIYA ====================
            ['department_id'=>7,'name_uz'=>'Depressiya','name_ru'=>'Депрессия','name_en'=>'Depression','sort_order'=>1],
            ['department_id'=>7,'name_uz'=>'Xavotir buzilishi','name_ru'=>'Тревожное расстройство','name_en'=>'Anxiety Disorder','sort_order'=>2],
            ['department_id'=>7,'name_uz'=>'Bipolyar buzilish','name_ru'=>'Биполярное расстройство','name_en'=>'Bipolar Disorder','sort_order'=>3],
            ['department_id'=>7,'name_uz'=>'Shizofreniya','name_ru'=>'Шизофрения','name_en'=>'Schizophrenia','sort_order'=>4],
            ['department_id'=>7,'name_uz'=>'Obsessiv-kompulsiv buzilish','name_ru'=>'Обсессивно-компульсивное расстройство','name_en'=>'Obsessive-Compulsive Disorder','sort_order'=>5],
            ['department_id'=>7,'name_uz'=>'Panik buzilishi','name_ru'=>'Паническое расстройство','name_en'=>'Panic Disorder','sort_order'=>6],
            ['department_id'=>7,'name_uz'=>'Uyqusizlik','name_ru'=>'Бессонница','name_en'=>'Insomnia','sort_order'=>7],
            ['department_id'=>7,'name_uz'=>'Posttravmatik stress buzilishi','name_ru'=>'Посттравматическое стрессовое расстройство','name_en'=>'Post-Traumatic Stress Disorder','sort_order'=>8],
        
        ];

        foreach($diseases as $disease) {
            DepartmentDisease::create($disease);
        }
    }
}
