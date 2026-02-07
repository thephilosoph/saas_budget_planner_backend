<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams', false);
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        // 1. PERMISSIONS (All global, but can be scoped in usage)
        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); // e.g., 'platform:manage_users', 'tenant:edit_settings', 'tenant:view_finances'
            $table->string('guard_name')->default('web');
            $table->string('group')->nullable(); // 'platform', 'tenant', 'billing'
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
            $table->index('group');
        });

        // 2. ROLES (All roles: platform and tenant types)
        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name'); // 'super_admin', 'platform_admin', 'platform_employee', 'tenant_owner', 'tenant_admin', 'tenant_accountant', 'tenant_viewer'
            $table->string('guard_name')->default('web');
            $table->string('type')->default('tenant'); // 'platform' or 'tenant' to categorize
            $table->boolean('is_editable')->default(true); // From your tenant_roles
            $table->integer('level')->default(0); // From your tenant_roles (e.g., 0=owner, 1=admin)
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
            $table->index('type');
        });

        // 3. ROLE HAS PERMISSIONS (All relational)
        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($pivotPermission, $pivotRole, $tableNames) {
            $table->unsignedBigInteger($pivotPermission);
            $table->unsignedBigInteger($pivotRole);

            $table->foreign($pivotPermission)->references('id')->on($tableNames['permissions'])->onDelete('cascade');
            $table->foreign($pivotRole)->references('id')->on($tableNames['roles'])->onDelete('cascade');

            $table->primary([$pivotPermission, $pivotRole]);
        });

        // 4. MODEL HAS PERMISSIONS (With tenant scoping for direct permissions)
        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($columnNames, $pivotPermission, $tableNames) {
            $table->unsignedBigInteger($pivotPermission);
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');

            $table->foreign($pivotPermission)->references('id')->on($tableNames['permissions'])->onDelete('cascade');

            $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type', 'tenant_id']); // Extended primary key
            $table->index([$columnNames['model_morph_key'], 'model_type', 'tenant_id']);
        });

        // 5. MODEL HAS ROLES (With tenant scoping - key for multi-tenancy)
        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($columnNames, $pivotRole, $tableNames) {
            $table->unsignedBigInteger($pivotRole);
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');

            $table->foreign($pivotRole)->references('id')->on($tableNames['roles'])->onDelete('cascade');

            $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type', 'tenant_id']); // Extended primary key
            $table->index([$columnNames['model_morph_key'], 'model_type', 'tenant_id']);
        });

        // Optional: Tenant User Pivot (for extra metadata like invites; not required if using model_has_roles for assignments)
        Schema::create('tenant_user', function (Blueprint $table) {
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->foreignId('invited_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->primary(['tenant_id', 'user_id']);
        });

        // Clear Spatie cache
        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');

        Schema::dropIfExists('tenant_user');
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
};
