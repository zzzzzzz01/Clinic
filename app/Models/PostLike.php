<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', 'user_id', 'is_liked',
    ];

     // Scope: faqat like bosganlar
     public function scopeLiked($query)
     {
         return $query->where('is_liked', true);
     }
 
     // Scope: faqat unlike bosganlar
     public function scopeUnliked($query)
     {
         return $query->where('is_liked', false);
     }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
