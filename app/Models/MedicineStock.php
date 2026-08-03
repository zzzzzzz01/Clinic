<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineStock extends Model
{
    use HasFactory;

    protected $table = 'medicine_stocks';

    protected $fillable = [
        'medicine_id',
        'quantity_boxes',
        'pieces_per_box',
        'total_pieces',
        'receive_date',
        'status',
        'user_id',
    ];

    /**
     * Relationship with Medicine
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}