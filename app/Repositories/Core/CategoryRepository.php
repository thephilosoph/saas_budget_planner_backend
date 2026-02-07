<?php

namespace App\Repositories\Core;

use App\Contracts\Repositories\Core\CategoryRepositoryInterface;
use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    protected array $filterable = [
        'type',
        'parent_id',
    ];

    protected array $searchable = [
        'name',
    ];

    protected array $sortable = [
        'created_at',
        'name',
    ];




}
