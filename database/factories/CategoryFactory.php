<?php

namespace Database\Factories;

use App\Enums\CategoryType;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(CategoryType::cases()),
            'color' => $this->faker->hexColor(),
            'icon' => null,
            'is_system' => false,
            'sort_order' => 0,
        ];
    }
}
