<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
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

        $validated = $request->validated();

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
   

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Ընթացիկ գաղտնաբառը սխալ է:']);
        }

        Auth::user()->update(['password' => Hash::make($request->new_password)]);
        return redirect()->route('profile')->with('success', 'Գաղտնաբառը փոխվեց:');
    }


}
