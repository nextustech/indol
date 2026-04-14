<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
            'title',
            'slug',
            'banner_image',
            'main_image',
            'extraImageA',
            'extraImageB',
            'short_description',
            'description'
            ];
}
