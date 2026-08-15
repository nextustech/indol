<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeleteWithUser;

class Investigation extends Model
{
    use HasFactory, SoftDeleteWithUser;

    protected $fillable = [
        'assessment_id', 'type', 'investigation_date', 'findings', 'facility',
        'isDeleted', 'deletedBy', 'deleted_at',
    ];

    protected $casts = [
        'investigation_date' => 'date',
        'deleted_at' => 'datetime',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
