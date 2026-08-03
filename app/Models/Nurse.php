<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
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

    public function hospitalizations()
    {
        return $this->morphMany(
            \App\Models\HospitalizationStaff::class,
            'staff'
        );
    }

    public function prescriptions(): MorphMany
    {
        return $this->morphMany(HospitalizationPrescription::class, 'prescribed_by');
    }
    
    public function prescriptionItems(): MorphMany
    {
        return $this->morphMany(HospitalizationPrescriptionItem::class, 'prescribed_by');
    }
    
    public function administrations(): MorphMany
    {
        return $this->morphMany(HospitalizationPrescriptionAdministration::class, 'administered_by');
    }

    public function schedules()
    {
        return $this->morphMany(StaffSchedule::class, 'schedulable');
    }

    public function scheduleHistories()
    {
        return $this->hasMany(DoctorScheduleHistory::class)->orderBy('created_at', 'desc');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
