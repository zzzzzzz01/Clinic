<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationProcedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'procedure_id',
        'staff_id',
        'staff_type',
        'hospitalization_id',
        'status',
        'price',
        'assigned_at',
        'room_id',
        'notes',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class, 'hospitalization_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function staffType()
    {
        return $this->belongsTo(User::class, 'staff_type');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    // HospitalizationProcedure.php
    public function staff()
    {
        return $this->morphTo();
    }

    public function administration()
    {
        return $this->hasOne(
            HospitalizationProcedureAdministration::class,
            'hospitalization_procedure_id'
        );
    }
}
