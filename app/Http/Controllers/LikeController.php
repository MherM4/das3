<?php

namespace App\Http\Controllers;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {

        $this->authorize('toggle', $post);

        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
        } else {
            $post->likes()->create(['user_id' => auth()->id()]);
        }

        return back();
    }
}
