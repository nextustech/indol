<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = BlogPost::Published()
            ->with(['author', 'category', 'tags'])
            ->when($request->category, fn ($q, $c) => $q->where('blog_category_id', $c))
            ->when($request->tag, fn ($q, $t) => $q->whereHas('tags', fn ($q) => $q->where('slug', $t)))
            ->when($request->search, fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = BlogCategory::where('status', 1)
            ->withCount('publishedPosts')
            ->orderBy('name')
            ->get();

        $recentPosts = BlogPost::Published()
            ->recent()
            ->limit(5)
            ->get();

        $popularPosts = BlogPost::Published()
            ->popular()
            ->limit(5)
            ->get();

        $tags = BlogTag::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(20)
            ->get();

        return view('blog.index', compact('posts', 'categories', 'recentPosts', 'popularPosts', 'tags'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->with(['author', 'category', 'tags', 'approvedComments'])
            ->firstOrFail();

        if ($post->status !== 'published') {
            if (! Auth::check() || ! Auth::user()->can('manage-blog')) {
                abort(404);
            }
        }

        $post->incrementViewCount();

        $relatedPosts = BlogPost::Published()
            ->where('id', '!=', $post->id)
            ->where('blog_category_id', $post->blog_category_id)
            ->limit(3)
            ->get();

        $recentPosts = BlogPost::Published()
            ->recent()
            ->where('id', '!=', $post->id)
            ->limit(5)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts', 'recentPosts'));
    }

    public function category(string $slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();

        $posts = BlogPost::Published()
            ->where('blog_category_id', $category->id)
            ->with(['author', 'category'])
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = BlogCategory::where('status', 1)
            ->withCount('publishedPosts')
            ->orderBy('name')
            ->get();

        $recentPosts = BlogPost::Published()
            ->recent()
            ->limit(5)
            ->get();

        return view('blog.category', compact('category', 'posts', 'categories', 'recentPosts'));
    }

    public function tag(string $slug)
    {
        $tag = BlogTag::where('slug', $slug)->firstOrFail();

        $posts = $tag->posts()
            ->Published()
            ->with(['author', 'category'])
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = BlogCategory::where('status', 1)
            ->withCount('publishedPosts')
            ->orderBy('name')
            ->get();

        $recentPosts = BlogPost::Published()
            ->recent()
            ->limit(5)
            ->get();

        return view('blog.tag', compact('tag', 'posts', 'categories', 'recentPosts'));
    }

    public function comment(Request $request, BlogPost $post)
    {
        if (! $post->allow_comments) {
            return back()->with('error', 'Comments are disabled for this post');
        }

        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'comment' => 'required|string',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ]);

        $post->comments()->create($data);

        return back()->with('success', 'Comment submitted successfully. It will be visible after approval.');
    }
}
