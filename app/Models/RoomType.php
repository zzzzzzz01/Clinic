<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = ['name_uz', 'name_ru', 'name_en'];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_$locale"};
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
