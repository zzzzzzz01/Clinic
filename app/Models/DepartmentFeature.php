<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'title_uz',
        'title_ru',
        'title_en',
        'description_uz',
        'description_ru',
        'description_en',
        'sort_order'
    ];

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"title_$locale"};
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"description_$locale"};
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
