<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationPrescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalization_id',
        'prescribed_by_type',  // 'doctor' yoki 'nurse'
        'prescribed_by_id',    // staff_id
        'prescribed_at',
        'reason',
        'notes',
        'status',
        'stopped_at',
        'patient_id',
    ];
    
    protected $casts = [
        'prescribed_at' => 'datetime',
    ];

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class, 'hospitalization_id');
    }

    /**
     * Patient bilan bog'lanish
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function items()
    {
        return $this->hasMany(
            HospitalizationPrescriptionItem::class,
            'hospitalization_prescription_id' // FK
        );
    }

    public function administrations()
    {
        return $this->hasMany(HospitalizationPrescriptionAdministration::class, 'prescription_id');
    }

    public function prescribedBy()
    {
        return $this->morphTo(null, 'prescribed_by_type', 'prescribed_by_id');
    }

    /**
     * Faqat active dorilarni olish
     */
    public function activeItems()
    {
        return $this->items()->where('status', 'active');
    }
    
    /**
     * Scope: Faqat faol retseptlar
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
