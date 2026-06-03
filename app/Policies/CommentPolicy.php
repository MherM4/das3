<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->role === 'admin' || $user->role === 'super_admin' || $user->role === 'moderator') {
            return true;
        }
    }

    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->id === $comment->post->user_id || in_array($user->role, ['admin', 'super_admin', 'moderator']);
    }
}
