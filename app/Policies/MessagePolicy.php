<?php

namespace App\Policies;

use App\Models\Message;
use App\Models\User;

class MessagePolicy
{
    public function update(User $user, Message $message): bool
    {
        return $user->id === $message->user_id;
    }

    public function delete(User $user, Message $message): bool
{
    return $user->id === $message->user_id ||
           $message->chat->users()->where('user_id', $user->id)->wherePivot('role', 'admin')->exists();
}
}
