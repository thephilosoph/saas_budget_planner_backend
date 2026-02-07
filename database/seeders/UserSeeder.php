<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'SaaS Admin',
            'email' => 'admin@saas.test',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Demo User',
            'email' => 'user@demo.test',
            'password' => bcrypt('password'),
        ]);
    }
}
