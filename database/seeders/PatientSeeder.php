<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class PatientSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('uz_UZ');

        // O'zbekcha ismlar
        $firstNames = [
            'Ali', 'Vali', 'Gani', 'Hasan', 'Husan', 'Karim', 'Rahim', 'Jahon', 'Doniyor', 'Shavkat',
            'Olim', 'Sobir', 'Zokir', 'Temur', 'Sardor', 'Bobur', 'Aziz', 'Nodir', 'Firdavs', 'Shoxruh',
            'Javlon', 'Doston', 'Eldor', 'Ozod', 'Umid', 'Sanjar', 'Sunnat', 'Komil', 'Abdulla', 'Murod',
            'Anvar', 'Botir', 'Gulom', 'Davron', 'Eshmat', 'Jalol', 'Xusniddin', 'Islom', 'Kamil', 'Laziz',
            'Mansur', 'Nasim', 'Otabek', 'Pulat', 'Qobil', 'Ravshan', 'Siroj', 'Tolib', 'Ulugbek', 'Voxid',
            'Xolmat', 'Yusuf', 'Zayniddin', 'Abror', 'Bahodir', 'Gayrat', 'Dilshod', 'Elyor', 'Farhod', 'G\'ulom',
            'Hikmat', 'Ilhom', 'Jasur', 'Kamol', 'Latif', 'Muhammad', 'Naim', 'Obid', 'Parda', 'Qahramon',
            'Rustam', 'Sulton', 'Toir', 'Ubaydullo', 'Vafo', 'Xabib', 'Yoqub', 'Zohid', 'Abdurahmon', 'Bekzod',
            'G\'ofur', 'Dilmurod', 'Erkin', 'Fozil', 'Gulmirza', 'Habibullo', 'Ikrom', 'Jumaboy', 'Kutbiddin', 'Mannon',
            'Nusrat', 'O\'ktam', 'Po\'lot', 'Qudrat', 'Rashid', 'Sohib', 'Turgun', 'Ural', 'Vosit', 'Xojiakbar'
        ];

        // O'zbekcha familiyalar
        $lastNames = [
            'Karimov', 'Rasulov', 'Ergashev', 'Boboev', 'Jalilov', 'Hakimov', 'Rustamov', 'Aliev', 'Ahmedov', 'Murodov',
            'Sultonov', 'Hamidov', 'Muxammedov', 'Bobojonov', 'Xolmatov', 'Olimov', 'Ismoilov', 'Hasanov', 'Sadirov', 'Raximov',
            'Toshmatov', 'Karimov', 'Rasulov', 'Muxammedov', 'Ismoilov', 'Hakimov', 'Rustamov', 'Aliev', 'Ahmedov', 'Boboev',
            'Jalilov', 'Ergashev', 'Sultonov', 'Hamidov', 'Bobojonov', 'Xolmatov', 'Olimov', 'Hasanov', 'Raximov', 'Murodov'
        ];

        // Shaharlar
        $cities = [
            'Toshkent shahar', 'Samarqand shahar', 'Buxoro shahar', 'Farg\'ona shahar', 'Andijon shahar',
            'Qashqadaryo shahar', 'Surxondaryo shahar', 'Sirdaryo shahar', 'Xorazm shahar', 'Navoiy shahar',
            'Jizzax shahar', 'Namangan shahar'
        ];

        // Tumanlar
        $districts = [
            'Chilonzor tumani', 'Mirzo Ulug\'bek tumani', 'Yakkasaroy tumani', 'Uchtepa tumani', 'Yunusobod tumani',
            'Sergeli tumani', 'Bektemir tumani', 'Olmazor tumani', 'Mirobod tumani', 'Shayxontohur tumani',
            'Yashnobod tumani', 'Registon tumani', 'Shofirkon tumani', 'Marg\'ilon tumani'
        ];

        $login = 440231105000;

        for ($i = 0; $i < 500; $i++) {
            $firstName = $faker->randomElement($firstNames);
            $middleName = $faker->randomElement($firstNames);
            $lastName = $faker->randomElement($lastNames);
            $city = $faker->randomElement($cities);
            $district = $faker->randomElement($districts);
            $street = rand(1, 50) . '-mavze, ' . rand(1, 50) . '-uy';

            $gender = $faker->randomElement(['male', 'female']);
            $genderUz = $gender == 'male' ? 'erkak' : 'ayol';

            $user = User::create([
                'name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'login' => (string)$login,
                'email' => strtolower($firstName . '.' . $lastName . rand(1, 999) . '@gmail.com'),
                'phone' => '+998' . rand(90, 99) . rand(1000000, 9999999),
                'password' => Hash::make('secret'),
                'is_active' => 1,
            ]);

            $user->roles()->attach(3);

            Patient::create([
                'user_id' => $user->id,
                'birth_date' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
                'gender' => $gender,
                'address' => $city . ', ' . $district . ', ' . $street,
                'passport_series' => $faker->randomElement(['AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK']),
                'passport_number' => rand(1000000, 9999999),
            ]);

            $login++;
        }
    }
}