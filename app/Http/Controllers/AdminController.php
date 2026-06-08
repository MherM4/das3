<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ChangeRoleRequest;
use App\Http\Requests\Admin\SearchUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    use AuthorizesRequests;

    public function adminUsers(SearchUserRequest $request)
    {
    $this->authorize('viewAny', User::class);
    $query = User::where('id', '!=', auth()->id());

    if ($request->filled('search')) {
        $search = $request->validated('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
        });
    }

    $sortField = $request->get('sort', 'id');
    $sortDirection = $request->get('direction', 'asc');
    $allowedFields = ['id', 'name', 'email', 'role'];
    if (in_array($sortField, $allowedFields)) {
        $query->orderBy($sortField, $sortDirection === 'desc' ? 'desc' : 'asc');
    }

    $users = $query->paginate(10)->appends($request->query());
    return view('admin.users', compact('users'));
    }

    public function toggleBlock(User $user)
    {
        $this->authorize('manage', $user);

        $user->update(['is_blocked' => ! $user->is_blocked]);

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

        if (! empty($data['password'])) {
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

        $user->update([
            'avatar' => null,
            'avatar_deleted_at' => null
        ]);

        return back()->with('success', __('messages.avatar_permanently_deleted'));
    }

    return back()->with('error', __('messages.user_havnt_avatar'));
}
}
