<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BlogCategory::class, 'parent_id');
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'blog_category_id');
    }

    public function publishedPosts()
    {
        return $this->hasMany(BlogPost::class, 'blog_category_id')->published();
    }
}
