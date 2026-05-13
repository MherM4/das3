<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->role === 'super_admin') {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'moderator']);
    }

    public function manage(User $user, User $targetUser)
    {
        if ($targetUser->role === 'super_admin') {
            return false;
        }
        return $user->role === 'admin' || $user->role === 'super_admin';
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === 'admin' && $user->id !== $model->id;
    }

    public function changeRole(User $user, User $targetUser): bool
{
    if ($user->role === 'admin') {
        return $targetUser->role !== 'super_admin' && $targetUser->role !== 'admin';
    }

    if ($user->role === 'super_admin') {
        return $user->id !== $targetUser->id;
    }

    return false;
}
}
