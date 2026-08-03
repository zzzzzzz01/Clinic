<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelTest extends Model
{
    use HasFactory;

    protected $fillable = ['panel_id', 'test_id'];

    public function tests()
    {
        return $this->belongsToMany(
            Test::class,
            'panel_tests', // pivot jadval
            'panel_id',
            'test_id'
        );
    }

    public function panel()
    {
        return $this->belongsTo(Panel::class);
    }
}
