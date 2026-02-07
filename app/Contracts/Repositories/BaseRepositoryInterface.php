<?php

namespace App\Contracts\Repositories;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    public function findById(int $id): ?Model;
    public function findOrFail(int $id): Model;

    public function get(
        array $filters = [],
        array $relations = [],
        ?int $perPage = null,
        ?callable $scope = null
    ): Collection|LengthAwarePaginator;

    public function create(array $data): Model;
    public function update(int $id, array $data): Model;
    public function delete(int $id): bool;

    public function query();
}
