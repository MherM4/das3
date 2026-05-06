<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        $stats = [
            'users_count' => User::count(),
            'posts_count' => Post::count(),
            'blocked_users' => User::where('is_blocked', true)->count(),
            'admins_count' => User::whereIn('role', ['admin', 'super_admin'])->count(),
        ];

        $latest_users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latest_users'));
    }

    public function adminUsers(Request $request)
    {
        $query = User::where('id', '!=', Auth::id());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->get();
        return view('admin.users', compact('users'));
    }

    public function toggleBlock(User $user)
    {
        if ($user->role === 'super_admin') {
            return back()->with('error', 'Super Admin-ին հնարավոր չէ բլոկել:');
        }

        $user->update(['is_blocked' => !$user->is_blocked]);
        return back()->with('success', 'Կարգավիճակը թարմացվեց:');
    }

    public function changeRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:user,admin']);
        $user->update(['role' => $request->role]);

        return back()->with('success', 'Օգտատիրոջ դերը թարմացվեց:');
    }

    public function editUser(User $user)
    {
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('admin.users')->with('success', 'Տվյալները թարմացվեցին:');
    }

    public function adminDeleteAvatar(User $user)
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
            return back()->with('success', 'Ավատարը ջնջվեց:');
        }
        return back()->with('error', 'Օգտատերը չունի ավատար:');
    }
}
