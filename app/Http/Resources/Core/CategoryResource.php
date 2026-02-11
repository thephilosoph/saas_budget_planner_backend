<?php

namespace App\Http\Resources\Core;

use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    protected function attributes($request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "parent_id" => $this->parent_id,
            "type" => $this->type,
            "color" => $this->color,
            "icon" => $this->icon,
            "is_system" => $this->is_system,
            "sort_order" => $this->sort_order,
        ];
    }

    protected function includeRelations($request): array
    {
        return [
            'parent' => new CategoryResource($this->whenLoaded('parent')),
            // 'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
