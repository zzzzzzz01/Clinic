<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationPrescriptionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalization_prescription_id',
        'medicine_id',
        'frequency_type',   // 'daily', 'hourly', 'weekly', etc
        'frequency_value',  // 3 (kuniga 3 marta)
        'dose_amount',      // "1 tabletka, 5 ml"
        'duration_days',
        'start_at',
        'end_at',
        'status',         // 'active', 'completed', 'stopped'
        'dosage',           // "400 mg"
        'form',             // "Tabletka"
        'prescribed_by_type', // 'doctor' yoki 'nurse'
        'prescribed_by_id',   // staff_id
        'note',
    ];
    
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'frequency_value' => 'integer',
        'duration_days' => 'integer',
    ];

    public function prescription()
    {
        return $this->belongsTo(HospitalizationPrescription::class, 'hospitalization_prescription_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }
    
    /**
     * Administrations (qachon berilgan) bilan bog'lanish
     */
    public function administrations()
    {
        return $this->hasMany(HospitalizationPrescriptionAdministration::class, 'prescription_item_id');
    }

    public function prescribedBy()
    {
        return $this->morphTo(null, 'prescribed_by_type', 'prescribed_by_id');
    }

    public function slots()
    {
        return $this->hasMany(HospitalizationPrescriptionItemSlot::class, 'hospitalization_prescription_item_id');
    }


}
