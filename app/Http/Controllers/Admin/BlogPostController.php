<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with(['author', 'category'])
            ->when(request('status'), fn ($q, $s) => $q->where('status', $s))
            ->when(request('category'), fn ($q, $c) => $q->where('blog_category_id', $c))
            ->when(request('search'), fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $categories = BlogCategory::where('status', 1)->orderBy('name')->get();

        return view('admin.blog.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', 1)->orderBy('name')->get();
        $tags = BlogTag::orderBy('name')->get();

        return view('admin.blog.posts.form', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'slug' => 'nullable|string|max:191|unique:blog_posts,slug',
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:191',
            'meta_title' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string|max:191',
            'og_title' => 'nullable|string|max:191',
            'og_description' => 'nullable|string|max:300',
            'og_image' => 'nullable|string|max:191',
            'status' => 'nullable|in:draft,published,scheduled',
            'scheduled_at' => 'nullable|date',
            'allow_comments' => 'nullable|boolean',
        ]);

        $data['user_id'] = auth()->id();
        $data['slug'] = $request->slug ?? Str::slug($request->title);
        $data['allow_comments'] = $request->has('allow_comments');

        if ($request->status === 'published') {
            $data['published_at'] = now();
        } elseif ($request->scheduled_at) {
            $data['scheduled_at'] = $request->scheduled_at;
        }

        $post = BlogPost::create($data);

        if ($request->tag_ids) {
            $post->tags()->sync($request->tag_ids);
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post Created Successfully');
    }

    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::where('status', 1)->orderBy('name')->get();
        $tags = BlogTag::orderBy('name')->get();
        $selectedTags = $post->tags->pluck('id')->toArray();

        return view('admin.blog.posts.form', compact('post', 'categories', 'tags', 'selectedTags'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:191',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'slug' => 'nullable|string|max:191|unique:blog_posts,slug,'.$post->id,
            'short_description' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:191',
            'meta_title' => 'nullable|string|max:191',
            'meta_description' => 'nullable|string|max:300',
            'meta_keywords' => 'nullable|string|max:191',
            'og_title' => 'nullable|string|max:191',
            'og_description' => 'nullable|string|max:300',
            'og_image' => 'nullable|string|max:191',
            'status' => 'nullable|in:draft,published,scheduled',
            'scheduled_at' => 'nullable|date',
            'allow_comments' => 'nullable|boolean',
        ]);

        $data['slug'] = $request->slug ?? $post->slug;
        $data['allow_comments'] = $request->has('allow_comments');

        if ($request->status === 'published' && ! $post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        if ($request->tag_ids) {
            $post->tags()->sync($request->tag_ids);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post Updated Successfully');
    }

    public function destroy(BlogPost $post)
    {
        $post->delete();

        return redirect()->route('admin.blog.posts.index')
            ->with('success', 'Post Deleted Successfully');
    }

    public function comments()
    {
        $comments = BlogComment::with(['post', 'parent'])
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.blog.comments.index', compact('comments'));
    }

    public function approveComment(BlogComment $comment)
    {
        $comment->update(['is_approved' => 1]);

        return back()->with('success', 'Comment Approved');
    }

    public function deleteComment(BlogComment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment Deleted');
    }
}
