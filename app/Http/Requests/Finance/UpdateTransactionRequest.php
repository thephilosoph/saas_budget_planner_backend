<?php

namespace App\Http\Requests\Finance;

use App\Enums\TransactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'      => ['sometimes', 'exists:categories,id'],
            'budget_id'        => ['sometimes', 'exists:budgets,id'],
            'description'      => ['sometimes', 'string', 'max:255'],
            'amount'           => ['sometimes', 'numeric', 'min:0.01'],
            'currency'         => ['sometimes', 'string', 'size:3'],
            'transaction_date' => ['sometimes', 'date'],
            'type'             => ['sometimes', Rule::enum(TransactionType::class)],
            'payment_method'   => ['nullable', 'string', 'max:255'],
            'notes'            => ['nullable', 'string'],
            'metadata'         => ['nullable', 'array'],
        ];
    }
}
