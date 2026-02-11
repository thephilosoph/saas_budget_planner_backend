<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\BaseIndexRequest;

class IndexTransactionRequest extends BaseIndexRequest
{
    protected array $allowedSorts = [
        'id',
        'description',
        'amount',
        'currency',
        'transaction_date',
        'type',
        'payment_method',
        'created_at',
        'updated_at',
    ];

    protected array $allowedFilters = [
        'category_id'       => ['nullable', 'integer', 'exists:categories,id'],
        'budget_id'         => ['nullable', 'integer', 'exists:budgets,id'],
        'created_by'        => ['nullable', 'integer', 'exists:users,id'],
        'type'              => ['nullable', 'string', 'in:income,expense'],
        'currency'          => ['nullable', 'string', 'size:3'],
        'payment_method'    => ['nullable', 'string', 'max:255'],
        'amount_min'        => ['nullable', 'numeric', 'min:0'],
        'amount_max'        => ['nullable', 'numeric', 'min:0'],
        'transaction_date_from' => ['nullable', 'date'],
        'transaction_date_to'   => ['nullable', 'date', 'after_or_equal:transaction_date_from'],
        'has_notes'         => ['nullable', 'boolean'],
        'has_metadata'      => ['nullable', 'boolean'],
    ];

    protected array $allowedRelations = [
        'category',
        'category.budget',
        'budget',
        'createdBy',
        'tenant',
    ];

    /**
     * Get transaction type filter.
     */
    public function type(): ?string
    {
        return $this->validated()['type'] ?? null;
    }

    /**
     * Get date range filters.
     */
    public function dateRange(): array
    {
        return [
            'from' => $this->validated()['transaction_date_from'] ?? null,
            'to'   => $this->validated()['transaction_date_to'] ?? null,
        ];
    }

    /**
     * Get amount range filters.
     */
    public function amountRange(): array
    {
        return [
            'min' => $this->validated()['amount_min'] ?? null,
            'max' => $this->validated()['amount_max'] ?? null,
        ];
    }

    /**
     * Get category ID filter.
     */
    public function categoryId(): ?int
    {
        return $this->validated()['category_id'] ?? null;
    }

    /**
     * Get budget ID filter.
     */
    public function budgetId(): ?int
    {
        return $this->validated()['budget_id'] ?? null;
    }
}
