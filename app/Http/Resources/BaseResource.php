<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            $this->merge($this->attributes($request)),
            $this->merge($this->includeRelations($request)),
            'meta' => $this->includeMeta($request),
        ];
    }

    protected function attributes($request): array
    {
        // Default implementation returns all attributes except hidden ones
        return $this->resource->attributesToArray();
    }

    protected function includeRelations($request): array
    {
        return [];
    }

    protected function includeMeta($request): array
    {
        return [
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }

    public static function collection($resource)
    {
        $collection = parent::collection($resource);
        return $collection->additional(['meta' => ['count' => $collection->count()]]);
    }

    // Helper to standardize response for creation, updates, etc.
    public function withResponse($request, $response)
    {
        // This can be customized to add global headers or modify status codes if needed
    }
}
