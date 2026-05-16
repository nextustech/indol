<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait SoftDeleteWithUser
{
    public static function bootSoftDeleteWithUser()
    {
        static::addGlobalScope('notDeleted', function ($builder) {
            $builder->where('isDeleted', 0);
        });
    }

    public function deleteRecord()
    {
        $this->update([
            'isDeleted' => 1,
            'deletedBy' => Auth::id(),
            'deleted_at' => now(),
        ]);

        $this->logAudit('soft_delete');
    }

    public function restoreRecord()
    {
        $this->update([
            'isDeleted' => 0,
            'deletedBy' => null,
            'deleted_at' => null,
        ]);

        $this->logAudit('restore');
    }

    public function forceDeleteRecord()
    {
        $this->logAudit('force_delete');
        $this->delete();
    }

    public function scopeWithDeleted($query)
    {
        return $query->withoutGlobalScope('notDeleted');
    }

    public function scopeOnlyDeleted($query)
    {
        return $query->withoutGlobalScope('notDeleted')
            ->where('isDeleted', 1);
    }

    public function isDeleted()
    {
        return $this->isDeleted === 1;
    }

    public function deletedByUser()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'deletedBy');
    }

    protected function logAudit($action)
    {
        try {
            AuditLog::create([
                'action' => $action,
                'model_type' => get_class($this),
                'model_id' => $this->id,
                'user_id' => Auth::id(),
                'details' => json_encode([
                    'model' => get_class($this),
                    'id' => $this->id,
                    'name' => $this->name ?? $this->title ?? $this->branchName ?? null,
                ]),
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
            ]);
        } catch (\Exception $e) {
            // Silently fail to not break delete operations
        }
    }
}
