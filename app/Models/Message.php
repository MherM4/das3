<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Message extends Model
{
    protected $fillable = ['user_id', 'chat_id', 'content', 'file_path', 'type', 'is_edited', 'deleted_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected static function booted() {
        static::deleting(function ($message) {
            if ($message->file_path) {
                Storage::disk('public')->delete($message->file_path);
            }
        });
    }
}
