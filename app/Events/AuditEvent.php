<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuditEvent
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly string $action,
        public readonly Model $entity,
        public readonly ?array $oldValues = null,
        public readonly ?array $newValues = null,
        public readonly ?int $userId = null,
        public readonly ?int $tenantId = null
    ) {}
}
