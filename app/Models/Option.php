<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Option extends Model
{
    use HasFactory, SoftDeleteWithUser;
    protected $guarded = [];
    public $timestamps = false;
}
