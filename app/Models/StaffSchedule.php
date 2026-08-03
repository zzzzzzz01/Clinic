<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedulable_id',
        'schedulable_type',
        'day_id',
        'start_time',
        'end_time',
        'lunch_start',
        'lunch_end',
        'appointment_duration',
        'is_working',
    ];

    // Polymorphic relationship
    public function schedulable()
    {
        return $this->morphTo();
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    // Kun bilan bog‘lanish
    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function appointmentSlots()
    {
        return $this->hasMany(AppointmentSlot::class, 'staff_schedule_id');
    }
}
