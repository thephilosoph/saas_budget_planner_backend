<?php

namespace App\Services\Finance;

use App\Contracts\Repositories\Finance\TransactionRepositoryInterface;
use App\Contracts\Services\Finance\TransactionServiceInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class TransactionService extends BaseService implements TransactionServiceInterface
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository
    ) {
        $this->repository = $transactionRepository;
    }

    public function create(array $data)
    {
        // Automatically assign tenant_id and created_by if not provided
        if (Auth::check()) {
            $data['tenant_id'] = Auth::user()->current_tenant_id;
            $data['created_by'] = Auth::id();
        }

        return parent::create($data);
    }

    // list, update, delete, findOrFail are handled by BaseService
}
