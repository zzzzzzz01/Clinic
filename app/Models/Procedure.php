<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_uz',
        'name_ru',
        'name_en',
        'department_id',
        'description_uz',
        'description_ru',
        'description_en',
        'category',
        'price',
        'duration',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

}
