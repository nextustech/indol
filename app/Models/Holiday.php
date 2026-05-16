<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Holiday extends Model
{
    use HasFactory, SoftDeleteWithUser;

        protected $fillable = [
        'branch_id',
        'name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'is_full_day',
        'is_recurring',
        'isDeleted',
        'deletedBy',
        'deleted_at',
    ];

    // Belongs to Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
