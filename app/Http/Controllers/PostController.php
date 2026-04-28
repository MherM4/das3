<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'images', 'likes', 'comments'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function userPosts(User $user)
    {
        $posts = $user->posts()->with('images')->latest()->get();
        return view('user.profile', compact('user', 'posts'));
    }

    public function manage()
    {
        $posts = Auth::user()->posts()->with('images')->latest()->get();
        return view('posts.manage', compact('posts'));
    }

    public function edit(Post $post)
    {
        if (auth()->id() !== $post->user_id && auth()->user()->role !== 'admin' && auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->id() !== $post->user_id && auth()->user()->role !== 'admin' && auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('posts'), $imageName);
                $post->images()->create(['image' => 'posts/' . $imageName]);
            }
        }

        return redirect()->route('posts.manage')->with('success', 'Գրառումը թարմացվեց:');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->validated());

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('posts'), $imageName);
                $post->images()->create(['image' => 'posts/' . $imageName]);
            }
        }

        return redirect('/')->with('success', 'Գրառումը հաջողությամբ ստեղծվեց:');
    }

    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id && auth()->user()->role !== 'admin' && auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        $post->deleted_by = auth()->id();
        $post->save();

        $post->delete();

        return back()->with('success', 'Գրառումը տեղափոխվեց աղբաման:');
    }

    public function myTrash()
    {
        $posts = Auth::user()->posts()
            ->onlyTrashed()
            ->where('deleted_by', Auth::id())
            ->with('images')
            ->latest()
            ->get();

        return view('posts.trash', [
            'posts' => $posts,
            'title' => 'Իմ աղբամանը'
        ]);
    }

    public function adminTrash()
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin') {
            abort(403);
        }

        $posts = Post::onlyTrashed()->with(['user', 'images', 'deleter'])->latest()->get();

        return view('posts.trash', [
            'posts' => $posts,
            'title' => 'Ընդհանուր աղբաման (Admin)'
        ]);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);

        if ($post->deleted_by !== auth()->id() && auth()->user()->role === 'user') {
            abort(403, 'Դուք չեք կարող վերականգնել Admin-ի կողմից ջնջված գրառումը:');
        }

        $post->restore();

        $post->deleted_by = null;
        $post->save();

        return back()->with('success', 'Գրառումը վերականգնվեց:');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->with('images')->findOrFail($id);
        $currentUser = Auth::user();

        if ($currentUser->id === $post->user_id || $currentUser->role === 'admin' || $currentUser->role === 'super_admin') {

            foreach ($post->images as $postImage) {
                $filePath = public_path($postImage->image);
                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            }

            $post->forceDelete();

            return back()->with('success', 'Գրառումը վերջնականապես ջնջվեց:');
        }

        return abort(403);
    }
}
