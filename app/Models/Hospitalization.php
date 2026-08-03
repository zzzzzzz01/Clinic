<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospitalization extends Model
{
    use HasFactory;

    protected $fillable = [
        'appointment_id',
        'department_id',
        'urgency',
        'referral_reason',
        'status',
        'admitted_at',
        'discharged_at',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function hospitalizationStaff()
    {
        return $this->hasMany(HospitalizationStaff::class);
    }

    public function hospitalizationRooms()
    {
        return $this->hasMany(HospitalizationRoom::class);
    }

    public function currentRoom()
    {
        return $this->hasOne(HospitalizationRoom::class)
            ->whereNull('unassigned_at')
            ->latest('assigned_at');
    }

    public function prescriptions()
    {
        return $this->hasMany(HospitalizationPrescription::class);
    }

    public function procedures()
    {
        return $this->hasMany(HospitalizationProcedure::class);
    }

    public function prescriptionItems()
    {
        return $this->hasManyThrough(
            HospitalizationPrescriptionItem::class,
            HospitalizationPrescription::class,
            'hospitalization_id', // HospitalizationPrescription'dagi foreign key
            'hospitalization_prescription_id',    // HospitalizationPrescriptionItem'dagi foreign key  
            'id',                 // Hospitalization'dagi local key
            'id'                  // HospitalizationPrescription'dagi local key
        );
    }

    
}
