<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;


class InteractionController extends Controller
{
    use AuthorizesRequests;

    public function toggleLike(Post $post)
    {
        $like = $post->likes()->where('user_id', Auth::id())->first();
        $like ? $like->delete() : $post->likes()->create(['user_id' => Auth::id()]);
        Cache::flush();
        return back();
    }

    public function toggleSave(Post $post)
    {
        $save = $post->saves()->where('user_id', Auth::id())->first();
        $save ? $save->delete() : $post->saves()->create(['user_id' => Auth::id()]);
        Cache::flush();
        return back();
    }

    public function savedPosts()
    {
        $posts = Auth::user()->savedPosts()
            ->with(['user', 'images', 'likes', 'comments', 'saves'])
            ->latest()
            ->get();

        return view('posts.saved', compact('posts'));
    }

    public function storeComment(StoreCommentRequest $request, Post $post)
    {
        $post->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->validated()['body'],
        ]);
        Cache::flush();
        return back()->with('success', __('messages.comment_added'));
    }

    public function toggleCommentLike(Comment $comment)
    {
        $like = $comment->commentLikes()->where('user_id', Auth::id())->first();

        if ($like) {
            $like->delete();
        } else {
            $comment->commentLikes()->create(['user_id' => Auth::id()]);
        }
        Cache::flush();
        return back();
    }

    public function storeReply(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $comment->post_id,
            'parent_id' => $comment->id,
            'body' => $validated['body'],
        ]);
        Cache::flush();
        return back()->with('success', __('messages.reply_added'));
    }

    public function destroyComment(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        Cache::flush();
        return back()->with('success', __('messages.comment_deleted'));
    }
}
