<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnose extends Model
{
    use HasFactory;

    protected $fillable = [
    'appointment_id',
    'department_id',
    'diagnosis',
    'full_diagnosis',
    'complaints',
    'recommendations'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function hospitalization()
    {
        return $this->hasOne(Hospitalization::class);
    }
}
