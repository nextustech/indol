<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Service extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable = [
            'title',
            'slug',
            'banner_image',
            'main_image',
            'extraImageA',
            'extraImageB',
            'short_description',
            'description',
            'isDeleted',
            'deletedBy',
            'deleted_at',
            ];
}
