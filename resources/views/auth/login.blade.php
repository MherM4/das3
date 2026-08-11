<x-guest-layout>
    <x-slot:title>{{ __('messages.login') }}</x-slot:title>

    <div class="auth-container">
        <div class="auth-card">
            <h2 class="auth-title">{{ __('messages.login') }}</h2>

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/login" method="POST" class="auth-form">
                @csrf
                <input type="email" name="email" placeholder="{{ __('messages.email') }}" required class="auth-input">

                <input type="password" name="password" placeholder="{{ __('messages.password') }}" required class="auth-input">

                <button type="submit" class="auth-btn">
                    {{ __('messages.log_in') }}
                </button>
            </form>

            <hr class="auth-divider">

            <div class="auth-footer">
                {{ __('messages.no_acc_yet') }}
                <a href="{{ route('register') }}" class="register-link">
                    {{ __('messages.register_new_acc') }}
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
