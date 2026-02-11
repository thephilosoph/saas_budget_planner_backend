<?php

namespace App\Traits;

use App\Observers\AuditableObserver;

trait Auditable
{
    public static function bootAuditable(): void
    {
        static::observe(AuditableObserver::class);
    }

    /**
     * Get audit logs for this model.
     */
    public function auditLogs()
    {
        return $this->morphMany(\App\Models\AuditLog::class, 'entity');
    }

    /**
     * Get latest audit log.
     */
    public function latestAudit()
    {
        return $this->auditLogs()->latest()->first();
    }
}
