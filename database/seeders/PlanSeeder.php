<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'free',
            'slug' => 'free',
            'price' => 0,
            'features' => json_encode([
                'budgets' => 1,
                'csv_import' => false,
            ]),
            'limits' => json_encode([
                'transactions' => 100,
            ]),
            'is_active' => true,
        ]);

        Plan::create([
            'name' => 'pro',
            'slug' => 'pro',
            'price' => 19.99,
            'features' => json_encode([
                'budgets' => 10,
                'csv_import' => true,
            ]),
            'limits' => json_encode([
                'transactions' => 5000,
            ]),
            'is_active' => true,
        ]);
    }
}
