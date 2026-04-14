<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_title',
        'title',
        'highlight_word',
        'description',
        'button_text',
        'button_link',
        'video_url',
        'image',
        'order',
        'status'
    ];
}
