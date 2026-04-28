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
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Վստա՞հ եք, որ ուզում եք ջնջել այս գրառումը:');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-post-btn">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Ջնջել
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
                        <img src="{{ asset($img->image) }}" style="width: 100%; max-height: 500px; object-fit: cover; display: block;">
                    </div>
                @endforeach
            </div>

            @if($post->images->count() > 1)
                <button onclick="moveCarousel('{{ $post->id }}', -1)" class="carousel-btn" style="left: 10px;">&#10094;</button>
                <button onclick="moveCarousel('{{ $post->id }}', 1)" class="carousel-btn" style="right: 10px;">&#10095;</button>
                <div style="position: absolute; bottom: 15px; left: 50%; translate: -50% 0; display: flex; gap: 6px; background: rgba(0,0,0,0.3); padding: 5px 10px; border-radius: 20px;">
                    @foreach($post->images as $index => $img)
                        <div style="width: 6px; height: 6px; background: white; border-radius: 50%; opacity: 0.6;"></div>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <p style="color: #555; line-height: 1.6; font-size: 16px; margin-top: 15px; margin-bottom: 5px;">
        {{ $post->body }}
    </p>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #f0f0f0;">
        <div style="display: flex; gap: 20px;">
            <form action="{{ route('posts.like', $post->id) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="display: flex; align-items: center; gap: 5px; background: none; border: none; cursor: pointer; color: {{ $post->isLikedByAuthUser() ? '#e53e3e' : '#65676b' }};">
                    <svg width="22" height="22" fill="{{ $post->isLikedByAuthUser() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span style="font-weight: 600;">{{ $post->likes->count() }}</span>
                </button>
            </form>

            <div onclick="toggleComments('{{ $post->id }}')" style="display: flex; align-items: center; gap: 5px; color: #65676b; cursor: pointer;" class="comment-btn-hover">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span style="font-weight: 600;">{{ $post->comments->count() }}</span>
            </div>
        </div>

        <form action="{{ route('posts.save', $post->id) }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="background: none; border: none; cursor: pointer; color: {{ $post->isSavedByAuthUser() ? '#f6ad55' : '#65676b' }};">
                <svg width="22" height="22" fill="{{ $post->isSavedByAuthUser() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                </svg>
            </button>
        </form>
    </div>

    <div id="comment-section-{{ $post->id }}" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee;">

        <div style="max-height: 250px; overflow-y: auto; margin-bottom: 15px; padding-right: 5px;">
            @forelse($post->comments as $comment)
                <div style="display: flex; gap: 10px; margin-bottom: 12px; align-items: flex-start;">

                    <a href="{{ route('user.profile', $comment->user->id) }}">
                        <img src="{{ $comment->user->avatar_url }}"
                             style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 1px solid #eee;">
                    </a>

                    <div style="background: #f0f2f5; padding: 8px 12px; border-radius: 15px; flex: 1; position: relative;">
                        <a href="{{ route('user.profile', $comment->user->id) }}" style="text-decoration: none; color: #007bff; font-weight: bold; font-size: 13px; display: block;">
                            {{ $comment->user->name }}
                        </a>
                        <p style="margin: 0; font-size: 14px; color: #333;">{{ $comment->body }}</p>
                        <small style="color: #999; font-size: 11px;">{{ $comment->created_at->diffForHumans() }}</small>

                        @if(auth()->id() === $comment->user_id || auth()->id() === $post->user_id || auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="position: absolute; right: 10px; top: 8px;" onsubmit="return confirm('Ջնջե՞լ մեկնաբանությունը:');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 12px; padding: 0;" title="Ջնջել">
                                    ✕
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #999; font-size: 14px;">Դեռ մեկնաբանություններ չկան:</p>
            @endforelse
        </div>

        <form action="{{ route('posts.comment', $post->id) }}" method="POST" style="display: flex; gap: 8px;">
            @csrf
            <input type="text" name="body" placeholder="Գրել մեկնաբանություն..." required
                   style="flex: 1; border: 1px solid #ddd; padding: 8px 15px; border-radius: 20px; outline: none; font-size: 14px;">
            <button type="submit" style="background: #007bff; color: white; border: none; padding: 0 15px; border-radius: 20px; cursor: pointer; font-weight: bold;">
                ➤
            </button>
        </form>
    </div>
</div>

<style>
    .carousel-container::-webkit-scrollbar { display: none; }
    .carousel-container { -ms-overflow-style: none; scrollbar-width: none; }
    .carousel-btn {position: absolute;top: 50%;transform: translateY(-50%);background: rgba(0,0,0,0.5);color: white;border: none;border-radius: 50%;width: 35px;height: 35px;cursor: pointer;font-size: 18px;display: flex;align-items: center;justify-content: center;z-index: 10;transition: background 0.3s;}
    .carousel-btn:hover { background: rgba(0,0,0,0.8); }

    .edit-post-btn {text-decoration: none;background: #f0f7ff;color: #007bff;border: 1px solid #cce5ff;padding: 6px 12px;border-radius: 6px;cursor: pointer;font-size: 12px;font-weight: bold;display: flex;align-items: center;gap: 5px;transition: all 0.2s ease;}
    .edit-post-btn:hover {background: #007bff;color: #fff;}

    .delete-post-btn {background: #fff5f5;color: #e53e3e;border: 1px solid #fed7d7;padding: 6px 12px;border-radius: 6px;cursor: pointer;font-size: 12px;font-weight: bold;display: flex;align-items: center;gap: 5px;transition: all 0.2s ease;}
    .delete-post-btn:hover {background: #e53e3e;color: #fff;}

    .comment-btn-hover:hover { opacity: 0.7; }
</style>

<script>
    function moveCarousel(postId, direction) {
        const container = document.querySelector(`#carousel-${postId} .carousel-container`);
        if(container) {
            container.scrollBy({ left: direction * container.offsetWidth, behavior: 'smooth' });
        }
    }

    function toggleComments(postId) {
        const section = document.getElementById(`comment-section-${postId}`);
        if (section.style.display === 'none') {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    }
</script>
