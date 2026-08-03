<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = ['name_uz', 'name_ru', 'name_en'];

    public function doctorSchedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
