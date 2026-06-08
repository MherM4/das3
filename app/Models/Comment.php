<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'body', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->oldest();
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function commentLikes()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function getAllReplies()
    {
        $allReplies = collect();

        $getNested = function ($comment) use (&$allReplies, &$getNested) {
            foreach ($comment->replies as $reply) {
                $allReplies->push($reply);
                $getNested($reply);
            }
        };

        $getNested($this);

        return $allReplies->sortBy('created_at');
    }

    public function getTotalRepliesCount()
    {
        return $this->getAllReplies()->count();
    }
}
