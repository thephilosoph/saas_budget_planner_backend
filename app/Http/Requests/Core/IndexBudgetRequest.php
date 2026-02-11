<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\BaseIndexRequest;

class IndexBudgetRequest extends BaseIndexRequest
{
    protected array $allowedSorts = [
        'name',
        'total_income',
        'total_expense',
        'created_at',
        'year',
        'month',
    ];

    protected array $allowedFilters = [
        'year'         => ['nullable', 'integer'],
        'month'        => ['nullable', 'integer'],
        'tenant_id'    => ['nullable', 'integer', 'exists:tenants,id'], // Though scoped in service usually
    ];

    protected array $allowedRelations = [
        'categories',
        'categories.transactions',
    ];
}
