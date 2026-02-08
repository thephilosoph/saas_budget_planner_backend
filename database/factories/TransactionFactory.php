<?php

namespace Database\Factories;

use App\Enums\TransactionType;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'category_id' => Category::factory(),
            'budget_id' => Budget::factory(),
            'created_by' => User::factory(),
            'description' => $this->faker->sentence(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'currency' => 'USD',
            'transaction_date' => $this->faker->date(),
            'type' => $this->faker->randomElement(TransactionType::cases()),
            'payment_method' => 'cash',
            'notes' => $this->faker->text(),
        ];
    }
}
