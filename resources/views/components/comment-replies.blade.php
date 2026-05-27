@props(['replies'])

@foreach($replies as $reply)
    @php $postId = $reply->post_id ?? ($reply->parent ? $reply->parent->post_id : null); @endphp

    <div style="margin-bottom: 10px; margin-top: 5px;">
        <div style="display: flex; gap: 8px; align-items: flex-start;">

            <a href="{{ route('user.profile', $reply->user->id) }}">
                <img src="{{ $reply->user->avatar_url }}" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; border: 1px solid #eee;">
            </a>

            <div style="background: #f8f9fa; padding: 8px 12px; border-radius: 15px; flex: 1; position: relative; padding-right: 50px;">
                <a href="{{ route('user.profile', $reply->user->id) }}" style="text-decoration: none; color: #007bff; font-weight: bold; font-size: 13px; display: block;">
                    {{ $reply->user->name }}
                </a>

                <p style="margin: 0; font-size: 14px; color: #333;">
                    @if($reply->parent)
                        <a href="{{ route('user.profile', $reply->parent->user->id) }}" style="color: #007bff; text-decoration: none; font-weight: bold; font-size: 12px; margin-right: 4px;">
                            @ {{ $reply->parent->user->name }}
                        </a>
                    @endif
                    {{ $reply->body }}
                </p>

                <div style="display: flex; gap: 12px; align-items: center; margin-top: 4px;">
                    <small style="color: #999; font-size: 11px;">{{ $reply->created_at->diffForHumans() }}</small>
                    <button type="button" onclick="setupReply({{ $postId ?? $reply->commentable_id }}, {{ $reply->id }}, '{{ $reply->user->name }}')" style="background: none; border: none; color: #65676b; font-size: 12px; font-weight: bold; cursor: pointer; padding: 0;">
                       {{ __('messages.reply') }}
                    </button>
                </div>

                @can('delete', $reply)
                    <form action="{{ route('comments.destroy', $reply->id) }}" method="POST" style="position: absolute; right: 30px; top: 8px;">
                        @csrf @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 11px; padding: 0;">✕</button>
                    </form>
                @endcan

                <div style="position: absolute; right: 8px; top: 6px; text-align: center;">
                    <form action="{{ route('comments.like', $reply->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 13px; padding: 0;">
                            {{ $reply->commentLikes && $reply->commentLikes->where('user_id', auth()->id())->count() > 0 ? '❤️' : '🤍' }}
                        </button>
                    </form>
                    <small style="display: block; color: #777; font-size: 9px; margin-top: -2px;">{{ $reply->commentLikes ? $reply->commentLikes->count() : 0 }}</small>
                </div>
            </div>
        </div>
    </div>
@endforeach
