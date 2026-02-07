<?php

namespace App\Repositories;

use App\Contracts\Repositories\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;
    protected array $filterable = [];
    protected array $searchable = [];
    protected array $sortable = ['created_at'];

    protected string $defaultSort = 'created_at';
    protected string $defaultDirection = 'desc';
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function findById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function get(
        array $filters = [],
        array $relations = [],
        ?int $perPage = null,
        ?callable $scope = null
    ): Collection|LengthAwarePaginator {

        $query = $this->model->newQuery()->with($relations);

        if ($scope) {
            $scope($query); // tenant / plan / soft rules
        }

        $this->applyFilters($query, $filters);
        $this->applySearch($query, $filters);
        $this->applySorting($query, $filters);

        return $perPage
            ? $query->paginate($perPage)
            : $query->get();
    }



    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Model
    {
        $record =  $this->findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function delete(int $id): bool
    {
        return $this->findOrFail($id)->delete();
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }


    protected function applyFilters(Builder $query, array $filters): void
    {

        foreach ($filters['filters'] as $filter => $value) {
            if (!in_array($filter, $this->filterable, true)) {
                continue;
            }
            is_array($value)
                ? $query->whereIn($filter, $value)
                : $query->where($filter, $value);
        }
    }

    protected function applySorting(Builder $query, array $filters): void
    {
        $sort = $filters['sort'] ?? $this->defaultSort;
        $direction = $filters['direction'] ?? $this->defaultDirection;

        if (!in_array($sort, $this->sortable, true)) {
            $sort = $this->defaultSort;
        }

        $query->orderBy($sort, $direction);
    }


    protected function applySearch(Builder $query, array $filters): void
    {
        if (!isset($filters['search']) || empty($this->searchable)) {
            return;
        }

        $query->where(function ($q) use ($filters) {
            foreach ($this->searchable as $column) {
                $q->orWhere($column, 'LIKE', '%' . $filters['search'] . '%');
            }
        });
    }


}
