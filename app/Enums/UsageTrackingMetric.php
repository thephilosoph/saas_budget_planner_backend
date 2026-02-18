<?php

namespace App\Enums;

enum UsageTrackingMetric: string
{
    case TRANSACTIONS_COUNT = 'transactions';
    case STORAGE_MB = 'storage_mb';
    case CSV_IMPORTS = 'csv_imports';
    case EXPORTS_COUNT = 'exports';
    case SEATS_USED = 'seats';


    public function limitKey(): string
    {
        return $this->value;
    }
function label(): string
{
    return match ($this) {
        self::TRANSACTIONS_COUNT => "Transaction Count",
        self::STORAGE_MB => "Storage MB",
        self::CSV_IMPORTS => "CSV Import",
        self::EXPORTS_COUNT => "Exports Count",
        self::SEATS_USED => "Seats Used",
    };
}
}
