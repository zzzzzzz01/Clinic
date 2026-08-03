<?php

namespace Database\Seeders;

use App\Models\BedRoom;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BedRoomSeeder extends Seeder
{
    public function run(): void
    {
        // Barcha xonalarni olamiz
        $rooms = Room::all();

        foreach ($rooms as $room) {
            // Xonaning capacity (bed soni) bo'yicha bed_room yaratamiz
            for ($i = 1; $i <= $room->capacity; $i++) {
                BedRoom::create([
                    'room_id' => $room->id,
                    'bed_number' => $i,
                    'status' => 'available' // hammasi available
                ]);
            }
        }
    }
}