<?php

namespace App\Observers;

use App\Models\BlogPost;
use Illuminate\Support\Str;

class BlogPostObserver
{
    public function creating(BlogPost $post): void
    {
        if (empty($post->slug)) {
            $post->slug = Str::slug($post->title);
        }

        if (empty($post->reading_time) && $post->content) {
            $wordCount = str_word_count(strip_tags($post->content));
            $post->reading_time = max(1, ceil($wordCount / 200));
        }

        if ($post->status === 'published' && empty($post->published_at)) {
            $post->published_at = now();
        }
    }

    public function updating(BlogPost $post): void
    {
        if ($post->isDirty('title') && ! $post->isDirty('slug')) {
            $post->slug = Str::slug($post->title);
        }

        if ($post->isDirty('content') && ! $post->isDirty('reading_time')) {
            $wordCount = str_word_count(strip_tags($post->content));
            $post->reading_time = max(1, ceil($wordCount / 200));
        }

        if ($post->status === 'published' && ! $post->isDirty('published_at')) {
            if (! $post->published_at || $post->published_at->isFuture()) {
                $post->published_at = now();
            }
        }
    }
}
