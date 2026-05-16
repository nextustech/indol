<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class SmsTemplate extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable = [
        'key',
        'name',
        'content',
        'description',
        'is_active',
        'priority',
        'isDeleted',
        'deletedBy',
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    public function isActive(): bool
    {
        return $this->is_active === true;
    }
}