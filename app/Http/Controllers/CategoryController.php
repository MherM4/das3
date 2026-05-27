<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\Admin\StoreCategoryRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('create', Category::class);
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(StoreCategoryRequest $request)
    {

        $this->authorize('create', Category::class);
        
         Category::create([
            'name' => [
                'hy' => $request->name_hy,
                'en' => $request->name_en,
            ],
        ]);
        return back()->with('success', __('messages.category_added'));
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();
        return back()->with('success', __('messages.category_deleted'));
    }
}
