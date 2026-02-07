<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseResource extends JsonResource
{
    protected function successResponse(array $data = []): array
    {
        return [
            'data' => $data,
            'meta' => [
                'timestamp' => now()->toIso8601String(),
            ],
        ];
    }

    protected function whenLoadedOrNull(string $relation)
    {
        return $this->whenLoaded($relation, fn () => $this->{$relation});
    }
}
