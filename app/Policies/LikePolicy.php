<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class LikePolicy
{
    public function toggle(User $user, Post $post): bool
    {
        return ! $user->is_blocked;
    }
}
