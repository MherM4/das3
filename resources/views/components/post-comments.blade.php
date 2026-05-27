@props(['post'])
@vite(['resources/js/post-comments.js'])

<div id="comment-section-{{ $post->id }}" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee;">
    <div style="max-height: 400px; overflow-y: auto; margin-bottom: 15px; padding-right: 5px;">

        @forelse($post->comments()->where('parent_id', null)->get() as $comment)
            @php $totalReplies = $comment->getTotalRepliesCount(); @endphp

            <div style="margin-bottom: 15px;">
                <div style="display: flex; gap: 10px; align-items: flex-start;">

                    <a href="{{ route('user.profile', $comment->user->id) }}">
                        <img src="{{ $comment->user->avatar_url }}" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; border: 1px solid #eee;">
                    </a>

                    <div style="background: #f0f2f5; padding: 8px 12px; border-radius: 15px; flex: 1; position: relative; padding-right: 50px;">
                        <a href="{{ route('user.profile', $comment->user->id) }}" style="text-decoration: none; color: #007bff; font-weight: bold; font-size: 13px; display: block;">
                            {{ $comment->user->name }}
                        </a>
                        <p style="margin: 0; font-size: 14px; color: #333;">{{ $comment->body }}</p>

                        <div style="display: flex; gap: 12px; align-items: center; margin-top: 4px;">
                            <small style="color: #999; font-size: 11px;">{{ $comment->created_at->diffForHumans() }}</small>

                            <button type="button" onclick="setupReply({{ $post->id }}, {{ $comment->id }}, '{{ $comment->user->name }}')" style="background: none; border: none; color: #65676b; font-size: 12px; font-weight: bold; cursor: pointer; padding: 0;">
                                {{ __('messages.reply') }}
                            </button>

                            @if($totalReplies > 0)
                                <button type="button" onclick="toggleRepliesBlock({{ $comment->id }}, this)" data-count="{{ $totalReplies }}" style="background: none; border: none; color: #007bff; font-size: 12px; font-weight: bold; cursor: pointer; padding: 0;">
                                    {{ __('messages.view_replies') }} ({{ $totalReplies }})
                                </button>
                            @endif
                        </div>

                        @can('delete', $comment)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="position: absolute; right: 30px; top: 8px;">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 11px; padding: 0;">✕</button>
                            </form>
                        @endcan

                        <div style="position: absolute; right: 8px; top: 6px; text-align: center;">
                            <form action="{{ route('comments.like', $comment->id) }}" method="POST">
                                @csrf
                                <button type="submit" style="background: none; border: none; cursor: pointer; font-size: 13px; padding: 0;">
                                    {{ $comment->commentLikes && $comment->commentLikes->where('user_id', auth()->id())->count() > 0 ? '❤️' : '🤍' }}
                                </button>
                            </form>
                            <small style="display: block; color: #777; font-size: 9px; margin-top: -2px;">{{ $comment->commentLikes ? $comment->commentLikes->count() : 0 }}</small>
                        </div>
                    </div>
                </div>

                @if($totalReplies > 0)
                    <div id="replies-block-{{ $comment->id }}" style="display: none; margin-left: 40px; margin-top: 8px; border-left: 2px solid #e4e6eb; padding-left: 10px;">
                        <x-comment-replies :replies="$comment->getAllReplies()" />
                    </div>
                @endif
            </div>
        @empty
            <p style="text-align: center; color: #999; font-size: 14px;">{{ Lang::has('messages.no_comments_yet') ? __('messages.no_comments_yet') : 'No comments yet' }}</p>
        @endforelse

    </div>

    <form action="{{ route('posts.comment', $post->id) }}" method="POST" id="main-comment-form-{{ $post->id }}" style="display: flex; gap: 8px; align-items: center; position: relative;">
        @csrf
        <input type="hidden" name="parent_id" id="parent-id-{{ $post->id }}" value="">
        <input type="text" name="body" id="comment-input-{{ $post->id }}" placeholder="{{ Lang::has('messages.write_comment') ? __('messages.write_comment') : 'Write a comment...' }}" required style="flex: 1; border: 1px solid #ddd; padding: 8px 15px; padding-right: 40px; border-radius: 20px; outline: none; font-size: 14px;">
        <button type="button" id="cancel-reply-{{ $post->id }}" onclick="resetCommentInput({{ $post->id }})" style="display: none; position: absolute; right: 55px; background: none; border: none; color: #999; cursor: pointer; font-size: 16px;">✕</button>
        <button type="submit" style="background: #007bff; color: white; border: none; padding: 0 15px; height: 36px; border-radius: 20px; cursor: pointer; font-weight: bold; display: flex; align-items: center; justify-content: center;">➤</button>
    </form>
</div>
<script>
    window.commentTranslations = {
        replyTo: "{{ __('messages.reply_to') }}",
        writeComment: "{{ __('messages.write_comment') }}",
        hideReplies: "{{ __('messages.hide_replies') }}",
        viewReplies: "{{ __('messages.view_replies') }}",
        defaultRoute: "{{ route('posts.comment', $post->id) }}",
        replyRoute: "{{ url('comments') }}"
    };
</script>
