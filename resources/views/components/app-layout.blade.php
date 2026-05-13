<!DOCTYPE html>
<html lang="hy">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Իմ Բլոգը' }}</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @stack('styles')
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7f6;">

    @include('components.header')

    <main style="min-height: 80vh; padding: 20px;">
        {{ $slot }}
    </main>

    <footer style="background: #333; color: white; text-align: center; padding: 20px; margin-top: 50px;">
        <p>&copy; {{ date('Y') }} Laravel Project</p>
    </footer>

    @stack('scripts')

    <style>
    .carousel-container::-webkit-scrollbar { display: none; }
    .carousel-container { -ms-overflow-style: none; scrollbar-width: none; }
    .carousel-btn {position: absolute; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); color: white; border: none; border-radius: 50%; width: 35px; height: 35px; cursor: pointer; display: flex; align-items: center; justify-content: center; z-index: 10; transition: 0.3s;}
    .carousel-btn:hover { background: rgba(0,0,0,0.8); }
    .edit-post-btn {text-decoration: none; background: #f0f7ff; color: #007bff; border: 1px solid #cce5ff; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; display: flex; align-items: center; gap: 5px;}
    .delete-post-btn {background: #fff5f5; color: #e53e3e; border: 1px solid #fed7d7; padding: 6px 12px; border-radius: 6px; font-size: 12px; font-weight: bold; display: flex; align-items: center; gap: 5px; cursor: pointer;}
</style>

<script>
    function moveCarousel(postId, direction) {
        const container = document.querySelector(`#carousel-${postId} .carousel-container`);
        if(container) container.scrollBy({ left: direction * container.offsetWidth, behavior: 'smooth' });
    }

    function toggleComments(postId) {
        const section = document.getElementById(`comment-section-${postId}`);
        section.style.display = (section.style.display === 'none') ? 'block' : 'none';
    }
</script>
</body>
</html>
