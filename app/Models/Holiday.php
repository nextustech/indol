<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

        protected $fillable = [
        'branch_id',
        'name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'is_full_day',
        'is_recurring'
    ];

    // Belongs to Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
