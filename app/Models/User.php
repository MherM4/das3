<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'language',
        'avatar_deleted_at',
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

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getAvatarUrlAttribute()
    {
    if (! $this->avatar || $this->avatar_deleted_at) {
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

    public function hasActiveAvatar()
    {
    return !empty($this->avatar) && is_null($this->avatar_deleted_at);
    }
    

}
