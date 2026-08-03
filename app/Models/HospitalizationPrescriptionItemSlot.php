<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationPrescriptionItemSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalization_prescription_item_id',
        'scheduled_at',
        'status',
        'skip_reason',
        'administered_by_type',
        'administered_by_id',
        'administered_at',
        'slot_order'
    ];

    public function item()
    {
        return $this->belongsTo(HospitalizationPrescriptionItem::class, 'hospitalization_prescription_item_id');
    }

    public function administeredBy()
    {
        return $this->morphTo();
    }

    public function administration()
    {
        return $this->hasOne(HospitalizationPrescriptionAdministration::class);
    }
}
