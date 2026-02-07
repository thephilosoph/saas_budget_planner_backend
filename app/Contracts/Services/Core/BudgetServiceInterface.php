<?php

namespace App\Contracts\Services\Core;

use App\Contracts\Services\BaseServiceInterface;

interface BudgetServiceInterface extends BaseServiceInterface
{
    public function list(array $filters = []);
    public function findOrFail(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
}
