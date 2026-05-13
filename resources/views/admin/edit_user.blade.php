<x-app-layout>
    <x-slot:title>Կառավարման վահանակ</x-slot:title>

<main style="max-width: 600px; margin: 50px auto; padding: 30px; background: white; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1); font-family: sans-serif;">
    <h2 style="margin-bottom: 25px; color: #333; text-align: center;">{{ __('messages.edit_user') }}</h2>

    <div style="text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eee;">
        <img src="{{ $user->avatar_url }}" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #f0f0f0;">

        @if($user->avatar)
            <form action="{{ route('admin.users.delete_avatar', $user->id) }}" method="POST" style="margin-top: 10px;">
                @csrf
                <button type="submit" onclick="return confirm('Վստա՞հ եք, որ ուզում եք ջնջել այս նկարը:')"
                        style="background: none; border: none; color: #dc3545; cursor: pointer; font-size: 13px; font-weight: bold; text-decoration: underline;">
                    {{ __('messages.delete_avatar') }}
                </button>
            </form>
        @endif
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold;">{{ __('messages.full_name') }}</label>
            <input type="text" name="name" value="{{ $user->name }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold;">{{ __('messages.email') }}</label>
            <input type="email" name="email" value="{{ $user->email }}" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
        </div>

        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold;">{{ __('messages.new_pass') }} ({{ __('messages.leave_blank') }})</label>
            <input type="password" name="password" placeholder="********" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; outline: none;">
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="flex: 2; background: #28a745; color: white; border: none; padding: 12px; border-radius: 8px; cursor: pointer; font-weight: bold;">{{ __('messages.save') }}</button>
            <a href="{{ route('admin.users') }}" style="flex: 1; background: #6c757d; color: white; text-decoration: none; padding: 12px; border-radius: 8px; text-align: center; font-weight: bold;">{{ __('messages.cancel') }}</a>
        </div>
    </form>
</main>

</x-app-layout>
