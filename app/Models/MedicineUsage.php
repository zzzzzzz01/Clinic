<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'payment_method',
        'given_at',
        'user_id',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(MedicineUsageItem::class);
    }
}
