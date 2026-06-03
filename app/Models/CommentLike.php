<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    protected $fillable = ['user_id', 'comment_id'];

    public function comment()
    {
        return $table->belongsTo(Comment::class);
    }
}
