<?php

namespace App\Repositories\Finance;

use App\Contracts\Repositories\Finance\TransactionRepositoryInterface;
use App\Models\Transaction;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    protected array $filterable = [
        'type',
        'category_id',
        'budget_id',
        'tenant_id'
    ];

    protected array $searchable = [
        'description',
        'notes'
    ];

    protected array $sortable = [
        'transaction_date',
        'amount',
        'created_at'
    ];

    protected string $defaultSort = 'transaction_date';

    protected function applyFilters(Builder $query, array $filters): void
    {
        parent::applyFilters($query, $filters);

        // Date Range Filters
        if (isset($filters['start_date'])) {
            $query->whereDate('transaction_date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date'])) {
            $query->whereDate('transaction_date', '<=', $filters['end_date']);
        }
    }

    public function findOrFail(int $id): \Illuminate\Database\Eloquent\Model
    {
        $model = parent::findOrFail($id);
        
        if (auth()->check() && $model->tenant_id !== auth()->user()->current_tenant_id) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
        }

        return $model;
    }
}
