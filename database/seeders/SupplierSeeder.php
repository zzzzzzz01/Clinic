<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        Supplier::create(['name_uz' => 'MedPharm MCHJ', 'name_ru' => 'МедФарм ООО', 'name_en' => 'MedPharm Ltd.', 'type_uz' => 'Ishlab chiqaruvchi', 'type_ru' => 'Производитель', 'type_en' => 'Manufacturer', 'phone' => '+998901234567', 'email' => 'info@medpharm.uz', 'address' => 'Toshkent, Olmazor tumani, Ko\'cha 12', 'contact_person' => 'Ali Karimov', 'description_uz' => 'Asosiy dorilar ishlab chiqaruvchi', 'description_ru' => 'Основной производитель лекарств', 'description_en' => 'Main pharmaceutical manufacturer', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'BioTech Korporatsiyasi', 'name_ru' => 'БиоТех Корпорация', 'name_en' => 'BioTech Corp.', 'type_uz' => 'Importyor', 'type_ru' => 'Импортёр', 'type_en' => 'Importer', 'phone' => '+998909876543', 'email' => 'contact@biotech.uz', 'address' => 'Toshkent, Yunusobod tumani, Ko\'cha 5', 'contact_person' => 'Sardor Tursunov', 'description_uz' => 'Import qiluvchi kompaniya', 'description_ru' => 'Компания-импортёр', 'description_en' => 'Import company', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'PharmaPlus', 'name_ru' => 'ФармаПлюс', 'name_en' => 'PharmaPlus', 'type_uz' => 'Dorixona', 'type_ru' => 'Аптека', 'type_en' => 'Pharmacy', 'phone' => '+998901112233', 'email' => 'support@pharmaplus.uz', 'address' => 'Samarqand, Registon ko\'chasi 10', 'contact_person' => 'Gulnora Rajabova', 'description_uz' => 'Dorixonalar bilan ishlaydi', 'description_ru' => 'Работает с аптеками', 'description_en' => 'Works with pharmacies', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'HealthLine', 'name_ru' => 'ХелсЛайн', 'name_en' => 'HealthLine', 'type_uz' => 'Ishlab chiqaruvchi', 'type_ru' => 'Производитель', 'type_en' => 'Manufacturer', 'phone' => '+998907654321', 'email' => 'info@healthline.uz', 'address' => 'Farg\'ona, Markaziy ko\'cha 8', 'contact_person' => 'Jasur Saidov', 'description_uz' => 'Yuqori sifatli dorilar ishlab chiqaradi', 'description_ru' => 'Производит качественные лекарства', 'description_en' => 'Produces high-quality medicines', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'MediImport', 'name_ru' => 'МедиИмпорт', 'name_en' => 'MediImport', 'type_uz' => 'Importyor', 'type_ru' => 'Импортёр', 'type_en' => 'Importer', 'phone' => '+998903334455', 'email' => 'sales@mediimport.uz', 'address' => 'Andijon, Shaxri ko\'cha 3', 'contact_person' => 'Malika Azimova', 'description_uz' => 'Xorijdan dorilar import qiladi', 'description_ru' => 'Импортирует лекарства из-за рубежа', 'description_en' => 'Imports medicines from abroad', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'NovoPharm', 'name_ru' => 'НовоФарм', 'name_en' => 'NovoPharm', 'type_uz' => 'Ishlab chiqaruvchi', 'type_ru' => 'Производитель', 'type_en' => 'Manufacturer', 'phone' => '+998905556677', 'email' => 'info@novopharm.uz', 'address' => 'Buxoro, Ipak yo\'li ko\'chasi 15', 'contact_person' => 'Rustam Xamidov', 'description_uz' => 'Zamonaviy dorilar ishlab chiqaradi', 'description_ru' => 'Производит современные лекарства', 'description_en' => 'Produces modern medicines', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'GlobalMed', 'name_ru' => 'ГлобалМед', 'name_en' => 'GlobalMed', 'type_uz' => 'Importyor', 'type_ru' => 'Импортёр', 'type_en' => 'Importer', 'phone' => '+998907778899', 'email' => 'info@globalmed.uz', 'address' => 'Toshkent, Mirobod tumani, Ko\'cha 7', 'contact_person' => 'Dilnoza Raximova', 'description_uz' => 'Yevropadan dorilar importi', 'description_ru' => 'Импорт лекарств из Европы', 'description_en' => 'Medicine import from Europe', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'PharmaVita', 'name_ru' => 'ФармаВита', 'name_en' => 'PharmaVita', 'type_uz' => 'Dorixona', 'type_ru' => 'Аптека', 'type_en' => 'Pharmacy', 'phone' => '+998901223344', 'email' => 'info@pharmavita.uz', 'address' => 'Qashqadaryo, Qarshi shahri', 'contact_person' => 'Zuhra Shodmonova', 'description_uz' => 'Dorixona tarmog\'i', 'description_ru' => 'Сеть аптек', 'description_en' => 'Pharmacy chain', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'MedTech', 'name_ru' => 'МедТех', 'name_en' => 'MedTech', 'type_uz' => 'Ishlab chiqaruvchi', 'type_ru' => 'Производитель', 'type_en' => 'Manufacturer', 'phone' => '+998902223344', 'email' => 'info@medtech.uz', 'address' => 'Namangan, Chust ko\'chasi 20', 'contact_person' => 'Bobur Aliyev', 'description_uz' => 'Tibbiyot texnikasi va dorilar', 'description_ru' => 'Медицинская техника и лекарства', 'description_en' => 'Medical equipment and medicines', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'EuroPharm', 'name_ru' => 'ЕвроФарм', 'name_en' => 'EuroPharm', 'type_uz' => 'Importyor', 'type_ru' => 'Импортёр', 'type_en' => 'Importer', 'phone' => '+998903334455', 'email' => 'info@europharm.uz', 'address' => 'Toshkent, Shayxontohur tumani', 'contact_person' => 'Otabek Sultonov', 'description_uz' => 'Yevropa dorilari importi', 'description_ru' => 'Импорт европейских лекарств', 'description_en' => 'European medicines import', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'PharmaGroup', 'name_ru' => 'ФармаГрупп', 'name_en' => 'PharmaGroup', 'type_uz' => 'Ishlab chiqaruvchi', 'type_ru' => 'Производитель', 'type_en' => 'Manufacturer', 'phone' => '+998904445566', 'email' => 'info@pharmagroup.uz', 'address' => 'Sirdaryo, Guliston shahri', 'contact_person' => 'Nodir Xolmatov', 'description_uz' => 'Dorilar ishlab chiqarish', 'description_ru' => 'Производство лекарств', 'description_en' => 'Medicine manufacturing', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'AsiaMed', 'name_ru' => 'АзияМед', 'name_en' => 'AsiaMed', 'type_uz' => 'Importyor', 'type_ru' => 'Импортёр', 'type_en' => 'Importer', 'phone' => '+998905556677', 'email' => 'info@asiamed.uz', 'address' => 'Toshkent, Sergeli tumani', 'contact_person' => 'Nargiza Ergasheva', 'description_uz' => 'Osiyodan dorilar importi', 'description_ru' => 'Импорт лекарств из Азии', 'description_en' => 'Medicine import from Asia', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'Farmakon MCHJ', 'name_ru' => 'Фармакон ООО', 'name_en' => 'Farmakon Ltd.', 'type_uz' => 'Dorixona', 'type_ru' => 'Аптека', 'type_en' => 'Pharmacy', 'phone' => '+998906667788', 'email' => 'info@farmakon.uz', 'address' => 'Xorazm, Urganch shahri', 'contact_person' => 'Jamila Yusupova', 'description_uz' => 'Dorixonalar tarmog\'i', 'description_ru' => 'Сеть аптек', 'description_en' => 'Pharmacy chain', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'MedPharmGroup', 'name_ru' => 'МедФармГрупп', 'name_en' => 'MedPharmGroup', 'type_uz' => 'Ishlab chiqaruvchi', 'type_ru' => 'Производитель', 'type_en' => 'Manufacturer', 'phone' => '+998907778899', 'email' => 'info@medpharmgroup.uz', 'address' => 'Jizzax, Do\'stlik ko\'chasi 5', 'contact_person' => 'Muhammad Ali', 'description_uz' => 'Dorilar va tibbiyot buyumlari', 'description_ru' => 'Лекарства и медицинские изделия', 'description_en' => 'Medicines and medical supplies', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);

        Supplier::create(['name_uz' => 'UzPharma', 'name_ru' => 'УзФарма', 'name_en' => 'UzPharma', 'type_uz' => 'Importyor', 'type_ru' => 'Импортёр', 'type_en' => 'Importer', 'phone' => '+998908889900', 'email' => 'info@uzpharma.uz', 'address' => 'Toshkent, Yakkasaroy tumani', 'contact_person' => 'Shahnoza Nazarova', 'description_uz' => 'O\'zbekiston farmatsevtika importi', 'description_ru' => 'Фармацевтический импорт Узбекистана', 'description_en' => 'Uzbekistan pharmaceutical import', 'is_active' => true, 'created_at' => $now, 'updated_at' => $now]);
    }
}