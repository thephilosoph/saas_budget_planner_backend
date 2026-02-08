<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'category'         => $this->whenLoaded('category'), // Assuming relationships defined in model
            'budget'           => $this->whenLoaded('budget'),
            'description'      => $this->description,
            'amount'           => $this->amount,
            'currency'         => $this->currency,
            'transaction_date' => $this->transaction_date,
            'type'             => $this->type,
            'payment_method'   => $this->payment_method,
            'notes'            => $this->notes,
            'metadata'         => $this->metadata,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at,
        ];
    }
}
