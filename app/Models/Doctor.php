<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        // Foreign key
        'user_id',

        // Shaxsiy ma'lumotlar
        'birth_date',
        'gender',
        'passport_series',
        'passport_number',
        'address',

        // Kasbiy ma'lumotlar
        'specialization',
        'position',
        'qualification',
        'experience_years',
        'hire_date',



        // Taʼlim maʼlumotlari
        'education_university',
        'education_specialization',
        'education_level',  // Bakalavr, Magistr
        'graduation_date',

        // Bo‘lim va kabinet
        'department_id',
        'room_number',

        // Statistika
        'today_patients',
        'total_patients',
        'active_appointments',
        'completed_appointments',

        // Qo'shimcha
        'bio',
        'status',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departmentHead()
    {
        return $this->hasOne(Department::class, 'head_doctor_id');
    }
    
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_doctor')
                    ->withPivot('is_head')
                    ->withTimestamps();
    }

    public function schedules()
    {
        return $this->morphMany(StaffSchedule::class, 'schedulable');
    }

    public function appointmentSlots() 
    {
        return $this->hasManyThrough(
            \App\Models\AppointmentSlot::class,
            \App\Models\StaffSchedule::class,
            'schedulable_id',       // StaffSchedule → doctor_id o‘rniga polymorphic
            'staff_schedule_id',    // AppointmentSlot → foreign key
            'id',                   // Doctor primary key
            'id'                    // StaffSchedule primary key
        )->where('staff_schedules.schedulable_type', self::class);
    }
    
}
