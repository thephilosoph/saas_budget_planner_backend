<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use App\Http\Resources\BaseResource;
use App\Http\Resources\Core\CategoryResource;
use App\Http\Resources\Core\BudgetResource;

class TransactionResource extends BaseResource
{
    protected function attributes($request): array
    {
        return [
            'description'      => $this->description,
            'amount'           => $this->amount,
            'currency'         => $this->currency,
            'transaction_date' => $this->transaction_date,
            'type'             => $this->type,
            'payment_method'   => $this->payment_method,
            'notes'            => $this->notes,
            'metadata'         => $this->metadata,
        ];
    }

    protected function includeRelations($request): array
    {
        return [
            'category' => new CategoryResource($this->whenLoaded('category')),
            'budget'   => new BudgetResource($this->whenLoaded('budget')),
        ];
    }
}
