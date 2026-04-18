<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'user_id',
        'blog_category_id',
        'title',
        'slug',
        'short_description',
        'content',
        'featured_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'status',
        'published_at',
        'scheduled_at',
        'view_count',
        'allow_comments',
        'reading_time',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'allow_comments' => 'boolean',
    ];

    protected $dates = [
        'published_at',
        'scheduled_at',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'unique' => true,
                'reserved' => function ($slug, $model) {
                    return $model->status === 'published';
                },
            ],
        ];
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag', 'blog_post_id', 'blog_tag_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'blog_post_id');
    }

    public function approvedComments()
    {
        return $this->hasMany(BlogComment::class, 'blog_post_id')->where('is_approved', 1);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            });
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    public function getReadingTimeTextAttribute(): string
    {
        return $this->reading_time.' min read';
    }
}
