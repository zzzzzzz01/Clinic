<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'price', 'duration', 'unit', 'normal_min', 'normal_max', 'description', 'is_active'];

    public function panels()
    {
        return $this->belongsToMany(Panel::class, 'panel_tests', 'test_id', 'panel_id')
                    ->withTimestamps();
    }
}
