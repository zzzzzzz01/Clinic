<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::create(['name_uz' => 'Kardiologiya', 'name_ru' => 'Кардиология', 'name_en' => 'Cardiology', 'slug' => 'cardiology', 'floor' => '2', 'description_uz' => 'Ushbu bo\'lim yurak bilan bog\'liq kasalliklarga ixtisoslashgan.', 'description_ru' => 'Это отделение специализируется на заболеваниях, связанных с сердцем.', 'description_en' => 'This department specializes in heart-related diseases.', 'status' => '1', 'photo' => 'imageDepartment/cardeology.jpeg']);

        Department::create(['name_uz' => 'Nevrologiya', 'name_ru' => 'Неврология', 'name_en' => 'Neurology', 'slug' => 'neurology', 'floor' => '1', 'description_uz' => 'Nevrologik kasalliklarni o\'rganish, tashxisi va davolash usullarini o\'rgatishga qaratilgan.', 'description_ru' => 'Учебное заведение, направленное на изучение неврологических заболеваний.', 'description_en' => 'An educational institution aimed at studying neurological diseases.', 'status' => '1', 'photo' => 'imageDepartment/nevrology.jpg']);

        Department::create(['name_uz' => 'Endokrinologiya', 'name_ru' => 'Эндокринология', 'name_en' => 'Endocrinology', 'slug' => 'endocrinology', 'floor' => '2', 'description_uz' => 'Gormonlar va endokrin tizim bilan bog\'liq kasalliklarni o\'rganishga ixtisoslashgan.', 'description_ru' => 'Отделение, специализирующееся на изучении заболеваний, связанных с гормонами.', 'description_en' => 'A department specializing in the study of diseases related to hormones.', 'status' => '1', 'photo' => 'imageDepartment/Endocrinology.jpg']);

        Department::create(['name_uz' => 'Oftalmologiya', 'name_ru' => 'Офтальмология', 'name_en' => 'Ophthalmology', 'slug' => 'ophthalmology', 'floor' => '1', 'description_uz' => 'Ko\'z va ko\'rish bilan bog\'liq kasalliklarni o\'rganishga qaratilgan.', 'description_ru' => 'Отделение, направленное на изучение заболеваний, связанных со зрением.', 'description_en' => 'A department focused on the study of vision and eye-related diseases.', 'status' => '1', 'photo' => 'imageDepartment/Ophthalmology.jpg']);

        Department::create(['name_uz' => 'Otorinolaringologiya', 'name_ru' => 'Оториноларингология', 'name_en' => 'Otorhinolaryngology', 'slug' => 'otorhinolaryngology', 'floor' => '3', 'description_uz' => 'Quloq, burun va tomoq bilan bog\'liq muammolarni o\'rganishga ixtisoslashgan.', 'description_ru' => 'Отделение, специализирующееся на изучении проблем, связанных с ухом, горлом и носом.', 'description_en' => 'A department specializing in the study of ear, nose, and throat-related problems.', 'status' => '1', 'photo' => 'imageDepartment/Otorhinolaryngology.jpg']);

        Department::create(['name_uz' => 'Pediatriya', 'name_ru' => 'Педиатрия', 'name_en' => 'Pediatrics', 'slug' => 'pediatrics', 'floor' => '4', 'description_uz' => 'Bolalar va o\'smirlarning sog\'ligi bilan bog\'liq kasalliklarni o\'rganishga qaratilgan.', 'description_ru' => 'Ориентировано на изучение заболеваний, связанных со здоровьем детей.', 'description_en' => 'Focused on the study of diseases related to the health of children.', 'status' => '1', 'photo' => 'imageDepartment/Pediatrics.jpg']);

        Department::create(['name_uz' => 'Psixiatriya', 'name_ru' => 'Психиатрия', 'name_en' => 'Psychiatry', 'slug' => 'psychiatry', 'floor' => '2', 'description_uz' => 'Ruhiy salomatlik va psixologik kasalliklarni davolashga bag\'ishlangan.', 'description_ru' => 'Отделение, посвященное психическому здоровью и психологическим заболеваниям.', 'description_en' => 'A department dedicated to mental health and psychological disorders.', 'status' => '1', 'photo' => 'imageDepartment/Psychiatry.jpg']);

        Department::create(['name_uz' => 'Akusherlik va Ginekologiya', 'name_ru' => 'Акушерство и Гинекология', 'name_en' => 'Obstetrics and Gynecology', 'slug' => 'obstetrics-gynecology', 'floor' => '3', 'description_uz' => 'Homiladorlik, tug\'ruq va ayollar kasalliklariga ixtisoslashgan.', 'description_ru' => 'Специализируется на беременности, родах и женских заболеваниях.', 'description_en' => 'Specializes in pregnancy, childbirth, and women\'s diseases.', 'status' => '1', 'photo' => 'imageDepartment/obstetrics.jpg']);

        Department::create(['name_uz' => 'Urologiya', 'name_ru' => 'Урология', 'name_en' => 'Urology', 'slug' => 'urology', 'floor' => '3', 'description_uz' => 'Siydik tizimi va erkak kasalliklariga ixtisoslashgan.', 'description_ru' => 'Специализируется на заболеваниях мочевой системы и мужских болезнях.', 'description_en' => 'Specializes in urinary system and male diseases.', 'status' => '1', 'photo' => 'imageDepartment/urology.jpg']);

        Department::create(['name_uz' => 'Ortopediya', 'name_ru' => 'Ортопедия', 'name_en' => 'Orthopedics', 'slug' => 'orthopedics', 'floor' => '2', 'description_uz' => 'Suyak, bo\'g\'im va mushak tizimi kasalliklariga ixtisoslashgan.', 'description_ru' => 'Специализируется на заболеваниях костей, суставов и мышц.', 'description_en' => 'Specializes in bone, joint, and muscle system diseases.', 'status' => '1', 'photo' => 'imageDepartment/orthopedics.jpg']);

        Department::create(['name_uz' => 'Dermatologiya', 'name_ru' => 'Дерматология', 'name_en' => 'Dermatology', 'slug' => 'dermatology', 'floor' => '1', 'description_uz' => 'Teri, soch va tirnoq kasalliklariga ixtisoslashgan.', 'description_ru' => 'Специализируется на заболеваниях кожи, волос и ногтей.', 'description_en' => 'Specializes in skin, hair, and nail diseases.', 'status' => '1', 'photo' => 'imageDepartment/dermatology.jpg']);

        Department::create(['name_uz' => 'Gastroenterologiya', 'name_ru' => 'Гастроэнтерология', 'name_en' => 'Gastroenterology', 'slug' => 'gastroenterology', 'floor' => '2', 'description_uz' => 'Oshqozon-ichak tizimi kasalliklariga ixtisoslashgan.', 'description_ru' => 'Специализируется на заболеваниях желудочно-кишечного тракта.', 'description_en' => 'Specializes in gastrointestinal tract diseases.', 'status' => '1', 'photo' => 'imageDepartment/gastroenterology.jpg']);

        Department::create(['name_uz' => 'Pulmonologiya', 'name_ru' => 'Пульмонология', 'name_en' => 'Pulmonology', 'slug' => 'pulmonology', 'floor' => '3', 'description_uz' => 'Nafas olish tizimi kasalliklariga ixtisoslashgan.', 'description_ru' => 'Специализируется на заболеваниях дыхательной системы.', 'description_en' => 'Specializes in respiratory system diseases.', 'status' => '1', 'photo' => 'imageDepartment/pulmonology.jpg']);

        Department::create(['name_uz' => 'Nefrologiya', 'name_ru' => 'Нефрология', 'name_en' => 'Nephrology', 'slug' => 'nephrology', 'floor' => '3', 'description_uz' => 'Buyrak kasalliklariga ixtisoslashgan.', 'description_ru' => 'Специализируется на заболеваниях почек.', 'description_en' => 'Specializes in kidney diseases.', 'status' => '1', 'photo' => 'imageDepartment/nephrology.jpg']);

        Department::create(['name_uz' => 'Onkologiya', 'name_ru' => 'Онкология', 'name_en' => 'Oncology', 'slug' => 'oncology', 'floor' => '4', 'description_uz' => 'Saraton va o\'smalar kasalliklariga ixtisoslashgan.', 'description_ru' => 'Специализируется на раке и опухолевых заболеваниях.', 'description_en' => 'Specializes in cancer and tumor diseases.', 'status' => '1', 'photo' => 'imageDepartment/oncology.jpg']);
    }
}