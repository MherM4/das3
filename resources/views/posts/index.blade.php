<x-app-layout>
    <x-slot:title>{{ __('messages.main') }}</x-slot:title>
    <x-slot:subheader>
        @include('components.SubHeader')
    </x-slot:subheader>
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
