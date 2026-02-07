<?php

namespace App\Contracts\Repositories\Core;

use App\Contracts\Repositories\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function get(array $filters = [],array $relations = [], ?int $perPage = null, ?callable $scope = null): Collection|LengthAwarePaginator;
    public function findOrFail(int $id): \Illuminate\Database\Eloquent\Model;
    public function create(array $data): \Illuminate\Database\Eloquent\Model;
    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model;
    public function delete(int $id): bool;
}
