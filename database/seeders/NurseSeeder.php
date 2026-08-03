<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseSeeder extends Seeder
{
    public function run(): void
    {
        $login = 440231102000;

        // 1
        $user = User::create(['name' => 'Dilnoza', 'middle_name' => 'Bahodirovna', 'last_name' => 'Karimova', 'login' => (string)$login, 'email' => 'd.karimova@gmail.com', 'phone' => '+998901112233', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1996-04-12', 'gender' => 'female', 'passport_series' => 'AB1234567', 'passport_number' => '12389045761234', 'address' => 'Toshkent shahri, Chilonzor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 4, 'hire_date' => '2020-03-15', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2018-06-30', 'department_id' => 1, 'room_number' => 201, 'bio' => 'Mas\'uliyatli va tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 2
        $user = User::create(['name' => 'Malika', 'middle_name' => 'Rustamovna', 'last_name' => 'Ismoilova', 'login' => (string)$login, 'email' => 'm.ismoilova@gmail.com', 'phone' => '+998902223344', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1998-07-21', 'gender' => 'female', 'passport_series' => 'AC2345678', 'passport_number' => '12389045761235', 'address' => 'Toshkent shahri, Yunusobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 3, 'hire_date' => '2021-05-10', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2020-06-30', 'department_id' => 2, 'room_number' => 205, 'bio' => 'Yosh va malakali hamshira.', 'status' => 'active']);
        $login++;

        // 3
        $user = User::create(['name' => 'Shahnoza', 'middle_name' => 'Anvarovna', 'last_name' => 'Tursunova', 'login' => (string)$login, 'email' => 's.tursunova@gmail.com', 'phone' => '+998903334455', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1995-01-30', 'gender' => 'female', 'passport_series' => 'AB3456789', 'passport_number' => '12389045761236', 'address' => 'Toshkent shahri, Mirobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 5, 'hire_date' => '2019-08-20', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2017-06-30', 'department_id' => 3, 'room_number' => 210, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 4
        $user = User::create(['name' => 'Nodira', 'middle_name' => 'Jasurovna', 'last_name' => 'Raxmatova', 'login' => (string)$login, 'email' => 'n.raxmatova@gmail.com', 'phone' => '+998904445566', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1997-11-18', 'gender' => 'female', 'passport_series' => 'AC4567890', 'passport_number' => '12389045761237', 'address' => 'Toshkent shahri, Olmazor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'Oliy', 'experience_years' => 4, 'hire_date' => '2020-11-01', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2019-06-30', 'department_id' => 4, 'room_number' => 215, 'bio' => 'Malakali hamshira.', 'status' => 'active']);
        $login++;

        // 5
        $user = User::create(['name' => 'Mohira', 'middle_name' => 'Otabekovna', 'last_name' => 'Abdullayeva', 'login' => (string)$login, 'email' => 'm.abdullayeva@gmail.com', 'phone' => '+998905556677', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1994-06-09', 'gender' => 'female', 'passport_series' => 'AB5678901', 'passport_number' => '12389045761238', 'address' => 'Toshkent shahri, Sergeli tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 7, 'hire_date' => '2017-02-15', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Master', 'graduation_date' => '2016-06-30', 'department_id' => 5, 'room_number' => 220, 'bio' => 'Yuqori malakali hamshira.', 'status' => 'active']);
        $login++;

        // 6
        $user = User::create(['name' => 'Aziza', 'middle_name' => 'Sardorovna', 'last_name' => 'Qodirova', 'login' => (string)$login, 'email' => 'a.qodirova@gmail.com', 'phone' => '+998906667788', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1999-09-25', 'gender' => 'female', 'passport_series' => 'AC6789012', 'passport_number' => '12389045761239', 'address' => 'Toshkent shahri, Yashnabad tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 2, 'hire_date' => '2022-06-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2021-06-30', 'department_id' => 6, 'room_number' => 225, 'bio' => 'Yosh va g\'ayratli hamshira.', 'status' => 'active']);
        $login++;

        // 7
        $user = User::create(['name' => 'Laylo', 'middle_name' => 'Bekzodovna', 'last_name' => 'Saidova', 'login' => (string)$login, 'email' => 'l.saidova@gmail.com', 'phone' => '+998907778899', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1993-03-14', 'gender' => 'female', 'passport_series' => 'AB7890123', 'passport_number' => '12389045761230', 'address' => 'Toshkent shahri, Yakkasaroy tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 8, 'hire_date' => '2016-09-10', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2014-06-30', 'department_id' => 7, 'room_number' => 230, 'bio' => 'Tajribali va ishonchli hamshira.', 'status' => 'active']);
        $login++;

        // 8
        $user = User::create(['name' => 'Zarina', 'middle_name' => 'Ulugbekovna', 'last_name' => 'Yusupova', 'login' => (string)$login, 'email' => 'z.yusupova@gmail.com', 'phone' => '+998908889900', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1996-12-02', 'gender' => 'female', 'passport_series' => 'AC8901234', 'passport_number' => '12389045761231', 'address' => 'Toshkent shahri, Shayxontohur tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 5, 'hire_date' => '2019-07-01', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2018-06-30', 'department_id' => 8, 'room_number' => 235, 'bio' => 'Malakali va mas\'uliyatli hamshira.', 'status' => 'active']);
        $login++;

        // 9
        $user = User::create(['name' => 'Feruza', 'middle_name' => 'Komilovna', 'last_name' => 'Hamidova', 'login' => (string)$login, 'email' => 'f.hamidova@gmail.com', 'phone' => '+998909990011', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1995-08-08', 'gender' => 'female', 'passport_series' => 'AB9012345', 'passport_number' => '12389045761232', 'address' => 'Toshkent shahri, Chilonzor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 6, 'hire_date' => '2018-04-15', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2016-06-30', 'department_id' => 9, 'room_number' => 240, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 10
        $user = User::create(['name' => 'Gulnoza', 'middle_name' => 'Shavkatovna', 'last_name' => 'Usmonova', 'login' => (string)$login, 'email' => 'g.usmonova@gmail.com', 'phone' => '+998931112233', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1997-05-19', 'gender' => 'female', 'passport_series' => 'AC0123456', 'passport_number' => '12389045761233', 'address' => 'Toshkent shahri, Mirzo Ulug\'bek tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 4, 'hire_date' => '2020-12-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2019-06-30', 'department_id' => 10, 'room_number' => 245, 'bio' => 'Mas\'uliyatli hamshira.', 'status' => 'active']);
        $login++;

        // 11
        $user = User::create(['name' => 'Asadbek', 'middle_name' => 'Azatovich', 'last_name' => 'Ataxanov', 'login' => (string)$login, 'email' => 'asadbek.ataxanov@gmail.com', 'phone' => '+998945556677', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1997-05-19', 'gender' => 'male', 'passport_series' => 'AC0123456', 'passport_number' => '12389045761244', 'address' => 'Toshkent shahri, Yunusobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 3, 'hire_date' => '2021-09-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2020-06-30', 'department_id' => 1, 'room_number' => 250, 'bio' => 'Yosh va malakali hamshira.', 'status' => 'active']);
        $login++;

        // 12
        $user = User::create(['name' => 'Maftuna', 'middle_name' => 'Rashidovna', 'last_name' => 'Xolmatova', 'login' => (string)$login, 'email' => 'maftuna.xolmatova@gmail.com', 'phone' => '+998901233445', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1998-10-12', 'gender' => 'female', 'passport_series' => 'AD1234567', 'passport_number' => '12389045761245', 'address' => 'Toshkent shahri, Olmazor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 4, 'hire_date' => '2020-06-15', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2019-06-30', 'department_id' => 2, 'room_number' => 255, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 13
        $user = User::create(['name' => 'Jasur', 'middle_name' => 'Xolmatovich', 'last_name' => 'Rahimov', 'login' => (string)$login, 'email' => 'jasur.rahimov@gmail.com', 'phone' => '+998902233556', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1996-02-14', 'gender' => 'male', 'passport_series' => 'AE2345678', 'passport_number' => '12389045761246', 'address' => 'Toshkent shahri, Mirobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 5, 'hire_date' => '2019-04-20', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2017-06-30', 'department_id' => 3, 'room_number' => 260, 'bio' => 'Mas\'uliyatli hamshira.', 'status' => 'active']);
        $login++;

        // 14
        $user = User::create(['name' => 'Sevara', 'middle_name' => 'Nodirovna', 'last_name' => 'Tolipova', 'login' => (string)$login, 'email' => 'sevara.tolipova@gmail.com', 'phone' => '+998903344567', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1999-07-08', 'gender' => 'female', 'passport_series' => 'AF3456789', 'passport_number' => '12389045761247', 'address' => 'Toshkent shahri, Sergeli tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 2, 'hire_date' => '2022-08-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2021-06-30', 'department_id' => 4, 'room_number' => 265, 'bio' => 'Yosh hamshira.', 'status' => 'active']);
        $login++;

        // 15
        $user = User::create(['name' => 'Sardor', 'middle_name' => 'Baxodirovich', 'last_name' => 'Mamatov', 'login' => (string)$login, 'email' => 'sardor.mamatov@gmail.com', 'phone' => '+998904456678', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1995-03-25', 'gender' => 'male', 'passport_series' => 'AG4567890', 'passport_number' => '12389045761248', 'address' => 'Toshkent shahri, Yashnabad tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 6, 'hire_date' => '2018-10-10', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2016-06-30', 'department_id' => 5, 'room_number' => 270, 'bio' => 'Malakali hamshira.', 'status' => 'active']);
        $login++;

        // 16
        $user = User::create(['name' => 'Nigora', 'middle_name' => 'Tolibovna', 'last_name' => 'Ahmedova', 'login' => (string)$login, 'email' => 'nigora.ahmedova@gmail.com', 'phone' => '+998905667788', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1992-08-03', 'gender' => 'female', 'passport_series' => 'AH5678901', 'passport_number' => '12389045761249', 'address' => 'Toshkent shahri, Chilonzor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 9, 'hire_date' => '2015-07-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2013-06-30', 'department_id' => 6, 'room_number' => 301, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 17
        $user = User::create(['name' => 'Bekzod', 'middle_name' => 'Shavkatovich', 'last_name' => 'Xasanov', 'login' => (string)$login, 'email' => 'bekzod.xasanov@gmail.com', 'phone' => '+998906778899', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1994-11-15', 'gender' => 'male', 'passport_series' => 'AI6789012', 'passport_number' => '12389045761250', 'address' => 'Toshkent shahri, Yunusobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 6, 'hire_date' => '2018-03-15', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2016-06-30', 'department_id' => 7, 'room_number' => 305, 'bio' => 'Mas\'uliyatli hamshira.', 'status' => 'active']);
        $login++;

        // 18
        $user = User::create(['name' => 'Dilafruz', 'middle_name' => 'Komilovna', 'last_name' => 'Sobirova', 'login' => (string)$login, 'email' => 'dilafruz.sobirova@gmail.com', 'phone' => '+998907889900', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1993-06-22', 'gender' => 'female', 'passport_series' => 'AJ7890123', 'passport_number' => '12389045761251', 'address' => 'Toshkent shahri, Olmazor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 7, 'hire_date' => '2017-05-20', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2015-06-30', 'department_id' => 8, 'room_number' => 310, 'bio' => 'Tajribali va bilimli hamshira.', 'status' => 'active']);
        $login++;

        // 19
        $user = User::create(['name' => 'Rustam', 'middle_name' => 'Anvarovich', 'last_name' => 'Toshmatov', 'login' => (string)$login, 'email' => 'rustam.toshmatov@gmail.com', 'phone' => '+998908990011', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1991-09-09', 'gender' => 'male', 'passport_series' => 'AK8901234', 'passport_number' => '12389045761252', 'address' => 'Toshkent shahri, Mirobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 10, 'hire_date' => '2014-08-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2012-06-30', 'department_id' => 9, 'room_number' => 315, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 20
        $user = User::create(['name' => 'Hilola', 'middle_name' => 'Baxodirovna', 'last_name' => 'Aliyeva', 'login' => (string)$login, 'email' => 'hilola.aliyeva@gmail.com', 'phone' => '+998909001122', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1997-12-18', 'gender' => 'female', 'passport_series' => 'AL9012345', 'passport_number' => '12389045761253', 'address' => 'Toshkent shahri, Yakkasaroy tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 3, 'hire_date' => '2021-10-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2020-06-30', 'department_id' => 10, 'room_number' => 320, 'bio' => 'Yosh hamshira.', 'status' => 'active']);
        $login++;

        // 21
        $user = User::create(['name' => 'Sarvar', 'middle_name' => 'Ismoilovich', 'last_name' => 'Muxammedov', 'login' => (string)$login, 'email' => 'sarvar.muxammedov@gmail.com', 'phone' => '+998901234567', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1995-04-10', 'gender' => 'male', 'passport_series' => 'AM0123456', 'passport_number' => '12389045761254', 'address' => 'Toshkent shahri, Sergeli tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 5, 'hire_date' => '2019-11-15', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2017-06-30', 'department_id' => 1, 'room_number' => 325, 'bio' => 'Malakali hamshira.', 'status' => 'active']);
        $login++;

        // 22
        $user = User::create(['name' => 'Gulandom', 'middle_name' => 'Rustamovna', 'last_name' => 'Xolmatova', 'login' => (string)$login, 'email' => 'gulandom.xolmatova@gmail.com', 'phone' => '+998902345678', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1998-02-28', 'gender' => 'female', 'passport_series' => 'AN1234567', 'passport_number' => '12389045761255', 'address' => 'Toshkent shahri, Yashnabad tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 3, 'hire_date' => '2021-02-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2020-06-30', 'department_id' => 2, 'room_number' => 330, 'bio' => 'G\'ayratli hamshira.', 'status' => 'active']);
        $login++;

        // 23
        $user = User::create(['name' => 'Islom', 'middle_name' => 'Tolibovich', 'last_name' => 'Sultonov', 'login' => (string)$login, 'email' => 'islom.sultonov@gmail.com', 'phone' => '+998903456789', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1993-07-05', 'gender' => 'male', 'passport_series' => 'AO2345678', 'passport_number' => '12389045761256', 'address' => 'Toshkent shahri, Shayxontohur tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 7, 'hire_date' => '2017-04-20', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2015-06-30', 'department_id' => 3, 'room_number' => 335, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 24
        $user = User::create(['name' => 'Munis', 'middle_name' => 'Zokirovna', 'last_name' => 'Qodirova', 'login' => (string)$login, 'email' => 'munis.qodirova@gmail.com', 'phone' => '+998904567890', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1996-10-08', 'gender' => 'female', 'passport_series' => 'AP3456789', 'passport_number' => '12389045761257', 'address' => 'Toshkent shahri, Mirobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'Oliy', 'experience_years' => 4, 'hire_date' => '2020-08-15', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2018-06-30', 'department_id' => 4, 'room_number' => 340, 'bio' => 'Bilimli hamshira.', 'status' => 'active']);
        $login++;

        // 25
        $user = User::create(['name' => 'Nodir', 'middle_name' => 'Alisherovich', 'last_name' => 'Raxmatullayev', 'login' => (string)$login, 'email' => 'nodir.raxmatullayev@gmail.com', 'phone' => '+998905678901', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1992-05-20', 'gender' => 'male', 'passport_series' => 'AQ4567890', 'passport_number' => '12389045761258', 'address' => 'Toshkent shahri, Olmazor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 8, 'hire_date' => '2016-06-10', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Master', 'graduation_date' => '2014-06-30', 'department_id' => 5, 'room_number' => 345, 'bio' => 'Yuqori malakali hamshira.', 'status' => 'active']);
        $login++;

        // 26
        $user = User::create(['name' => 'Zilola', 'middle_name' => 'Nematovna', 'last_name' => 'Tursunboyeva', 'login' => (string)$login, 'email' => 'zilola.tursunboyeva@gmail.com', 'phone' => '+998906789012', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1999-03-03', 'gender' => 'female', 'passport_series' => 'AR5678901', 'passport_number' => '12389045761259', 'address' => 'Toshkent shahri, Chilonzor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 2, 'hire_date' => '2022-09-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2021-06-30', 'department_id' => 6, 'room_number' => 401, 'bio' => 'Yosh hamshira.', 'status' => 'active']);
        $login++;

        // 27
        $user = User::create(['name' => 'Baxrom', 'middle_name' => 'Sultanovich', 'last_name' => 'Iskandarov', 'login' => (string)$login, 'email' => 'baxrom.iskandarov@gmail.com', 'phone' => '+998907890123', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1994-08-17', 'gender' => 'male', 'passport_series' => 'AS6789012', 'passport_number' => '12389045761260', 'address' => 'Toshkent shahri, Yunusobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 5, 'hire_date' => '2019-02-15', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2017-06-30', 'department_id' => 7, 'room_number' => 405, 'bio' => 'Mas\'uliyatli hamshira.', 'status' => 'active']);
        $login++;

        // 28
        $user = User::create(['name' => 'Rano', 'middle_name' => 'Erkinovna', 'last_name' => 'Muxtorova', 'login' => (string)$login, 'email' => 'rano.muxtorova@gmail.com', 'phone' => '+998908901234', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1995-11-28', 'gender' => 'female', 'passport_series' => 'AT7890123', 'passport_number' => '12389045761261', 'address' => 'Toshkent shahri, Yakkasaroy tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 6, 'hire_date' => '2018-09-01', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2016-06-30', 'department_id' => 8, 'room_number' => 410, 'bio' => 'Tajribali va malakali hamshira.', 'status' => 'active']);
        $login++;

        // 29
        $user = User::create(['name' => 'Shuhrat', 'middle_name' => 'Abdushukurovich', 'last_name' => 'Yusupov', 'login' => (string)$login, 'email' => 'shuhrat.yusupov@gmail.com', 'phone' => '+998909012345', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1991-12-01', 'gender' => 'male', 'passport_series' => 'AU8901234', 'passport_number' => '12389045761262', 'address' => 'Toshkent shahri, Sergeli tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 9, 'hire_date' => '2015-01-20', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2013-06-30', 'department_id' => 9, 'room_number' => 415, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 30
        $user = User::create(['name' => 'Dildora', 'middle_name' => 'Baxtiyorovna', 'last_name' => 'Usmanova', 'login' => (string)$login, 'email' => 'dildora.usmanova@gmail.com', 'phone' => '+998901123456', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1997-09-14', 'gender' => 'female', 'passport_series' => 'AV9012345', 'passport_number' => '12389045761263', 'address' => 'Toshkent shahri, Mirzo Ulug\'bek tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 3, 'hire_date' => '2021-04-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2020-06-30', 'department_id' => 10, 'room_number' => 420, 'bio' => 'Yosh va g\'ayratli hamshira.', 'status' => 'active']);
        $login++;

        // 31
        $user = User::create(['name' => 'Doston', 'middle_name' => 'Ermatovich', 'last_name' => 'Xamidov', 'login' => (string)$login, 'email' => 'doston.xamidov@gmail.com', 'phone' => '+998902234567', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1996-06-06', 'gender' => 'male', 'passport_series' => 'AW0123456', 'passport_number' => '12389045761264', 'address' => 'Toshkent shahri, Yashnabad tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 4, 'hire_date' => '2020-07-15', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2018-06-30', 'department_id' => 1, 'room_number' => 501, 'bio' => 'Mas\'uliyatli hamshira.', 'status' => 'active']);
        $login++;

        // 32
        $user = User::create(['name' => 'Gulbahor', 'middle_name' => 'Sobirovna', 'last_name' => 'Mirzayeva', 'login' => (string)$login, 'email' => 'gulbahor.mirzayeva@gmail.com', 'phone' => '+998903345678', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1994-04-22', 'gender' => 'female', 'passport_series' => 'AX1234567', 'passport_number' => '12389045761265', 'address' => 'Toshkent shahri, Chilonzor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 7, 'hire_date' => '2017-10-20', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2015-06-30', 'department_id' => 2, 'room_number' => 505, 'bio' => 'Malakali hamshira.', 'status' => 'active']);
        $login++;

        // 33
        $user = User::create(['name' => 'Jasmina', 'middle_name' => 'Raxmonovna', 'last_name' => 'Qosimova', 'login' => (string)$login, 'email' => 'jasmina.qosimova@gmail.com', 'phone' => '+998904456789', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1999-08-11', 'gender' => 'female', 'passport_series' => 'AY2345678', 'passport_number' => '12389045761266', 'address' => 'Toshkent shahri, Yunusobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 2, 'hire_date' => '2022-11-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2021-06-30', 'department_id' => 3, 'room_number' => 510, 'bio' => 'Yosh hamshira.', 'status' => 'active']);
        $login++;

        // 34
        $user = User::create(['name' => 'Said', 'middle_name' => 'Abdurahmonovich', 'last_name' => 'Nazarov', 'login' => (string)$login, 'email' => 'said.nazarov@gmail.com', 'phone' => '+998905567890', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1993-02-09', 'gender' => 'male', 'passport_series' => 'AZ3456789', 'passport_number' => '12389045761267', 'address' => 'Toshkent shahri, Olmazor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 8, 'hire_date' => '2016-05-20', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2014-06-30', 'department_id' => 4, 'room_number' => 515, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 35
        $user = User::create(['name' => 'Nargiza', 'middle_name' => 'Erkinovna', 'last_name' => 'Aliyeva', 'login' => (string)$login, 'email' => 'nargiza.aliyeva@gmail.com', 'phone' => '+998906678901', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1998-01-27', 'gender' => 'female', 'passport_series' => 'BA4567890', 'passport_number' => '12389045761268', 'address' => 'Toshkent shahri, Mirobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 3, 'hire_date' => '2021-07-01', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2020-06-30', 'department_id' => 5, 'room_number' => 520, 'bio' => 'Yosh va malakali hamshira.', 'status' => 'active']);
        $login++;

        // 36
        $user = User::create(['name' => 'Murod', 'middle_name' => 'Baxromovich', 'last_name' => 'Safarov', 'login' => (string)$login, 'email' => 'murod.safarov@gmail.com', 'phone' => '+998907789012', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1995-10-03', 'gender' => 'male', 'passport_series' => 'BB5678901', 'passport_number' => '12389045761269', 'address' => 'Toshkent shahri, Sergeli tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 5, 'hire_date' => '2019-06-15', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2017-06-30', 'department_id' => 6, 'room_number' => 601, 'bio' => 'Mas\'uliyatli hamshira.', 'status' => 'active']);
        $login++;

        // 37
        $user = User::create(['name' => 'Yulduz', 'middle_name' => 'Ulugbekovna', 'last_name' => 'Xodjiyeva', 'login' => (string)$login, 'email' => 'yulduz.xodjiyeva@gmail.com', 'phone' => '+998908890123', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1997-07-29', 'gender' => 'female', 'passport_series' => 'BC6789012', 'passport_number' => '12389045761270', 'address' => 'Toshkent shahri, Chilonzor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 3, 'hire_date' => '2021-12-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2020-06-30', 'department_id' => 7, 'room_number' => 605, 'bio' => 'G\'ayratli hamshira.', 'status' => 'active']);
        $login++;

        // 38
        $user = User::create(['name' => 'Abror', 'middle_name' => 'Abdurahimovich', 'last_name' => 'Xolmatov', 'login' => (string)$login, 'email' => 'abror.xolmatov@gmail.com', 'phone' => '+998909901234', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1992-12-12', 'gender' => 'male', 'passport_series' => 'BD7890123', 'passport_number' => '12389045761271', 'address' => 'Toshkent shahri, Olmazor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 8, 'hire_date' => '2016-03-10', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2014-06-30', 'department_id' => 8, 'room_number' => 610, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 39
        $user = User::create(['name' => 'Xurshid', 'middle_name' => 'Rustamovich', 'last_name' => 'Karimov', 'login' => (string)$login, 'email' => 'xurshid.karimov@gmail.com', 'phone' => '+998900123456', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1996-05-22', 'gender' => 'male', 'passport_series' => 'BE8901234', 'passport_number' => '12389045761272', 'address' => 'Toshkent shahri, Yashnabad tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 4, 'hire_date' => '2020-04-20', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2018-06-30', 'department_id' => 9, 'room_number' => 615, 'bio' => 'Malakali hamshira.', 'status' => 'active']);
        $login++;

        // 40
        $user = User::create(['name' => 'Nodirabegim', 'middle_name' => 'Jahangirovna', 'last_name' => 'Sultonova', 'login' => (string)$login, 'email' => 'nodirabegim.sultonova@gmail.com', 'phone' => '+998901234789', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1998-10-05', 'gender' => 'female', 'passport_series' => 'BF9012345', 'passport_number' => '12389045761273', 'address' => 'Toshkent shahri, Mirobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 2, 'hire_date' => '2022-05-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2021-06-30', 'department_id' => 10, 'room_number' => 620, 'bio' => 'Yosh hamshira.', 'status' => 'active']);
        $login++;

        // 41
        $user = User::create(['name' => 'Javlon', 'middle_name' => 'Abdulazizovich', 'last_name' => 'Xasanov', 'login' => (string)$login, 'email' => 'javlon.xasanov@gmail.com', 'phone' => '+998902345678', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1994-08-19', 'gender' => 'male', 'passport_series' => 'BG0123456', 'passport_number' => '12389045761274', 'address' => 'Toshkent shahri, Yunusobod tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 6, 'hire_date' => '2018-12-10', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2016-06-30', 'department_id' => 1, 'room_number' => 701, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 42
        $user = User::create(['name' => 'Maloxat', 'middle_name' => 'Baxtiyorovna', 'last_name' => 'Haydarova', 'login' => (string)$login, 'email' => 'maloxat.haydarova@gmail.com', 'phone' => '+998903456789', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1997-03-16', 'gender' => 'female', 'passport_series' => 'BH1234567', 'passport_number' => '12389045761275', 'address' => 'Toshkent shahri, Shayxontohur tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 4, 'hire_date' => '2020-09-01', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2018-06-30', 'department_id' => 2, 'room_number' => 705, 'bio' => 'Malakali hamshira.', 'status' => 'active']);
        $login++;

        // 43
        $user = User::create(['name' => 'Erkin', 'middle_name' => 'Raxmonovich', 'last_name' => 'Hakimov', 'login' => (string)$login, 'email' => 'erkin.hakimov@gmail.com', 'phone' => '+998904567890', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1991-11-25', 'gender' => 'male', 'passport_series' => 'BI2345678', 'passport_number' => '12389045761276', 'address' => 'Toshkent shahri, Sergeli tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 9, 'hire_date' => '2015-08-15', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2013-06-30', 'department_id' => 3, 'room_number' => 710, 'bio' => 'Tajribali hamshira.', 'status' => 'active']);
        $login++;

        // 44
        $user = User::create(['name' => 'Zebo', 'middle_name' => 'Sherzodovna', 'last_name' => 'Raximova', 'login' => (string)$login, 'email' => 'zebo.raximova@gmail.com', 'phone' => '+998905678901', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1995-07-07', 'gender' => 'female', 'passport_series' => 'BJ3456789', 'passport_number' => '12389045761277', 'address' => 'Toshkent shahri, Chilonzor tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Hamshira', 'qualification' => 'O\'rta maxsus', 'experience_years' => 5, 'hire_date' => '2019-06-01', 'education_university' => 'Toshkent tibbiyot kolleji', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'College', 'graduation_date' => '2017-06-30', 'department_id' => 4, 'room_number' => 715, 'bio' => 'Mas\'uliyatli hamshira.', 'status' => 'active']);
        $login++;

        // 45
        $user = User::create(['name' => 'Umid', 'middle_name' => 'Baxodirovich', 'last_name' => 'Aliqulov', 'login' => (string)$login, 'email' => 'umid.aliqulov@gmail.com', 'phone' => '+998906789012', 'password' => Hash::make('secret'), 'is_active' => 1]);
        $user->roles()->attach(4);
        $user->nurse()->create(['birth_date' => '1993-04-28', 'gender' => 'male', 'passport_series' => 'BK4567890', 'passport_number' => '12389045761278', 'address' => 'Toshkent shahri, Yakkasaroy tumani', 'specialization' => 'Hamshiralik ishi', 'position' => 'Katta hamshira', 'qualification' => 'Oliy', 'experience_years' => 7, 'hire_date' => '2017-11-15', 'education_university' => 'Toshkent tibbiyot akademiyasi', 'education_specialization' => 'Hamshiralik ishi', 'education_level' => 'Bachelor', 'graduation_date' => '2015-06-30', 'department_id' => 5, 'room_number' => 720, 'bio' => 'Tajribali va malakali hamshira.', 'status' => 'active']);
    }
}