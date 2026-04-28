<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{

    public function showProfile(User $user = null)
    {
        $user = $user ?? Auth::user();
        $posts = $user->posts()->latest()->get();

        return view('user.profile', compact('user', 'posts'));
    }

    public function editProfile()
    {
        return view('auth.edit', ['user' => Auth::user()]);
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:8048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Տվյալները թարմացվեցին:');
    }

    public function deleteAvatar()
    {
        $user = Auth::user();
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }
        return back()->with('success', 'Նկարը ջնջվեց:');
    }

    public function showPasswordForm()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Ընթացիկ գաղտնաբառը սխալ է:']);
        }

        Auth::user()->update(['password' => Hash::make($request->new_password)]);
        return redirect()->route('profile')->with('success', 'Գաղտնաբառը փոխվեց:');
    }


}
