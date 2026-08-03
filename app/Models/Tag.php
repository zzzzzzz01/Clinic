<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name_uz', 'name_ru', 'name_en','slug'];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"name_$locale"} ?? $this->name_uz;
    } 

    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
