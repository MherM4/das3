@include('components.header')

<main style="max-width: 800px; margin: 30px auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 0 15px;">
    @forelse($posts as $post)
        @include('components.post-card', ['post' => $post])
    @empty
        <div style="text-align: center; padding: 50px; background: white; border-radius: 12px; border: 1px dashed #ccc;">
            <p style="color: #777; font-size: 18px;">Դեռևս ոչ մի գրառում չկա։</p>
            @auth
                <a href="{{ route('posts.create') }}" style="color: #007bff; font-weight: 600;">Եղիր առաջինը և ստեղծիր գրառում</a>
            @endauth
        </div>
    @endforelse

    @if(method_exists($posts, 'links'))
        <div style="margin-top: 30px;">
            {{ $posts->links() }}
        </div>
    @endif
</main>

<style>
    body {
        background-color: #f8f9fa;
        margin: 0;
    }
</style>
