<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'My Project' }}</title>
    @vite(['resources/css/app-layout.css' , 'resources/js/app-layout.js'])
    @stack('styles')
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7f6;">

    @include('components.header')
    @if(isset($subheader))
        {{ $subheader }}
    @endif

    <main style="min-height: 80vh; padding: 20px;">
        {{ $slot }}
    </main>

    <footer style="background: #333; color: white; text-align: center; padding: 20px; margin-top: 50px;">
        <p>&copy; {{ date('Y') }} Laravel Project</p>
    </footer>

    @stack('scripts')

</body>
</html>
