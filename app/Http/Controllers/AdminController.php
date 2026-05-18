<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Admin\ChangeRoleRequest;
use App\Http\Requests\Admin\SearchUserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    use AuthorizesRequests;

    public function adminDashboard()
    {
        $this->authorize('viewAny', User::class);

        $stats = [
            'users_count' => User::count(),
            'posts_count' => Post::count(),
            'blocked_users' => User::where('is_blocked', true)->count(),
            'admins_count' => User::whereIn('role', ['admin', 'super_admin'])->count(),
        ];

        $latest_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latest_users'));
    }

    public function adminUsers(SearchUserRequest $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::where('id', '!=', auth()->id());

        if ($request->filled('search')) {
            $search = $request->validated('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function toggleBlock(User $user)
{
    $this->authorize('manage', $user);

    $user->update(['is_blocked' => !$user->is_blocked]);

    if ($user->is_blocked) {
        $user->likes()->delete();

        $user->comments()->delete();

        $message = __('messages.user_blocked_content_deleted');
    } else {
        $message = __('messages.user_unblocked');
    }

    return back()->with('success', $message);
}

    public function changeRole(ChangeRoleRequest $request, User $user)
    {
        $this->authorize('changeRole', $user);

        $user->update($request->validated());

        return back()->with('success', __('messages.user_role_updated'));
    }

    public function editUser(User $user)
    {
        $this->authorize('manage', $user);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(UpdateUserRequest $request, User $user)
    {
        $this->authorize('manage', $user);

        $data = $request->validated();
        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        return redirect()->route('admin.users')->with('success', __('messages.data_uptdated'));
    }

    public function adminDeleteAvatar(User $user)
    {
        $this->authorize('manage', $user);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
            return back()->with('success', __('messages.avatar_deleted'));
        }
        return back()->with('error', __('messages.user_havnt_avatar'));
    }
}
