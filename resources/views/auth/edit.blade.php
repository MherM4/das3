@vite(['resources/js/edit-user.js'])
<x-app-layout>
    <x-slot:title>{{ __('messages.edit_profile') }}</x-slot:title>
<main style="max-width: 600px; margin: 50px auto; padding: 20px; font-family: sans-serif;">
    <div style="background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center;">

        <h2 style="margin-bottom: 30px; color: #333;">{{ __('messages.edit_profile') }}</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="position: relative; display: inline-block; margin-bottom: 30px;">
                <img id="avatar-preview"src="{{ auth()->user()->avatar_url ?: asset('defaults/default_avatar.jpg') }}"
                     style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 3px solid #007bff;">
                    <label for="avatar" style="position: absolute; bottom: 5px; right: 5px; background: #007bff; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 3px solid white;">
                        <span style="font-size: 20px;">+</span>
                    </label>

                    <input type="file" id="avatar" name="avatar" style="display: none;" onchange="previewImage(this)">

                    <button type="button" id="remove-avatar-btn" onclick="removeAvatar()"
                            style="display: none; position: absolute; top: 0; right: -25px; background: #ff4d4d; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">
                        ✕
                    </button>
            </div>

                @error('avatar')
                    <div style="color: red; margin-top: 10px; font-size: 13px;">{{ $message }}</div>
                @enderror

            <div style="text-align: left; margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #555;">{{ __('messages.full_name') }}</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" style="width: 100%; padding: 12px; border: 1px solid {{ $errors->has('name') ? 'red' : '#ddd' }}; border-radius: 8px; font-size: 16px;">
                @error('name') <div style="color: red; font-size: 12px;">{{ $message }}</div> @enderror
            </div>

            <div style="text-align: left; margin-bottom: 30px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #555;">{{ __('messages.email') }}</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" style="width: 100%; padding: 12px; border: 1px solid {{ $errors->has('email') ? 'red' : '#ddd' }}; border-radius: 8px; font-size: 16px; background: #f9f9f9;">
                @error('email') <div style="color: red; font-size: 12px;">{{ $message }}</div> @enderror
            </div>

            <button type="submit" style="width: 100%; background: #007bff; color: white; border: none; padding: 14px; border-radius: 10px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                {{ __('messages.save_changes') }}
            </button>
        </form>

        @if($user->avatar)
    @if(!$user->hasActiveAvatar())
    <div style="display:flex;justify-content:center;gap:15px;">
<form action="{{ route('avatar.restore', $user->id) }}" method="POST" style="margin-top: 15px;">
            @csrf
            <button type="submit" style="background: none; border: none; color: #28a745; cursor: pointer; font-size: 14px; font-weight: bold;">
                {{ __('messages.restore_avatar') }}
            </button>
        </form>
         <form action="{{ route('avatar.forceDelete', $user->id) }}" method="POST" style="margin-top: 15px;">
            @csrf
            <button type="submit" style="background: none; border: none; color: #a70b0b; cursor: pointer; font-size: 14px; font-weight: bold;">
                {{ __('messages.delete_forever') }}
            </button>
        </form>
    </div>
    @else
        <form action="{{ route('avatar.delete', $user->id) }}" method="POST" style="margin-top: 15px;">
            @csrf
            <button type="submit" onclick="return confirm('{{ __('messages.delete_img_confirm') }}')"
                    style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 14px;">
                {{ __('messages.delete_avatar') }}
            </button>
        </form>
    @endif
@endif

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

        <a href="{{ route('password.edit') }}" style="text-decoration: none; color: #007bff; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 8px;">
            {{ __('messages.change_pass') }}
        </a>
    </div>
</main>
</x-app-layout>
<script>
    window.defaultAvatarUrl = "{{ asset('defaults/default_avatar.jpg') }}";
</script>
