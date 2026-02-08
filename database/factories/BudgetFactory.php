<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class BudgetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => $this->faker->words(3, true),
            'year' => date('Y'),
            'month' => date('n'),
            'total_income' => $this->faker->randomFloat(2, 1000, 10000),
            'total_expense' => $this->faker->randomFloat(2, 500, 5000),
            'currency' => 'USD',
        ];
    }
}
