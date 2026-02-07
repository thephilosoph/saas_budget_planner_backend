<?php

namespace App\Enums;

enum UsageTrackingMetric: string
{
case TRANSACTION_COUNT = "transaction_count";
case STORAGE_MB = "storage_mb";
case CSV_IMPORT = "csv_import";

function label(): string
{
    return match ($this) {
        self::TRANSACTION_COUNT => "Transaction Count",
        self::STORAGE_MB => "Storage MB",
        self::CSV_IMPORT => "CSV Import",
    };
}
}
