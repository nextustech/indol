<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogTag extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tag', 'blog_tag_id', 'blog_post_id');
    }
}
