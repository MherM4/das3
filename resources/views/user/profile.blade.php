<x-app-layout>
    <x-slot:title>{{ __('messages.profile') }}</x-slot:title>

<main style="max-width: 900px; margin: 30px auto; padding: 25px; font-family: sans-serif;">

    <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; margin-bottom: 30px;">
        <img src="{{ $user->avatar_url }}" style="width: 150px; height: 150px; border-radius: 50%;">
        <h2 style="margin-top: 15px; color: #333;">{{ $user->name }}</h2>
        <p style="color: #666;">{{ $user->email }}</p>
        @if(auth()->check() && auth()->id() === $user->id)
            <div style="margin-top: 20px;">
                <a href="{{ route('profile.edit') }}"
                   style="text-decoration: none; background: #007bff; color: white; padding: 10px 25px; border-radius: 8px; font-weight: bold; display: inline-block;">
                    {{ __('messages.edit_profile') }}
                </a>
            </div>
        @endif
    </div>

    <h3 style="margin-bottom: 20px; color: #444; border-left: 5px solid #007bff; padding-left: 15px;">
        {{ __('messages.posts') }} ({{ $posts->count() }})
    </h3>

    @forelse($posts as $post)

        @include('components.post-card', ['post' => $post])

    @empty
        <div style="text-align: center; padding: 50px; background: #fff; border-radius: 12px; color: #888; font-style: italic;">
            {{ __('messages.user_not_post_yet') }}
        </div>
    @endforelse

    @if(method_exists($posts, 'links'))
        <div class="d-flex justify-content-center my-4">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    @endif



</main>

<script>
    function moveCarousel(postId, direction) {
        const container = document.querySelector(`#carousel-${postId} .carousel-container`);
        if(container) {
            const slideWidth = container.offsetWidth;
            container.scrollBy({
                left: direction * slideWidth,
                behavior: 'smooth'
            });
        }
    }
</script>

<style>
    body {
        background-color: #f8f9fa;
        margin: 0;
    }
    nav svg {
    max-height: 20px;
    display: inline-block;
}

.pagination {
    display: flex;
    list-style: none;
    gap: 5px;
}

.page-item .page-link {
    padding: 8px 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-decoration: none;
    color: #007bff;
}

.page-item.active .page-link {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}
</style>

</x-app-layout>
