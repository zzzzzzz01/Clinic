<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentDisease extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'name_uz',
        'name_ru',
        'name_en',
        'sort_order'
    ];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_$locale"};
    }

    public function department()
    {
        return $this->belongsTo(Department::class,);
    }
}
