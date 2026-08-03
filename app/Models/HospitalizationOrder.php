<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalization_id',
        'ordered_by',
        'ordered_to',
        'ordered_at',
        'status',
        'order_type',
        'total_price',
        'note',
    ];

    // Hospitalizatsiya bilan bog‘lanadi
    public function hospitalization()
    {
        return $this->belongsTo(Hospitalization::class);
    }

    // Orderni bergan doctor (shifokor)
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'ordered_by');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'ordered_to');
    }

    public function items()
    {
        return $this->hasMany(
            HospitalizationOrderItem::class,
            'hospitalization_order_id'
        );
    }

    public function orderedBy()
    {
        return $this->belongsTo(User::class, 'ordered_by');
    }
}
