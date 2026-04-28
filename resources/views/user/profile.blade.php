@include('components.header')

<main style="max-width: 900px; margin: 30px auto; padding: 25px; font-family: sans-serif;">

    <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); text-align: center; margin-bottom: 30px;">
        <img src="{{ $user->avatar_url }}" style="width: 150px; height: 150px; border-radius: 50%;">
        <h2 style="margin-top: 15px; color: #333;">{{ $user->name }}</h2>
        <p style="color: #666;">{{ $user->email }}</p>
        @if(auth()->check() && auth()->id() === $user->id)
            <div style="margin-top: 20px;">
                <a href="{{ route('profile.edit') }}"
                   style="text-decoration: none; background: #007bff; color: white; padding: 10px 25px; border-radius: 8px; font-weight: bold; display: inline-block;">
                    ⚙️ Խմբագրել պրոֆիլը
                </a>
            </div>
        @endif
    </div>

    <h3 style="margin-bottom: 20px; color: #444; border-left: 5px solid #007bff; padding-left: 15px;">
        Գրառումներ ({{ $posts->count() }})
    </h3>

    @forelse($posts as $post)

        @include('components.post-card', ['post' => $post])

    @empty
        <div style="text-align: center; padding: 50px; background: #fff; border-radius: 12px; color: #888; font-style: italic;">
            Այս օգտատերը դեռ ոչ մի գրառում չի կատարել:
        </div>
    @endforelse


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
