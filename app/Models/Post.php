<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = ['title', 'body', 'image', 'user_id'];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset($this->image);
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images() {
        return $this->hasMany(PostImage::class);
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function saves() {
        return $this->hasMany(Save::class);
    }

    public function isLikedByAuthUser() {
        return $this->likes()->where('user_id', auth()->id())->exists();
    }

    public function isSavedByAuthUser() {
        return $this->saves()->where('user_id', auth()->id())->exists();
    }
}
