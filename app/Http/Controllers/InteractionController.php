<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Post;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    use AuthorizesRequests;
    public function toggleLike(Post $post)
    {
        $like = $post->likes()->where('user_id', Auth::id())->first();
        $like ? $like->delete() : $post->likes()->create(['user_id' => Auth::id()]);

        return back();
    }

    public function toggleSave(Post $post)
    {
        $save = $post->saves()->where('user_id', Auth::id())->first();
        $save ? $save->delete() : $post->saves()->create(['user_id' => Auth::id()]);

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
            'body' => $request->validated()['body']
        ]);

        return back()->with('success', 'Մեկնաբանությունը ավելացվեց:');
    }

    public function destroyComment(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return back()->with('success', 'Մեկնաբանությունը ջնջվեց:');
    }
}
