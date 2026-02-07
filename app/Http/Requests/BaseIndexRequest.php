<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class BaseIndexRequest extends FormRequest
{
    /**
     * Allowed sort columns for this resource.
     */
    protected array $allowedSorts = [];

    /**
     * Allowed filter columns for this resource.
     */
    protected array $allowedFilters = [];

    /**
     * Optional relations that can be loaded.
     */
    protected array $allowedRelations = [];

    public function authorize(): bool
    {
        return true; // Add policies later if needed
    }

    public function rules(): array
    {
        $rules = [
            // Search
            'search'    => ['nullable', 'string', 'max:255'],

            // Sorting
            'sort'      => ['nullable', Rule::in($this->allowedSorts)],
            'direction' => ['nullable', 'in:asc,desc'],

            // Pagination
            'perPage'   => ['nullable', 'integer', 'min:1', 'max:100'],

            // Relations
            'relations'  => ['nullable', 'array'],
            'relations.*' => ['string', Rule::in($this->allowedRelations)],
        ];

        // Add rules for filters dynamically
        foreach ($this->allowedFilters as $filter => $config) {
            $rules[$filter] = $config;
        }

        return $rules;
    }

    /**
     * Get only the validated filters.
     */
    public function filters(): array
    {
        $data = $this->validated();
        return array_filter(
            $data,
            fn($key) => in_array($key, array_keys($this->allowedFilters), true),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Get the requested sort column.
     */
    public function sort(): ?string
    {
        return $this->validated()['sort'] ?? null;
    }

    /**
     * Get the requested sort direction.
     */
    public function direction(): string
    {
        return $this->validated()['direction'] ?? 'desc';
    }

    /**
     * Get pagination size.
     */
    public function perPage(): int
    {
        return $this->validated()['perPage'] ?? 15;
    }

    /**
     * Get requested relations to load.
     */
    public function relations(): array
    {
        return $this->validated()['relations'] ?? [];
    }
}
