<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'My ' }}</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    @stack('styles')
</head>
<body style="background-color: #f8f9fa; font-family: sans-serif; margin: 0;">

    <div style="display: flex; justify-content: end; padding: 10px; ">
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('lang.switch', 'hy') }}"
                 style="text-decoration: none; color: {{ app()->getLocale() == 'hy' ? '#007bff' : '#666' }}; font-weight: {{ app()->getLocale() == 'hy' ? 'bold' : 'normal' }};">
                     Հայ
                </a>
                <span style="color: #ccc;">|</span>
                <a href="{{ route('lang.switch', 'en') }}"
                  style="text-decoration: none; color: {{ app()->getLocale() == 'en' ? '#007bff' : '#666' }}; font-weight: {{ app()->getLocale() == 'en' ? 'bold' : 'normal' }};">
                Eng
                </a>
            </div>
        </div>

    <main>
        {{ $slot }}
    </main>

</body>
</html>
