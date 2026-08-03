<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'room_type_id',
        'floor',
        'department_id',
        'capacity',
        'price',
        'description_uz',
        'description_ru',
        'description_en',
        'status',
    ];

    // Amenities bilan bog‘lanish (many-to-many)
    public function features()
    {
        return $this->belongsToMany(Feature::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function roomBeds()
    {
        return $this->hasMany(BedRoom::class);
    }

    // Xonadagi barcha yotganlar (tarix bilan)
    public function hospitalizationRooms()
    {
        return $this->hasManyThrough(
            HospitalizationRoom::class,
            BedRoom::class,
            'room_id',   // bed_rooms.room_id
            'bed_id',    // hospitalization_rooms.bed_id
            'id',
            'id'
        );
    }
}
