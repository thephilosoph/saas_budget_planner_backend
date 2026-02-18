<?php

namespace App\Services\Finance;

use App\Contracts\Repositories\Finance\TransactionRepositoryInterface;
use App\Contracts\Services\Finance\TransactionServiceInterface;
use App\Enums\UsageTrackingMetric;
use App\Events\TransactionCreated;
use App\Models\Transaction;
use App\Services\BaseService;
use App\Services\Usage\PlanLimitService;
use Illuminate\Support\Facades\Auth;

class TransactionService extends BaseService implements TransactionServiceInterface
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        private PlanLimitService $planLimitService
    ) {
        $this->repository = $transactionRepository;
    }

    public function create(array $data)
    {
        $user = Auth::user();
        $tenant_id = $user->current_tenant_id;
        $this->planLimitService->ensureCanPerform(
            $tenant_id,
            UsageTrackingMetric::TRANSACTIONS_COUNT
        );

        if (Auth::check()) {
            $data['created_by'] = $user->id;
        }
        $transaction =  parent::create($data);

        TransactionCreated::dispatch($transaction);

        return $transaction;


    }

    // list, update, delete, findOrFail are handled by BaseService
}
