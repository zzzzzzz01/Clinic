<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalization_order_item_id',
        'test_id',
        'value',
        'unit',
        'normal_min',
        'normal_max',
        'status',
        'resulted_at',
    ];

    public function orderItem()
    {
        return $this->belongsTo(
            HospitalizationOrderItem::class,
            'hospitalization_order_item_id'
        );
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
