<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Requests\FilterPostRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(FilterPostRequest $request)
    {
        $query = Post::with(['user', 'images', 'likes', 'comments', 'category', 'tags']);
        $validated = $request->validated();

        if (!empty($validated['category_id'])) {
            $query->where('category_id', $validated['category_id']);
        }

        if (!empty($validated['search'])) {
            $search = $validated['search'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('body', 'LIKE', "%{$search}%")
                  ->orWhereHas('tags', function($t) use ($search) {
                      $t->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $posts = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function store(StorePostRequest $request)
    {
        $post = auth()->user()->posts()->create($request->validated());

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $this->uploadImage($file);
                $post->images()->create(['image' => $path]);
            }
        }

        return redirect('/')->with('success', __('messages.post_succs_created'));
    }

    public function manage()
    {
        $posts = Auth::user()->posts()->with('images')->latest()->get();
        return view('posts.manage', compact('posts'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $tags = Tag::all();
        $categories = Category::all();

        return view('posts.edit', compact('post','tags','categories'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());
        $post->tags()->sync($request->tags);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $this->uploadImage($file);
                $post->images()->create(['image' => $path]);
            }
        }

        return redirect()->route('posts.manage')->with('success', __('messages.post_updated'));
    }

    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('posts.create', compact('tags','categories'));
    }

    public function destroy(Post $post)
    {
        $this->authorize('update', $post);
        $post->deleted_by = auth()->id();
        $post->save();
        $post->delete();

        return back()->with('success', __('messages.post_moved_trash'));
    }

    public function myTrash()
    {
        $posts = Auth::user()->posts()->onlyTrashed() ->where('deleted_by', Auth::id()) ->with('images') ->latest() ->get();
        return view('posts.trash', [
            'posts' => $posts,
            'title' => __('messages.my_trash')
        ]);
    }

    public function adminTrash()
    {
        $posts = Post::onlyTrashed()->with(['user', 'images', 'deleter'])->latest()->get();

        return view('posts.trash', [
            'posts' => $posts,
            'title' =>  __('messages.general_trash')
        ]);
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('restore', $post);

        $post->restore();
        $post->deleted_by = null;
        $post->save();

        return back()->with('success', __('messages.post_restored'));
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->with('images')->findOrFail($id);

        $this->authorize('forceDelete', $post);

        foreach ($post->images as $postImage) {
            if (Storage::disk('public')->exists($postImage->image)) {
                Storage::disk('public')->delete($postImage->image);
            }
        }

        $post->forceDelete();

        return back()->with('success', __('messages.post_force_deleted'));
    }

    protected function uploadImage($file): string
    {
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('posts', $imageName, 'public');
    }
}
