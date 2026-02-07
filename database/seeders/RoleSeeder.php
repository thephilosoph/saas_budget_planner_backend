<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role as SpatieRole;
use Illuminate\Database\Seeder;

use App\Enums\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            Role::PLATFORM_SUPER_ADMIN->value => [
                'type' => 'platform',
                'permissions' => ['*'],
            ],

            Role::PLATFORM_ADMIN->value => [
                'type' => 'platform',
                'permissions' => [
                    'platform:users.*',
                    'platform:tenants.*',
                ],
            ],

            Role::PLATFORM_EMPLOYEE->value => [
                'type' => 'platform',
                'permissions' => [
                    'platform:tenants.view',
                ],
            ],

            Role::OWNER->value => [
                'type' => 'tenant',
                'permissions' => ['tenant:*'],
            ],

            Role::ADMIN->value => [
                'type' => 'tenant',
                'permissions' => [
                    'tenant:budgets.*',
                    'tenant:transactions.*',
                    'tenant:reports.view',
                ],
            ],

            Role::ACCOUNTANT->value => [
                'type' => 'tenant',
                'permissions' => [
                    'tenant:transactions.*',
                    'tenant:reports.view',
                ],
            ],

            Role::VIEWER->value => [
                'type' => 'tenant',
                'permissions' => [
                    'tenant:*.view',
                ],
            ],
        ];

        foreach ($roles as $name => $data) {
            $role = SpatieRole::firstOrCreate([
                'name'       => $name,
                'guard_name' => 'api',
            ], [
                'type'        => $data['type'],
                'is_editable' => false,
            ]);

            $permissions = collect($data['permissions'])
                ->flatMap(fn ($pattern) =>
                $pattern === '*'
                    ? Permission::all()
                    : Permission::where('name', 'like', str_replace('*', '%', $pattern))->get()
                )
                ->unique('id');

            $role->syncPermissions($permissions);
        }
    }
}
