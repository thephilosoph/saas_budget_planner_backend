<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Request;
use App\Http\Resources\BaseResource;

class BudgetResource extends BaseResource
{
    protected function attributes($request): array
    {
        return [
            'name' => $this->name,
            'year' => $this->year,
            'month' => $this->month,
            'currency' => $this->currency,
            'totals' => [
                'income'  => (float) $this->total_income,
                'expense' => (float) $this->total_expense,
            ],
        ];
    }

    protected function includeRelations($request): array
    {
        return [
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(fn ($category) => [
                    'id'   => $category->id,
                    'name' => $category->name,
                    'type' => $category->type,
                    'allocated_amount' => (float) $category->pivot->allocated_amount,
                    'spent_amount'     => (float) $category->pivot->spent_amount,
                ]);
            }),
        ];
    }
}
