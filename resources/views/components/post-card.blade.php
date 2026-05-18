<div style="background: white; padding: 25px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #f0f0f0; position: relative;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <img src="{{ $post->user->avatar_url }}"
                 style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
            <div>
                <a href="{{ route('user.profile', $post->user->id) }}" style="text-decoration: none; color: #007bff; font-weight: 600;">
                    {{ $post->user->name }}
                </a>
                <small style="color: #999; display: block;">{{ $post->created_at->diffForHumans() }}</small>
            </div>
        </div>

        @auth
            @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'admin' || auth()->id() === $post->user_id)
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('posts.edit', $post->id) }}" class="edit-post-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        {{ __('messages.edit') }}
                    </a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('{{ __("messages.confirm_delete_post") }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-post-btn">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            {{ __('messages.delete') }}
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>

    <h2 style="margin: 0 0 12px 0; color: #222; font-size: 22px;">{{ $post->title }}</h2>

    @if($post->images->count() > 0)
        <div id="carousel-{{ $post->id }}" style="position: relative; margin-top: 15px; border-radius: 8px; overflow: hidden; border: 1px solid #eee; background: #000;">
            <div class="carousel-container" style="display: flex; overflow-x: auto; scroll-snap-type: x mandatory; scroll-behavior: smooth;">
                @foreach($post->images as $img)
                    <div style="min-width: 100%; scroll-snap-align: start; display: flex; justify-content: center; align-items: center; background: #f8f8f8;">
                        <img src="{{ asset('storage/' . $img->image) }}" alt="Post Image" style="width: 100%; max-height: 500px; object-fit: cover; display: block;">
                    </div>
                @endforeach
            </div>

            @if($post->images->count() > 1)
                <button onclick="moveCarousel('{{ $post->id }}', -1)" class="carousel-btn" style="left: 10px;">&#10094;</button>
                <button onclick="moveCarousel('{{ $post->id }}', 1)" class="carousel-btn" style="right: 10px;">&#10095;</button>
            @endif
        </div>
    @endif

    <p style="color: #555; line-height: 1.6; font-size: 16px; margin-top: 15px;">{{ $post->body }}</p>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #f0f0f0;">
        <div style="display: flex; gap: 20px;">
            <form action="{{ route('posts.like', $post->id) }}" method="POST">
                @csrf
                <button type="submit" style="display: flex; align-items: center; gap: 5px; background: none; border: none; cursor: pointer; color: {{ $post->isLikedByAuthUser() ? '#e53e3e' : '#65676b' }};">
                    <svg width="22" height="22" fill="{{ $post->isLikedByAuthUser() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span style="font-weight: 600;">{{ $post->likes->count() }}</span>
                </button>
            </form>

            <div onclick="toggleComments('{{ $post->id }}')" style="display: flex; align-items: center; gap: 5px; color: #65676b; cursor: pointer;" class="comment-btn-hover">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span style="font-weight: 600;">{{ $post->comments->count() }}</span>
            </div>
        </div>

        @if($post->tags->count() > 0)
        <div class="post-tags" style="margin-top: 10px; margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 5px;">
            @foreach($post->tags as $tag)
                <span style="background-color: #e9ecef; color: #495057; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                    #{{ $tag->name }}
                </span>
            @endforeach
        </div>
        @endif

        <form action="{{ route('posts.save', $post->id) }}" method="POST">
            @csrf
            <button type="submit" style="background: none; border: none; cursor: pointer; color: {{ $post->isSavedByAuthUser() ? '#f6ad55' : '#65676b' }};">
                <svg width="22" height="22" fill="{{ $post->isSavedByAuthUser() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                </svg>
            </button>
        </form>
    </div>

    <x-post-comments :post="$post" />

</div>
