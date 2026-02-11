<?php

namespace App\Listeners;

use App\Events\AuditEvent;
use App\Services\System\AuditService;

class AuditListener
{
    public function __construct(
        private readonly AuditService $auditService
    ) {}

    public function handle(AuditEvent $event): void
    {
        match ($event->action) {
            'created' => $this->auditService->logCreated($event->entity),
            'updated' => $this->auditService->logUpdated(
                $event->entity,
                $event->oldValues ?? [],
                $event->newValues ?? []
            ),
            'deleted' => $this->auditService->logDeleted($event->entity),
            default   => $this->auditService->log(
                $event->action,
                $event->entity,
                $event->oldValues,
                $event->newValues,
                $event->userId,
                $event->tenantId
            ),
        };
    }
}
