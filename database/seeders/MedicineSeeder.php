<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        Medicine::create(['name' => 'Paracetamol', 'medicine_category_id' => 1, 'form' => 'Tabletka', 'package_type' => 'Quti', 'strength_value' => 500, 'strength_unit' => 'mg', 'units_per_box' => 20, 'stock_boxes' => 1, 'stock_units' => 20, 'min_stock' => 5, 'price' => 15, 'supplier_id' => 1, 'description_uz' => 'Og\'riq va isitma tushiruvchi', 'description_ru' => 'Обезболивающее и жаропонижающее', 'description_en' => 'Pain reliever and antipyretic']);

        Medicine::create(['name' => 'Amoksitsillin', 'medicine_category_id' => 2, 'form' => 'Kapsula', 'package_type' => 'Quti', 'strength_value' => 500, 'strength_unit' => 'mg', 'units_per_box' => 16, 'stock_boxes' => 5, 'stock_units' => 80, 'min_stock' => 3, 'price' => 42, 'supplier_id' => 2, 'description_uz' => 'Antibiotik', 'description_ru' => 'Антибиотик', 'description_en' => 'Antibiotic']);

        Medicine::create(['name' => 'Ceftriaxone', 'medicine_category_id' => 9, 'form' => 'Inyeksiya', 'package_type' => 'Flakon', 'strength_value' => 1, 'strength_unit' => 'g', 'units_per_box' => 1, 'stock_boxes' => 20, 'stock_units' => 20, 'min_stock' => 5, 'price' => 25, 'supplier_id' => 3, 'description_uz' => 'Inyeksiya uchun antibiotik', 'description_ru' => 'Антибиотик для инъекций', 'description_en' => 'Antibiotic for injection']);

        Medicine::create(['name' => 'Ambroksol Sirop', 'medicine_category_id' => 10, 'form' => 'Sirop', 'package_type' => 'Shisha', 'strength_value' => 30, 'strength_unit' => 'mg/5ml', 'units_per_box' => 1, 'stock_boxes' => 10, 'stock_units' => 10, 'min_stock' => 3, 'price' => 35, 'supplier_id' => 4, 'description_uz' => 'Yo\'tal uchun sirop', 'description_ru' => 'Сироп от кашля', 'description_en' => 'Cough syrup']);

        Medicine::create(['name' => 'Diklofenak Gel', 'medicine_category_id' => 1, 'form' => 'Malham', 'package_type' => 'Tubik', 'strength_value' => 1, 'strength_unit' => '%', 'units_per_box' => 1, 'stock_boxes' => 8, 'stock_units' => 8, 'min_stock' => 3, 'price' => 28, 'supplier_id' => 5, 'description_uz' => 'Og\'riq qoldiruvchi malham', 'description_ru' => 'Обезболивающая мазь', 'description_en' => 'Pain relief ointment']);

        Medicine::create(['name' => 'Sofradex Tomchilar', 'medicine_category_id' => 11, 'form' => 'Tomchilar', 'package_type' => 'Vial', 'strength_value' => 5, 'strength_unit' => 'ml', 'units_per_box' => 1, 'stock_boxes' => 6, 'stock_units' => 6, 'min_stock' => 2, 'price' => 45, 'supplier_id' => 6, 'description_uz' => 'Quloq va ko\'z tomchilari', 'description_ru' => 'Ушные и глазные капли', 'description_en' => 'Ear and eye drops']);

        Medicine::create(['name' => 'Salbutamol Aerozol', 'medicine_category_id' => 12, 'form' => 'Aerozol', 'package_type' => 'Ballon', 'strength_value' => 100, 'strength_unit' => 'mcg/dose', 'units_per_box' => 1, 'stock_boxes' => 5, 'stock_units' => 5, 'min_stock' => 2, 'price' => 55, 'supplier_id' => 7, 'description_uz' => 'Astma uchun aerozol', 'description_ru' => 'Аэрозоль от астмы', 'description_en' => 'Asthma aerosol']);

        Medicine::create(['name' => 'Azitromitsin', 'medicine_category_id' => 2, 'form' => 'Tabletka', 'package_type' => 'Quti', 'strength_value' => 250, 'strength_unit' => 'mg', 'units_per_box' => 6, 'stock_boxes' => 10, 'stock_units' => 60, 'min_stock' => 2, 'price' => 55, 'supplier_id' => 8, 'description_uz' => 'Antibiotik', 'description_ru' => 'Антибиотик', 'description_en' => 'Antibiotic']);

        Medicine::create(['name' => 'Vitamin C Drage', 'medicine_category_id' => 3, 'form' => 'Drage', 'package_type' => 'Bank', 'strength_value' => 100, 'strength_unit' => 'mg', 'units_per_box' => 30, 'stock_boxes' => 7, 'stock_units' => 210, 'min_stock' => 4, 'price' => 12, 'supplier_id' => 9, 'description_uz' => 'Vitamin C', 'description_ru' => 'Витамин С', 'description_en' => 'Vitamin C']);

        Medicine::create(['name' => 'No-Spa', 'medicine_category_id' => 1, 'form' => 'Tabletka', 'package_type' => 'Quti', 'strength_value' => 40, 'strength_unit' => 'mg', 'units_per_box' => 24, 'stock_boxes' => 0, 'stock_units' => 0, 'min_stock' => 3, 'price' => 30, 'supplier_id' => 10, 'description_uz' => 'Spazmga qarshi', 'description_ru' => 'Спазмолитик', 'description_en' => 'Antispasmodic']);

        Medicine::create(['name' => 'Omeprazol', 'medicine_category_id' => 6, 'form' => 'Kapsula', 'package_type' => 'Quti', 'strength_value' => 20, 'strength_unit' => 'mg', 'units_per_box' => 14, 'stock_boxes' => 2, 'stock_units' => 28, 'min_stock' => 3, 'price' => 28, 'supplier_id' => 11, 'description_uz' => 'Oshqozon kislotasini kamaytiradi', 'description_ru' => 'Снижает кислотность', 'description_en' => 'Reduces stomach acid']);

        Medicine::create(['name' => 'Lidokain Inyeksiya', 'medicine_category_id' => 9, 'form' => 'Inyeksiya', 'package_type' => 'Ampula', 'strength_value' => 2, 'strength_unit' => '%', 'units_per_box' => 10, 'stock_boxes' => 5, 'stock_units' => 50, 'min_stock' => 3, 'price' => 18, 'supplier_id' => 12, 'description_uz' => 'Og\'riq qoldiruvchi inyeksiya', 'description_ru' => 'Обезболивающая инъекция', 'description_en' => 'Pain relief injection']);

        Medicine::create(['name' => 'Nurofen Sirop', 'medicine_category_id' => 1, 'form' => 'Sirop', 'package_type' => 'Shisha', 'strength_value' => 100, 'strength_unit' => 'mg/5ml', 'units_per_box' => 1, 'stock_boxes' => 6, 'stock_units' => 6, 'min_stock' => 2, 'price' => 48, 'supplier_id' => 13, 'description_uz' => 'Bolalar uchun og\'riq qoldiruvchi', 'description_ru' => 'Детское обезболивающее', 'description_en' => 'Children pain reliever']);

        Medicine::create(['name' => 'Triderm Malham', 'medicine_category_id' => 13, 'form' => 'Malham', 'package_type' => 'Tubik', 'strength_value' => 15, 'strength_unit' => 'g', 'units_per_box' => 1, 'stock_boxes' => 4, 'stock_units' => 4, 'min_stock' => 2, 'price' => 65, 'supplier_id' => 14, 'description_uz' => 'Teri uchun malham', 'description_ru' => 'Мазь для кожи', 'description_en' => 'Skin ointment']);

        Medicine::create(['name' => 'Enalapril', 'medicine_category_id' => 7, 'form' => 'Tabletka', 'package_type' => 'Quti', 'strength_value' => 10, 'strength_unit' => 'mg', 'units_per_box' => 20, 'stock_boxes' => 5, 'stock_units' => 100, 'min_stock' => 3, 'price' => 20, 'supplier_id' => 15, 'description_uz' => 'Qon bosimini tushiradi', 'description_ru' => 'Снижает давление', 'description_en' => 'Lowers blood pressure']);

        Medicine::create(['name' => 'Albucid Tomchilar', 'medicine_category_id' => 11, 'form' => 'Tomchilar', 'package_type' => 'Vial', 'strength_value' => 20, 'strength_unit' => '%', 'units_per_box' => 1, 'stock_boxes' => 8, 'stock_units' => 8, 'min_stock' => 3, 'price' => 12, 'supplier_id' => 1, 'description_uz' => 'Ko\'z tomchilari', 'description_ru' => 'Глазные капли', 'description_en' => 'Eye drops']);

        Medicine::create(['name' => 'Ingalipt Aerozol', 'medicine_category_id' => 12, 'form' => 'Aerozol', 'package_type' => 'Ballon', 'strength_value' => 30, 'strength_unit' => 'ml', 'units_per_box' => 1, 'stock_boxes' => 7, 'stock_units' => 7, 'min_stock' => 3, 'price' => 22, 'supplier_id' => 2, 'description_uz' => 'Tomoq uchun aerozol', 'description_ru' => 'Аэрозоль для горла', 'description_en' => 'Throat spray']);

        Medicine::create(['name' => 'Doxycycline', 'medicine_category_id' => 2, 'form' => 'Kapsula', 'package_type' => 'Quti', 'strength_value' => 100, 'strength_unit' => 'mg', 'units_per_box' => 10, 'stock_boxes' => 5, 'stock_units' => 50, 'min_stock' => 2, 'price' => 45, 'supplier_id' => 3, 'description_uz' => 'Antibiotik', 'description_ru' => 'Антибиотик', 'description_en' => 'Antibiotic']);

        Medicine::create(['name' => 'Vaksina Gripp', 'medicine_category_id' => 9, 'form' => 'Inyeksiya', 'package_type' => 'Vial', 'strength_value' => 0.5, 'strength_unit' => 'ml', 'units_per_box' => 1, 'stock_boxes' => 3, 'stock_units' => 3, 'min_stock' => 1, 'price' => 120, 'supplier_id' => 4, 'description_uz' => 'Grippga qarshi vaksina', 'description_ru' => 'Вакцина от гриппа', 'description_en' => 'Flu vaccine']);

        Medicine::create(['name' => 'Metformin', 'medicine_category_id' => 5, 'form' => 'Tabletka', 'package_type' => 'Quti', 'strength_value' => 500, 'strength_unit' => 'mg', 'units_per_box' => 30, 'stock_boxes' => 4, 'stock_units' => 120, 'min_stock' => 3, 'price' => 35, 'supplier_id' => 5, 'description_uz' => 'Qandli diabet uchun', 'description_ru' => 'Для диабета', 'description_en' => 'For diabetes']);

        Medicine::create(['name' => 'Kaltsiy D3', 'medicine_category_id' => 3, 'form' => 'Drage', 'package_type' => 'Bank', 'strength_value' => 500, 'strength_unit' => 'mg', 'units_per_box' => 30, 'stock_boxes' => 5, 'stock_units' => 150, 'min_stock' => 3, 'price' => 20, 'supplier_id' => 6, 'description_uz' => 'Suyaklar uchun kaltsiy', 'description_ru' => 'Кальций для костей', 'description_en' => 'Calcium for bones']);

        Medicine::create(['name' => 'Gerbion Sirop', 'medicine_category_id' => 10, 'form' => 'Sirop', 'package_type' => 'Shisha', 'strength_value' => 5, 'strength_unit' => 'ml', 'units_per_box' => 1, 'stock_boxes' => 6, 'stock_units' => 6, 'min_stock' => 3, 'price' => 38, 'supplier_id' => 7, 'description_uz' => 'Yo\'tal siropi', 'description_ru' => 'Сироп от кашля', 'description_en' => 'Cough syrup']);

        Medicine::create(['name' => 'Bepanten Malham', 'medicine_category_id' => 13, 'form' => 'Malham', 'package_type' => 'Tubik', 'strength_value' => 5, 'strength_unit' => '%', 'units_per_box' => 1, 'stock_boxes' => 5, 'stock_units' => 5, 'min_stock' => 2, 'price' => 32, 'supplier_id' => 8, 'description_uz' => 'Teri uchun malham', 'description_ru' => 'Мазь для кожи', 'description_en' => 'Skin ointment']);

        Medicine::create(['name' => 'Nazivin Tomchilar', 'medicine_category_id' => 12, 'form' => 'Tomchilar', 'package_type' => 'Vial', 'strength_value' => 0.05, 'strength_unit' => '%', 'units_per_box' => 1, 'stock_boxes' => 8, 'stock_units' => 8, 'min_stock' => 3, 'price' => 18, 'supplier_id' => 9, 'description_uz' => 'Burun tomchilari', 'description_ru' => 'Капли в нос', 'description_en' => 'Nasal drops']);

        Medicine::create(['name' => 'Loratadin', 'medicine_category_id' => 4, 'form' => 'Tabletka', 'package_type' => 'Quti', 'strength_value' => 10, 'strength_unit' => 'mg', 'units_per_box' => 10, 'stock_boxes' => 6, 'stock_units' => 60, 'min_stock' => 3, 'price' => 16, 'supplier_id' => 10, 'description_uz' => 'Allergiyaga qarshi', 'description_ru' => 'Антигистамин', 'description_en' => 'Antihistamine']);

        Medicine::create(['name' => 'Diazepam Inyeksiya', 'medicine_category_id' => 14, 'form' => 'Inyeksiya', 'package_type' => 'Ampula', 'strength_value' => 10, 'strength_unit' => 'mg', 'units_per_box' => 5, 'stock_boxes' => 4, 'stock_units' => 20, 'min_stock' => 2, 'price' => 40, 'supplier_id' => 11, 'description_uz' => 'Tinchlantiruvchi inyeksiya', 'description_ru' => 'Успокаивающая инъекция', 'description_en' => 'Sedative injection']);

        Medicine::create(['name' => 'Vitamin E Kapsula', 'medicine_category_id' => 3, 'form' => 'Kapsula', 'package_type' => 'Quti', 'strength_value' => 400, 'strength_unit' => 'IU', 'units_per_box' => 30, 'stock_boxes' => 6, 'stock_units' => 180, 'min_stock' => 3, 'price' => 25, 'supplier_id' => 12, 'description_uz' => 'Vitamin E', 'description_ru' => 'Витамин Е', 'description_en' => 'Vitamin E']);

        Medicine::create(['name' => 'Cromogeksal Aerozol', 'medicine_category_id' => 12, 'form' => 'Aerozol', 'package_type' => 'Ballon', 'strength_value' => 2, 'strength_unit' => '%', 'units_per_box' => 1, 'stock_boxes' => 4, 'stock_units' => 4, 'min_stock' => 2, 'price' => 50, 'supplier_id' => 13, 'description_uz' => 'Allergiyaga qarshi aerozol', 'description_ru' => 'Противоаллергический аэрозоль', 'description_en' => 'Anti-allergy aerosol']);

        Medicine::create(['name' => 'Atorvastatin', 'medicine_category_id' => 8, 'form' => 'Tabletka', 'package_type' => 'Quti', 'strength_value' => 20, 'strength_unit' => 'mg', 'units_per_box' => 28, 'stock_boxes' => 3, 'stock_units' => 84, 'min_stock' => 2, 'price' => 48, 'supplier_id' => 14, 'description_uz' => 'Xolesterolni kamaytiradi', 'description_ru' => 'Снижает холестерин', 'description_en' => 'Lowers cholesterol']);

        Medicine::create(['name' => 'Pikovit Sirop', 'medicine_category_id' => 3, 'form' => 'Sirop', 'package_type' => 'Shisha', 'strength_value' => 100, 'strength_unit' => 'ml', 'units_per_box' => 1, 'stock_boxes' => 5, 'stock_units' => 5, 'min_stock' => 2, 'price' => 42, 'supplier_id' => 15, 'description_uz' => 'Bolalar uchun vitamin siropi', 'description_ru' => 'Витаминный сироп для детей', 'description_en' => 'Children vitamin syrup']);

        Medicine::create(['name' => 'Levomekol Malham', 'medicine_category_id' => 13, 'form' => 'Malham', 'package_type' => 'Tubik', 'strength_value' => 40, 'strength_unit' => 'g', 'units_per_box' => 1, 'stock_boxes' => 6, 'stock_units' => 6, 'min_stock' => 3, 'price' => 25, 'supplier_id' => 1, 'description_uz' => 'Yaralarni davolash uchun', 'description_ru' => 'Для лечения ран', 'description_en' => 'For wound healing']);

        Medicine::create(['name' => 'Otipaks Tomchilar', 'medicine_category_id' => 11, 'form' => 'Tomchilar', 'package_type' => 'Vial', 'strength_value' => 10, 'strength_unit' => 'ml', 'units_per_box' => 1, 'stock_boxes' => 5, 'stock_units' => 5, 'min_stock' => 2, 'price' => 35, 'supplier_id' => 2, 'description_uz' => 'Quloq tomchilari', 'description_ru' => 'Ушные капли', 'description_en' => 'Ear drops']);

        Medicine::create(['name' => 'Amlodipin', 'medicine_category_id' => 7, 'form' => 'Tabletka', 'package_type' => 'Quti', 'strength_value' => 5, 'strength_unit' => 'mg', 'units_per_box' => 30, 'stock_boxes' => 4, 'stock_units' => 120, 'min_stock' => 3, 'price' => 25, 'supplier_id' => 3, 'description_uz' => 'Qon bosimini tushiradi', 'description_ru' => 'Снижает давление', 'description_en' => 'Lowers blood pressure']);

        Medicine::create(['name' => 'Vitamin B12 Drage', 'medicine_category_id' => 3, 'form' => 'Drage', 'package_type' => 'Bank', 'strength_value' => 1000, 'strength_unit' => 'mcg', 'units_per_box' => 30, 'stock_boxes' => 5, 'stock_units' => 150, 'min_stock' => 3, 'price' => 22, 'supplier_id' => 4, 'description_uz' => 'Asab tizimi uchun', 'description_ru' => 'Для нервной системы', 'description_en' => 'For nervous system']);

        Medicine::create(['name' => 'Sodium Chloride', 'medicine_category_id' => 9, 'form' => 'Inyeksiya', 'package_type' => 'Flakon', 'strength_value' => 0.9, 'strength_unit' => '%', 'units_per_box' => 1, 'stock_boxes' => 15, 'stock_units' => 15, 'min_stock' => 5, 'price' => 8, 'supplier_id' => 5, 'description_uz' => 'Fiziologik eritma', 'description_ru' => 'Физраствор', 'description_en' => 'Saline solution']);
    }
}