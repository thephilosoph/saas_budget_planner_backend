<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $uri = $this->uri()->path();

        if ($uri === 'api/auth/register') {
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users'],
                'company_name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
                'device_name' => ['required', 'string', 'max:255'],
            ];
        }

        if (str_starts_with($uri, 'api/invite/')) {
            return [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'device_name' => ['required', 'string', 'max:255'],
            ];
        }

        // Default/fallback
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'company_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'device_name' => ['required', 'string', 'max:255'],
        ];

    }
}
