<?php

namespace App\Http\Requests\Finance;

use App\Enums\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'      => ['required', 'exists:categories,id'], // Add tenant check if needed
            'budget_id'        => ['required', 'exists:budgets,id'], // Add tenant check if needed
            'description'      => ['required', 'string', 'max:255'],
            'amount'           => ['required', 'numeric', 'min:0.01'],
            'currency'         => ['nullable', 'string', 'size:3'],
            'transaction_date' => ['required', 'date'],
            'type'             => ['required', Rule::enum(TransactionType::class)],
            'payment_method'   => ['nullable', 'string', 'max:255'],
            'notes'            => ['nullable', 'string'],
            'metadata'         => ['nullable', 'array'],
        ];
    }
}
