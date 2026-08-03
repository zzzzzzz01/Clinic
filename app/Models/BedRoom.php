<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BedRoom extends Model
{
    use HasFactory;

    protected $table = 'bed_rooms'; // jadval nomi

    protected $fillable = [
        'room_id',
        'bed_number',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function hospitalizationRooms()
    {
        return $this->hasMany(HospitalizationRoom::class, 'bed_id');
    }
}
