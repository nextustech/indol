<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class DropdownOption extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable = [
        'type', 'name', 'created_by',
        'isDeleted', 'deletedBy', 'deleted_at',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}