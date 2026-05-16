<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Response extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $guarded = [];
}
