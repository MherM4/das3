<?php

namespace App\Models;

use App\Models\Post;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const DEFAULT_AVATAR = 'defaults/default_avatar.jpg';
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_blocked' => 'boolean',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return asset(self::DEFAULT_AVATAR);
        }

        if (str_starts_with($this->avatar, 'storage/')) {
            return asset($this->avatar);
        }

        return asset('storage/' . $this->avatar);
    }

    public function savedPosts()
    {
        return $this->belongsToMany(Post::class, 'saves', 'user_id', 'post_id');
    }
}
