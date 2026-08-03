<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_uz',
        'title_ru',
        'title_en',
        'user_id',
        'category_id',
        'description_uz',
        'description_ru',
        'description_en',
        'content_uz',
        'content_ru',
        'content_en',
        'photo',
        'views',
    ];

    public function getTitleAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"title_$locale"} ?? $this->name_uz;
    } 

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"description_$locale"} ?? $this->name_uz;
    } 

    public function getContentAttribute()
    {
        $locale = app()->getLocale();

        return $this->{"content_$locale"} ?? $this->name_uz;
    } 

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }


    // Likes bilan bog'lanish
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    // Like sonini olish
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    } 

    // Like qo'shish
    public function like($userId)
    {
        if (!$this->isLikedByUser($userId)) {
            return $this->likes()->create([
                'user_id' => $userId,
                'is_liked' => true
            ]);
        }
        return null;
    }

    // Unlike qo'shish (yoqtirmaslik)
    public function unlike($userId)
    {
        $like = $this->likes()->where('user_id', $userId)->first();
        if ($like) {
            $like->update(['is_liked' => false]);
            return $like;
        }
        return null;
    }

    // Like toggle (yoqdi/yoqmadi)
    public function toggleLike($userId)
    {
        $like = $this->likes()->where('user_id', $userId)->first();
        
        if ($like) {
            // Agar mavjud bo'lsa, teskarisiga o'zgartiramiz
            $like->is_liked = !$like->is_liked;
            $like->save();
            return $like->is_liked ? 'liked' : 'unliked';
        } else {
            // Yangi like qo'shamiz
            $this->likes()->create([
                'user_id' => $userId,
                'is_liked' => true
            ]);
            return 'liked';
        }
    }

    // Faqat like bosganlarni olish
    public function likedUsers()
    {
        return $this->likes()->where('is_liked', true);
    }

// Foydalanuvchi like bosganmi tekshirish
public function isLikedByUser($userId)
{
    if (!$userId) return false;
    return $this->likes()->where('user_id', $userId)->where('is_liked', 1)->exists();
}

// Foydalanuvchi dislike bosganmi tekshirish
public function isDislikedByUser($userId)
{
    if (!$userId) return false;
    return $this->likes()->where('user_id', $userId)->where('is_liked', 0)->exists();
}

    // Like va unlike sonlarini olish
    public function getLikedCountAttribute()
    {
        return $this->likes()->where('is_liked', true)->count();
    }

    public function getUnlikedCountAttribute()
    {
        return $this->likes()->where('is_liked', false)->count();
    }

}
    