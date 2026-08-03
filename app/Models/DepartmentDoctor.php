<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentDoctor extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'doctor_id', 'is_head'];

    protected $table = 'department_doctor';
}
