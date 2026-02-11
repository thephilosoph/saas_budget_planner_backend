<?php

namespace App\Repositories\Core;

use App\Contracts\Repositories\Core\BudgetRepositoryInterface;
use App\Models\Budget;
use App\Repositories\BaseRepository;

class BudgetRepository extends BaseRepository implements BudgetRepositoryInterface
{

    public function __construct(Budget $budget)
    {
        parent::__construct($budget);
    }

    protected array $filterable = [
        'total_income',
        'total_expense',
        'year',
        'month',
    ];

    protected array $searchable = [
        'name',
    ];

    protected array $sortable = [
        'created_at',
        'name',
    ];


}
