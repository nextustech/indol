<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::withCount('posts')
            ->orderBy('name')
            ->get();

        return view('admin.blog.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.blog.tags.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191|unique:blog_tags,name',
            'slug' => 'nullable|string|max:191|unique:blog_tags,slug',
        ]);

        $data['slug'] = $request->slug ?? Str::slug($request->name);

        BlogTag::create($data);

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'Tag Created Successfully');
    }

    public function edit(BlogTag $tag)
    {
        return view('admin.blog.tags.form', compact('tag'));
    }

    public function update(Request $request, BlogTag $tag)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191|unique:blog_tags,name,'.$tag->id,
            'slug' => 'nullable|string|max:191|unique:blog_tags,slug,'.$tag->id,
        ]);

        $data['slug'] = $request->slug ?? $tag->slug;

        $tag->update($data);

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'Tag Updated Successfully');
    }

    public function destroy(BlogTag $tag)
    {
        $tag->delete();

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'Tag Deleted Successfully');
    }
}
