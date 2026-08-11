<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;

class ChatPolicy
{
    public function view(?User $user, Chat $chat): bool
    {
        return $user && $chat->users()->where('user_id', $user->id)->exists();
    }

    public function delete(User $user, Chat $chat): bool
    {
        return $chat->creator_id === $user->id;
    }

    public function setAdmin(User $user, Chat $chat): bool
    {
        return $chat->users()->where('user_id', $user->id)
            ->wherePivot('role', 'admin')
            ->exists();
    }
}
