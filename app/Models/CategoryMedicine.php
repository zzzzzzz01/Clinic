<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_uz',
        'name_ru',
        'name_en'
    ];

    // NAME
    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_$locale"} ?? $this->name_uz;
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
