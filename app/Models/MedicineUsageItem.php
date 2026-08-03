<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineUsageItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_usage_id',
        'medicine_id',
        'unit',
        'quantity',
        'price',
        'total_price',
    ];

    public function usage()
    {
        return $this->belongsTo(MedicineUsage::class, 'medicine_usage_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
