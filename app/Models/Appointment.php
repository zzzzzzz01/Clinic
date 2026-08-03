<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_slot_id',
        'reason',
        'notes',
        'date',
        'status', 
        'treatment_type',
        'duration',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointmentSlot()
    {
        return $this->belongsTo(AppointmentSlot::class, 'appointment_slot_id');
    }

    public function diagnosis()
    {
        return $this->hasOne(Diagnose::class);
    }

    public function hospitalization()
    {
        return $this->hasOne(Hospitalization::class);
    }
}
