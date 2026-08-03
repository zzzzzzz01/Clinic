<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_uz', 
        'name_ru', 
        'name_en', 
        'description_uz', 
        'description_ru', 
        'description_en', 
        'contact_person', 
        'type_uz', 
        'type_ru',
        'type_en', 
        'email', 
        'phone', 
        'address', 
        'is_active'
    ];

     // NAME
     public function getNameAttribute()
     {
         $locale = app()->getLocale();
 
         return $this->{"name_$locale"} ?? $this->name_uz;
     }
 
     // TYPE
     public function getTypeAttribute()
     {
         $locale = app()->getLocale();
 
         return $this->{"type_$locale"} ?? $this->type_uz;
     }
 
     // DESCRIPTION
     public function getDescriptionAttribute()
     {
         $locale = app()->getLocale();
 
         return $this->{"description_$locale"} ?? $this->description_uz;
     }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }
}
