<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->role === 'super_admin' || $user->role === 'admin') {
            return true;
        }
    }


    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }


    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function forceDelete(User $user, Post $post): bool
    {
    return $user->id === $post->user_id;
    }
}
