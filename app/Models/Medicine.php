<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'package_type',
        'form',
        'medicine_category_id',
        'strength_unit',
        'strength_value',
        'units_per_box',
        'stock_boxes',
        'stock_units',
        'min_stock',
        'supplier_id',
        'description_uz',
        'description_ru',
        'description_en',
        'price'
    ];

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"description_$locale"};
    }
    

    public function category()
    {
        return $this->belongsTo(CategoryMedicine::class, 'medicine_category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stocks()
    {
        return $this->hasMany(MedicineStock::class);
    }

    public function items()
    {
        return $this->hasMany(MedicineUsageItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
