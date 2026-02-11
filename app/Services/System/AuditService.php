<?php

namespace App\Services\System;

use App\Enums\LogAction;
use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class AuditService
{
    public function log(
        string $action,
        Model $entity,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?int $userId = null,
        ?int $tenantId = null
    ): AuditLog {
        return AuditLog::create([
            'tenant_id'   => $tenantId ?? $this->getTenantId($entity),
            'user_id'     => $userId ?? auth()->id(),
            'action'      => $action,
            'entity_type' => get_class($entity),
            'entity_id'   => $entity->id,
            'old_values'  => $oldValues ?  : null,
            'new_values'  => $newValues ?  : null,
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::userAgent(),
        ]);
    }

    public function logCreated(Model $entity): AuditLog
    {
        return $this->log(
            LogAction::CREATE->value,
            $entity,
            null,
            $entity->toArray()
        );
    }

    public function logUpdated(Model $entity, array $oldValues, array $newValues): ?AuditLog
    {
        // Only log if there are actual changes
        $changes = array_diff_assoc($newValues, $oldValues);

        if (empty($changes)) {
            return null;
        }

        return $this->log(
            LogAction::UPDATE->value,
            $entity,
            array_intersect_key($oldValues, $changes),
            $changes
        );
    }

    public function logDeleted(Model $entity): AuditLog
    {
        return $this->log(
            LogAction::DELETE->value,
            $entity,
            $entity->toArray(),
            null
        );
    }

    public function logExported(string $entityType, array $filters = []): AuditLog
    {
        return $this->log(
            LogAction::EXPORT->value,
            new class(['id' => 0]) extends Model {
                protected $table = 'virtual_export';
            },
            null,
            ['entity_type' => $entityType, 'filters' => $filters]
        );
    }

    private function getTenantId(Model $entity): ?int
    {
        if (method_exists($entity, 'getTenantId')) {
            return $entity->getTenantId();
        }

        return $entity->tenant_id ?? null;
    }
}
