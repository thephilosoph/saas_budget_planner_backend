<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\TenantRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class TenantRoleSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        if (! $tenant) {
            throw new \Exception('No tenant exists. Seed tenants first.');
        }

        TenantRole::insert([
            [
                'tenant_id' => $tenant->id,
                'name' => 'owner',
                'permissions' => json_encode(['*']),
                'level' => 0,
                'is_editable' => false,
            ],
            [
                'tenant_id' => $tenant->id,
                'name' => 'admin',
                'permissions' => json_encode([
                    'budgets.*',
                    'transactions.*',
                    'reports.view',
                ]),
                'level' => 1,
                'is_editable' => false,
            ],

        ]);
    }
}
