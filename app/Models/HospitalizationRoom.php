<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationRoom extends Model 
{
    use HasFactory;

    protected $fillable = ['hospitalization_id', 'bed_id', 'assigned_at', 'unassigned_at'];

    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class);
    }

    // Qaysi o‘rin (bed)
    public function bed()
    {
        return $this->belongsTo(BedRoom::class, 'bed_id');
    }
}
