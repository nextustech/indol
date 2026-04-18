<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::with('parent')
            ->withCount('posts')
            ->orderBy('order')
            ->get();

        return view('admin.blog.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', 1)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view('admin.blog.categories.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:blog_categories,slug',
            'parent_id' => 'nullable|exists:blog_categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:191',
            'order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $data['slug'] = $request->slug ?? Str::slug($request->name);
        $data['order'] = $request->order ?? 0;
        $data['status'] = $request->status ?? 1;

        BlogCategory::create($data);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category Created Successfully');
    }

    public function edit(BlogCategory $category)
    {
        $categories = BlogCategory::where('status', 1)
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.blog.categories.form', compact('category', 'categories'));
    }

    public function update(Request $request, BlogCategory $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:blog_categories,slug,'.$category->id,
            'parent_id' => 'nullable|exists:blog_categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:191',
            'order' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        $data['slug'] = $request->slug ?? $category->slug;
        $data['order'] = $request->order ?? 0;
        $data['status'] = $request->status ?? 1;

        $category->update($data);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy(BlogCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category Deleted Successfully');
    }
}
