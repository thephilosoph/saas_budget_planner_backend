<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('permissions') as $scope => $resources) {
            foreach ($resources as $resource => $actions) {
                foreach ($actions as $action) {
                    Permission::firstOrCreate([
                        'name'       => "{$scope}:{$resource}.{$action}",
                        'guard_name' => 'api',
                        'group'      => $scope,
                    ]);
                }
            }
        }
    }
}

