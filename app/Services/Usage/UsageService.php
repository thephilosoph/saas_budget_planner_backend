<?php

namespace App\Services\Usage;

use App\Enums\UsageTrackingMetric;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsageService
{
    public function increment(
        int $tenantId,
        UsageTrackingMetric $metric,
        int $amount = 1,
        ?Carbon $date = null
    ): void {
        $date = $date ?? now();

        DB::statement("
            INSERT INTO usage_trackings
                (tenant_id, metric, value, year, month, day, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())
            ON DUPLICATE KEY UPDATE value = value + ?
        ", [
            $tenantId,
            $metric->value,
            $amount,
            $date->year,
            $date->month,
            $date->day,
            $amount
        ]);
    }

    public function getCurrentUsage(int $tenantId, UsageTrackingMetric $metric): int
    {
        return DB::table('usage_trackings')
            ->where('tenant_id', $tenantId)
            ->where('metric', $metric->value)
            ->where('year', now()->year)
            ->where('month', now()->month)
            ->sum('value');
    }
}
