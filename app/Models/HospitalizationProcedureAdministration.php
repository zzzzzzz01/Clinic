<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationProcedureAdministration extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalization_id',
        'hospitalization_procedure_id',
        'patient_id',
        'administered_by_type',
        'administered_by_id',
        'administration_at',
        'status',
        'notes',
    ];

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class);
    }

    public function procedure()
    {
        return $this->belongsTo(HospitalizationProcedure::class, 'hospitalization_procedure_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function administrationBy()
    {
        return $this->morphTo('administered_by');
    }
}
