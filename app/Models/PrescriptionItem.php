<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    protected $fillable = [
    'prescription_id', 
    'medicine_id', 
    'frequency_type', 
    'frequency_value', 
    'interval_days', 
    'dose_amount', 
    'duration_days', 
    'note', 
    'usage_instructions'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}

