<x-app-layout>
    <x-slot:title>{{ __('messages.main') }}</x-slot:title>
    <x-slot:subheader>
        @include('components.SubHeader')
    </x-slot:subheader>

@vite(['resources/css/post-index.css'])

<main style="max-width: 800px; margin: 30px auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 0 15px;">
    @forelse($posts as $post)
        @include('components.post-card', ['post' => $post])
    @empty
        <div style="text-align: center; padding: 50px; background: white; border-radius: 12px; border: 1px dashed #ccc;">
            <p style="color: #777; font-size: 18px;">{{ __('messages.not_post_yet') }}</p>
            @auth
                <a href="{{ route('posts.create') }}" style="color: #007bff; font-weight: 600;">{{ __('messages.be_first_post') }}</a>
            @endauth
        </div>
    @endforelse



    @if(method_exists($posts, 'links'))
        <div class="d-flex justify-content-center my-4">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    @endif
</main>

</x-app-layout>
