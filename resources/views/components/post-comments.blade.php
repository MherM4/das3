@props(['post'])

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

                    @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                              style="position: absolute; right: 10px; top: 8px;"
                              onsubmit="return confirm('{{ __("messages.confirm_delete_comment") }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 12px; padding: 0;" title="Ջնջել">
                                ✕
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <p style="text-align: center; color: #999; font-size: 14px;">{{ __('messages.no_comments_yet') }}</p>
        @endforelse
    </div>

    <form action="{{ route('posts.comment', $post->id) }}" method="POST" style="display: flex; gap: 8px;">
        @csrf
        <input type="text" name="body" placeholder="{{ __('messages.write_comment') }}" required
               style="flex: 1; border: 1px solid #ddd; padding: 8px 15px; border-radius: 20px; outline: none; font-size: 14px;">
        <button type="submit" style="background: #007bff; color: white; border: none; padding: 0 15px; border-radius: 20px; cursor: pointer; font-weight: bold;">
            ➤
        </button>
    </form>
</div>
