<?php

namespace App\Exceptions;

use App\Enums\UsageTrackingMetric;
use Exception;

class PlanLimitExceededException extends Exception
{
    public function __construct(
        public readonly UsageTrackingMetric $metric,
        public readonly int $limit,
        public readonly int $currentUsage
    ) {
        parent::__construct(
            "You reached your {$metric->label()} monthly limit ({$limit}). Current usage: {$currentUsage}",
            429
        );
    }

    public function render($request)
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => 'PLAN_LIMIT_EXCEEDED',
                'metric' => $this->metric->value,
                'limit' => $this->limit,
                'current_usage' => $this->currentUsage,
            ]
        ], 429);
    }
}
