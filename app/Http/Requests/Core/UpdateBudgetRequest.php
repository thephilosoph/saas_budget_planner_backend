<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBudgetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'     => ['sometimes', 'string', 'max:255'],
            'currency' => ['sometimes', 'string', 'size:3'],

            'year'  => ['prohibited'],
            'month' => ['prohibited'],
            'tenant_id' => ['prohibited'],

            'categories' => ['sometimes', 'array'],
            'categories.*.category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('tenant_id', auth()->user()->current_tenant_id),
            ],
            'categories.*.allocated_amount' => [
                'required',
                'numeric',
                'min:0',
            ],
        ];
    }
}
