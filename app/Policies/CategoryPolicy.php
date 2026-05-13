<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->role === 'super_admin') {
            return true;
        }
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin']);
    }

    public function update(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Category $category): bool
    {
        return $user->role === 'admin';
    }
}
