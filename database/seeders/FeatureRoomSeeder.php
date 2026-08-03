<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Feature;
use Illuminate\Support\Facades\DB;

class FeatureRoomSeeder extends Seeder
{
    public function run(): void
    {
        // Barcha xonalarni olish
        $rooms = Room::all();
        
        // Feature ID lar
        $featureIds = Feature::pluck('id')->toArray();

        foreach ($rooms as $room) {
            // Har bir xonaga 3-6 ta feature biriktiramiz
            $featureCount = rand(3, 6);
            
            // Tasodifiy feature lar tanlaymiz
            $randomFeatures = array_rand(array_flip($featureIds), $featureCount);
            
            // Agar $randomFeatures array bo'lmasa, arrayga o'tkazamiz
            if (!is_array($randomFeatures)) {
                $randomFeatures = [$randomFeatures];
            }

            foreach ($randomFeatures as $featureId) {
                DB::table('feature_room')->insert([
                    'room_id' => $room->id,
                    'feature_id' => $featureId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}