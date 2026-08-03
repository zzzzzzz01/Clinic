<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalizationOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalization_order_id',
        'item_type',
        'item_id',
        'quantity',
        'price',
        'status',
        'order_type',
    ];

    public function order()
    {
        return $this->belongsTo(
            HospitalizationOrder::class,
            'hospitalization_order_id'
        );
    }

    // Agar test bo‘lsa natijalar
    public function results()
    {
        return $this->hasMany(TestResult::class, 'hospitalization_order_item_id');
    }

    public function getFinishAtAttribute()
    {
        $orderedAt = Carbon::parse($this->order->ordered_at);

        $hours = $this->item_type === 'test'
            ? $this->test->duration
            : $this->panel->time;

        return $orderedAt->addHours($hours);
    }

    public function getResultStatusAttribute()
    {
        return $this->results()
            ->where('status', 'pending')
            ->exists()
            ? 'pending'
            : 'ready';
    }

    // Test yoki panelni olish (dynamic)
    public function test()
    {
        return $this->belongsTo(Test::class, 'item_id');
    }

    public function panel()
    {
        return $this->belongsTo(Panel::class, 'item_id');
    }

}
