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
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return $this->successResponse(parent::toArray($request));
//        return $this->successResponse([
//            "category" => [
//                "id" => $this['category']->id,
//                "name" => $this['category']->name,
//                "parent_id" => $this['category']->parent_id,
//                "type" => $this['category']->type,
//                "color" => $this['category']->color,
//                "icon" => $this['category']->icon,
//                "is_system" => $this['category']->is_system,
//                "sort_order" => $this['category']->sort_order,
//            ]
//        ]);
    }
}
