<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            "name" => ["string", "max:255"],
            "parent_id" => ["nullable", "integer", "exists:categories,id"],
            "type" => ["string", "max:255"],
            "color" => ["string", "max:255"],
            "icon" => ["string", "max:255"],
            "is_system" => ["boolean"],
            "sort_order" => ["integer", "max:255"],
        ];
    }
}
