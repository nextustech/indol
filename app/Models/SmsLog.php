<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SmsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'to',
        'message',
        'template_key',
        'status',
        'external_id',
        'attempts',
        'max_attempts',
        'error_message',
        'sendable_id',
        'sendable_type',
        'user_id',
        'sent_at',
        'delivered_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function sendable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function markAsSent(string $externalId = null): void
    {
        $this->update([
            'status' => 'sent',
            'external_id' => $externalId,
            'sent_at' => now(),
        ]);
    }

    public function markAsFailed(string $errorMessage = null): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }

    public function markAsDelivered(): void
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
    }

    public function canRetry(): bool
    {
        return $this->status === 'pending' && $this->attempts < $this->max_attempts;
    }

    public function incrementAttempt(): void
    {
        $this->increment('attempts');
    }
}