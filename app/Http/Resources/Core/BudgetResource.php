<?php

namespace App\Http\Resources\Core;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'year' => $this->year,
            'month' => $this->month,
            'currency' => $this->currency,

            'totals' => [
                'income'  => (float) $this->total_income,
                'expense' => (float) $this->total_expense,
            ],

            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(fn ($category) => [
                    'id'   => $category->id,
                    'name' => $category->name,
                    'type' => $category->type,

                    'allocated_amount' => (float) $category->pivot->allocated_amount,
                    'spent_amount'     => (float) $category->pivot->spent_amount,
                ]);
            }),

            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
