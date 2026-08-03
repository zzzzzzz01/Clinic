<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_uz',
        'name_ru',
        'name_en',
        'code',
        'description_uz',
        'description_ru',
        'description_en',
        'department_id',
        'price',
        'time',
        'status'
    ];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_$locale"};
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"description_$locale"};
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'panel_tests', 'panel_id', 'test_id')
                    ->withTimestamps();
    }
}
