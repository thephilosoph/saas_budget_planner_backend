<?php

namespace App\Observers;

use App\Events\AuditEvent;
use Illuminate\Database\Eloquent\Model;

class AuditableObserver
{
    public function created(Model $model): void
    {
        if (!$this->shouldAudit($model, 'created')) return;

        AuditEvent::dispatch('created', $model);
    }

    public function updated(Model $model): void
    {
        if (!$this->shouldAudit($model, 'updated')) return;

        $oldValues = $model->getOriginal();
        $newValues = $model->getChanges();

        // Remove timestamps from comparison
        unset($oldValues['updated_at'], $newValues['updated_at']);

        AuditEvent::dispatch('updated', $model, $oldValues, $newValues);
    }

    public function deleted(Model $model): void
    {
        if (!$this->shouldAudit($model, 'deleted')) return;

        AuditEvent::dispatch('deleted', $model);
    }

    /**
     * Check if model should be audited.
     */
    protected function shouldAudit(Model $model, string $action): bool
    {
        // Skip if model has $auditEnabled = false
        if (property_exists($model, 'auditEnabled') && !$model->auditEnabled) {
            return false;
        }

        // Skip certain actions per model
        if (method_exists($model, 'shouldAudit')) {
            return $model->shouldAudit($action);
        }

        return true;
    }
}
