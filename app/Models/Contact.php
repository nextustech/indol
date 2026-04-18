<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    const STATUS_NEW = 'new';

    const STATUS_READ = 'read';

    const STATUS_REPLIED = 'replied';

    const STATUS_ARCHIVED = 'archived';

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true, 'status' => self::STATUS_READ]);
    }
}
