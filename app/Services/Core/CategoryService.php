<?php

namespace App\Services\Core;

use App\Contracts\Repositories\Core\CategoryRepositoryInterface;
use App\Contracts\Services\BaseServiceInterface;
use App\Contracts\Services\Core\CategoryServiceInterface;
use App\Models\Category;
use App\Services\BaseService;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $data['tenant_id'] = auth()->user()->current_tenant_id;
        return $this->repository->create($data);
    }

}
