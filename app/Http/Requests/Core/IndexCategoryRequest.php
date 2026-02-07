<?php

namespace App\Http\Requests\Core;

use App\Http\Requests\BaseIndexRequest;

class IndexCategoryRequest extends BaseIndexRequest
{
    protected array $allowedSorts = ['name', 'created_at'];
    protected array $allowedFilters = [
        'type'      => ['nullable', 'string', 'in:income,expense'],
        'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
    ];
    protected array $allowedRelations = ['transactions', 'parent'];
}
