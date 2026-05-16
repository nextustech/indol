<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Traits\HomePhysiotherapistTrait;
use App\Traits\SoftDeleteWithUser;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, HomePhysiotherapistTrait, SoftDeleteWithUser;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'isDeleted',
        'deletedBy',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
