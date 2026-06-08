<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Notifications\PasswordChangedNotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function myProfile()
    {
        $user = Auth::user();
        $posts = $user->posts()->with('images')->latest()->paginate(10);

        return view('user.profile', compact('user', 'posts'));
    }

    public function showProfile(?User $user = null)
    {
        $posts = $user->posts()->latest()->paginate(10);

        return view('user.profile', compact('user', 'posts'));
    }

    public function editProfile()
    {
        return view('auth.edit', ['user' => Auth::user()]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
    $user = Auth::user();
    $validated = $request->validated();

    $user->name = $validated['name'];
    $user->email = $validated['email'];

    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->avatar = $request->file('avatar')->store('avatars', 'public');
        $user->avatar_deleted_at = null;
    }
    $user->save();
    return redirect()->route('profile')->with('success', __('messages.data_uptdated'));
    }

   public function deleteAvatar()
    {
    $user = Auth::user();
    if ($user->avatar) {
        $user->update(['avatar_deleted_at' => now()]);
    }

    return back()->with('success', __('messages.avatar_deleted'));
    }

    public function restoreAvatar()
    {
    $user = Auth::user();
    $user->update(['avatar_deleted_at' => null]);

    return back()->with('success', __('messages.avatar_restored'));
    }

    public function forceDeleteAvatar() {
    $user = auth()->user();
    if ($user->avatar) {
        Storage::disk('public')->delete($user->avatar);
        $user->update(['avatar' => null, 'avatar_deleted_at' => null]);
    }
    return back()->with('success', __('messages.avatar_permanently_deleted'));
    }

    public function showPasswordForm()
    {
        return view('auth.change-password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
    $user = Auth::user();
    $validated = $request->validated();

    if (! Hash::check($validated['current_password'], $user->password)) {
        return back()->withErrors(['current_password' => __('messages.current_password_wrong')]);
    }
    $user->update(['password' => Hash::make($validated['new_password'])]);
    $user->notify(new \App\Notifications\PasswordChangedNotification());
    return redirect()->route('profile')->with('success', __('messages.password_changed'));
    }
}
