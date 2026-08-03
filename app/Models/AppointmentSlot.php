<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_schedule_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'bemor_id',
    ];

    // Relationship: slot qaysi doctor_schedule ga tegishli
    public function staffSchedule()
    {
        return $this->belongsTo(StaffSchedule::class);
    }

    // Relationship: slot qaysi bemorga tegishli
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

    // Helper: slot mavjudmi yoki bandmi
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
