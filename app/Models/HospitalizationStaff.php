<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalization_id',
        'staff_id',
        'staff_type',
        'role',
        'assigned_at',
        'unassigned_at',
    ];

    public function staff()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class, 'staff_id');
    }

    // Qaysi statsionalga tegishli
    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class);
    }

    // Qaysi shifokor
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'staff_id');
    }
}
