<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_uz',
        'name_ru',
        'name_en',
        'slug',
        'head_doctor_id',
        'total_beds',
        'floor',
        'description_uz',
        'description_ru',
        'description_en',
        'status',
        'photo',
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
    

    public function headDoctor()
    {
        return $this->belongsToMany(Doctor::class, 'department_doctor')
                    ->withPivot('is_head') // pivot ustuni
                    ->withTimestamps()
                    ->wherePivot('is_head', true); // faqat head doctorlar
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'department_doctor')
                    ->withPivot('is_head') // pivot ustuni
                    ->withTimestamps();
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // public function hospitalizations()
    // {
    //     return $this->hasMany(Hospitalization::class);
    // }

    // public function panels()
    // {
    //     return $this->hasMany(Panel::class);
    // }

    public function nurses() 
    {
        return $this->hasMany(Nurse::class);
    }

    public function features()
    {
        return $this->hasMany(DepartmentFeature::class);
    }

    public function procedures()
    {
        return $this->hasMany(Procedure::class);
    }

    public function diseases()
    {
        return $this->hasMany(DepartmentDisease::class);
    }
}
