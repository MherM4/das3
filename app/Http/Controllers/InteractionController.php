<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;use App\Models\Post;
use App\Models\Like;
use App\Models\Save;
use App\Models\Comment;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    public function toggleLike(Post $post) {
        $like = $post->likes()->where('user_id', auth()->id())->first();
        if ($like) {
            $like->delete();
        } else {
            $post->likes()->create(['user_id' => auth()->id()]);
        }
        return back();
    }

    public function toggleSave(Post $post) {
        $save = $post->saves()->where('user_id', auth()->id())->first();
        if ($save) {
            $save->delete();
        } else {
            $post->saves()->create(['user_id' => auth()->id()]);
        }
        return back();
    }

    public function savedPosts() {
        $posts = auth()->user()->savedPosts()
            ->with(['user', 'images', 'likes', 'comments', 'saves'])
            ->latest()
            ->get();

        return view('posts.saved', compact('posts'));
    }

    public function storeComment(StoreCommentRequest $request, Post $post)
{
    $post->comments()->create([
        'user_id' => auth()->id(),
        'body' => $request->validated()['body'] 
    ]);

    return back();
}

    public function destroyComment(Comment $comment) {
        if (auth()->id() === $comment->user_id ||
            auth()->id() === $comment->post->user_id ||
            auth()->user()->role === 'admin' ||
            auth()->user()->role === 'super_admin') {

            $comment->delete();
            return back()->with('success', 'Մեկնաբանությունը ջնջվեց:');
        }

        return back()->with('error', 'Դուք չունեք թույլտվություն:');
    }
}
