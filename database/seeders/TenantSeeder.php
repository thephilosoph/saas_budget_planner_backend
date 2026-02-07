<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\TenantRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@demo.test')->first();
//        $ownerRole = TenantRole::where('name', 'owner')->first();

        $tenant = Tenant::create([
            'name' => 'Demo Company',
            'slug' => 'demo-company',
        ]);
//
//        $tenant->users()->attach($user->id, [
//            'role_id' => $ownerRole->id,
//            'joined_at' => now(),
//        ]);

        $user->update(['current_tenant_id' => $tenant->id]);
    }
}
