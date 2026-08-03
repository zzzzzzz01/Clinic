<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationPrescriptionAdministration extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalization_prescription_item_id',
        'hospitalization_prescription_item_slot_id',
        'administered_by_type', // 'doctor', 'nurse', 'patient'
        'administered_by_id',
        'administered_at',
        'status', // 'pending', 'administered', 'skipped', 'cancelled'
        'skip_reason'
        // 'prescription_item_id',
        // 'notes',
        // 'dose_given',
        // 'administered_time',
    ];

    /**
     * Prescription bilan bog'lanish
     */
    public function prescription()
    {
        return $this->belongsTo(HospitalizationPrescription::class, 'prescription_id');
    }
    
    /**
     * Prescription item bilan bog'lanish
     */
    public function item()
    {
        return $this->belongsTo(HospitalizationPrescriptionItem::class, 'prescription_item_id');
    }

    public function slot()
    {
        return $this->belongsTo(HospitalizationPrescriptionSlot::class);
    }
    
    /**
     * POLYMORPHIC: Kim tomonidan berilgan (doctor, nurse yoki patient)
     */
    public function administeredBy()
    {
        return $this->morphTo(null, 'administered_by_type', 'administered_by_id');
    }
    
    /**
     * Patient bilan bog'lanish (prescription orqali)
     */
    public function patient()
    {
        return $this->prescription->patient();
    }
    
    /**
     * Hospitalization bilan bog'lanish (prescription orqali)
     */
    public function hospitalization()
    {
        return $this->prescription->hospitalization();
    }
}
