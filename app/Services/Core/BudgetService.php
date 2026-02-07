<?php

namespace App\Services\Core;

use App\Contracts\Repositories\Core\BudgetRepositoryInterface;
use App\Contracts\Services\Core\BudgetServiceInterface;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;

class BudgetService extends BaseService implements BudgetServiceInterface
{

    public function __construct(BudgetRepositoryInterface $repository){
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $data['tenant_id'] = auth()->user()->current_tenant_id;

        return DB::transaction(function () use ($data) {
            $categories = $data['categories'] ?? [];
            unset($data['categories']);

            $budget = $this->repository->create($data);

            if (!empty($categories)) {
                $budget->categories()->sync(
                    collect($categories)->mapWithKeys(fn ($item) => [
                        $item['category_id'] => [
                            'allocated_amount' => $item['allocated_amount'],
                        ]
                    ])->toArray());
            }
            return $budget;

        });
    }

    public function update(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $budget = $this->repository->findOrFail($id);

            unset(
                $data['tenant_id'],
                $data['year'],
                $data['month']
            );

            $categories = $data['categories'] ?? null;
            unset($data['categories']);

            $budget = $this->repository->update($id, $data);

            if (is_array($categories)) {
                $budget->categories()->sync(
                    collect($categories)->mapWithKeys(fn ($item) => [
                        $item['category_id'] => [
                            'allocated_amount' => $item['allocated_amount'],
                        ]
                    ])->toArray()
                );
            }

            return $budget->load('categories');
        });
    }
}
