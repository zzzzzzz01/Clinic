<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'middle_name', 'last_name', 'login', 'email', 'password', 'photo', 'phone', 'is_active', 'email_verified_at'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function roles()
    {
        return $this->belongsToMany(Role::class,);
    }

    public function hasRole($roles): bool
    {
        return $this->roles()
            ->whereIn('name', (array) $roles)
            ->exists();
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class); 
    }

    public function nurse()
    {
        return $this->hasOne(Nurse::class);
    }

    public function medicineUsages()
    {
        return $this->hasMany(MedicineUsage::class);
    }

    public function isAdmin(): bool
    {
        return $this->roles()->where('name', 'Admin')->exists();
    }


    // Post likes bilan bog'lanish
    public function postLikes()
    {
        return $this->hasMany(PostLike::class);
    }

    // Foydalanuvchi like bosgan postlar
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_likes', 'user_id', 'post_id')
                    ->wherePivot('is_liked', true)
                    ->withPivot('is_liked', 'created_at');
    }

    // Foydalanuvchi unlike bosgan postlar
    public function unlikedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_likes', 'user_id', 'post_id')
                    ->wherePivot('is_liked', false)
                    ->withPivot('is_liked', 'created_at');
    }

    // Post like bosganmi tekshirish
    public function hasLikedPost($postId)
    {
        return $this->postLikes()
                    ->where('post_id', $postId)
                    ->where('is_liked', true)
                    ->exists();
    }

    // Post unlike bosganmi tekshirish
    public function hasUnlikedPost($postId)
    {
        return $this->postLikes()
                    ->where('post_id', $postId)
                    ->where('is_liked', false)
                    ->exists();
    }
}
