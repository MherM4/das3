<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'is_group', 'creator_id'];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    protected static function booted() {
        static::deleted(function ($chat) {
            $chat->messages()->update(['deleted_at' => now()]);
        });

        static::restored(function ($chat) {
            $chat->messages()->update(['deleted_at' => null]);
        });
    }
}
