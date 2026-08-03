<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        // Room type ga qarab narxlar
        $prices = [
            1 => 200,   // Standart
            2 => 250,   // Comfort
            3 => 350,   // Family
            4 => 500,   // Lux
            5 => 700,   // Deluxe
        ];

        // Har bir department uchun 9 xona (1-15 departmentlar)
        for ($department_id = 1; $department_id <= 15; $department_id++) {
            // Room Type 1: 1 xona, 1 bed
            Room::create([
                'number' => $department_id . '01',
                'room_type_id' => 1,
                'floor' => rand(1, 4),
                'department_id' => $department_id,
                'capacity' => 1,
                'price' => $prices[1],
                'description_uz' => 'Standart xona, Wi-Fi, konditsioner mavjud',
                'description_ru' => 'Стандартная комната, есть Wi-Fi, кондиционер',
                'description_en' => 'Standard room, Wi-Fi, air conditioning available',
                'status' => 'available'
            ]);

            // Room Type 2: 2 xona, 1 bed
            Room::create([
                'number' => $department_id . '02',
                'room_type_id' => 2,
                'floor' => rand(1, 4),
                'department_id' => $department_id,
                'capacity' => 1,
                'price' => $prices[2],
                'description_uz' => 'Comfort xona, Wi-Fi, Smart TV',
                'description_ru' => 'Комфорт комната, Wi-Fi, Smart TV',
                'description_en' => 'Comfort room, Wi-Fi, Smart TV',
                'status' => 'available'
            ]);
            Room::create([
                'number' => $department_id . '03',
                'room_type_id' => 2,
                'floor' => rand(1, 4),
                'department_id' => $department_id,
                'capacity' => 1,
                'price' => $prices[2],
                'description_uz' => 'Comfort xona, Wi-Fi, Smart TV',
                'description_ru' => 'Комфорт комната, Wi-Fi, Smart TV',
                'description_en' => 'Comfort room, Wi-Fi, Smart TV',
                'status' => 'available'
            ]);

            // Room Type 3: 2 xona, 2 bed
            Room::create([
                'number' => $department_id . '04',
                'room_type_id' => 3,
                'floor' => rand(1, 4),
                'department_id' => $department_id,
                'capacity' => 2,
                'price' => $prices[3],
                'description_uz' => 'Family xona, televizor, muzlatgich, mini-bar',
                'description_ru' => 'Семейная комната, телевизор, холодильник, мини-бар',
                'description_en' => 'Family room, TV, refrigerator, mini-bar',
                'status' => 'available'
            ]);
            Room::create([
                'number' => $department_id . '05',
                'room_type_id' => 3,
                'floor' => rand(1, 4),
                'department_id' => $department_id,
                'capacity' => 2,
                'price' => $prices[3],
                'description_uz' => 'Family xona, televizor, muzlatgich, mini-bar',
                'description_ru' => 'Семейная комната, телевизор, холодильник, мини-бар',
                'description_en' => 'Family room, TV, refrigerator, mini-bar',
                'status' => 'available'
            ]);

            // Room Type 4: 3 xona, 4 bed
            Room::create([
                'number' => $department_id . '06',
                'room_type_id' => 4,
                'floor' => rand(1, 4),
                'department_id' => $department_id,
                'capacity' => 4,
                'price' => $prices[4],
                'description_uz' => 'Lyuks xona, jakuzi, mini-bar, seif',
                'description_ru' => 'Люкс, джакузи, мини-бар, сейф',
                'description_en' => 'Luxury room, jacuzzi, mini-bar, safe',
                'status' => 'available'
            ]);
            Room::create([
                'number' => $department_id . '07',
                'room_type_id' => 4,
                'floor' => rand(1, 4),
                'department_id' => $department_id,
                'capacity' => 4,
                'price' => $prices[4],
                'description_uz' => 'Lyuks xona, jakuzi, mini-bar, seif',
                'description_ru' => 'Люкс, джакузи, мини-бар, сейф',
                'description_en' => 'Luxury room, jacuzzi, mini-bar, safe',
                'status' => 'available'
            ]);
            Room::create([
                'number' => $department_id . '08',
                'room_type_id' => 4,
                'floor' => rand(1, 4),
                'department_id' => $department_id,
                'capacity' => 4,
                'price' => $prices[4],
                'description_uz' => 'Lyuks xona, jakuzi, mini-bar, seif',
                'description_ru' => 'Люкс, джакузи, мини-бар, сейф',
                'description_en' => 'Luxury room, jacuzzi, mini-bar, safe',
                'status' => 'available'
            ]);

            // Room Type 5: 1 xona, 1 bed
            Room::create([
                'number' => $department_id . '09',
                'room_type_id' => 5,
                'floor' => rand(1, 4),
                'department_id' => $department_id,
                'capacity' => 1,
                'price' => $prices[5],
                'description_uz' => 'Deluxe xona, shahar balkon, hamma qulayliklar',
                'description_ru' => 'Deluxe номер, балкон с видом на город, все удобства',
                'description_en' => 'Deluxe room, balcony with city view, all amenities',
                'status' => 'available'
            ]);
        }
    }
}