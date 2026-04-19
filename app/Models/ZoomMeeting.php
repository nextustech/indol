<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'topic',
        'agenda',
        'start_time',
        'duration',
        'timezone',
        'join_url',
        'start_url',
        'password',
        'host_email',
        'host_join_url',
        'status',
        'type',
        'created_by',
        'settings'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'settings' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now())
            ->where('status', 'scheduled');
    }

    public function scopePast($query)
    {
        return $query->where('start_time', '<', now())
            ->orWhereIn('status', ['ended', 'cancelled']);
    }
}