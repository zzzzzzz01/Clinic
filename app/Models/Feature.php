<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = ['name_uz', 'name_ru', 'name_en', 'description_uz', 'description_ru', 'description_en', 'status'];

    // NAME
    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_$locale"} ?? $this->name_uz;
    } 

    // DESCRIPTION
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"description_$locale"} ?? $this->description_uz;
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class,);
    }
}
