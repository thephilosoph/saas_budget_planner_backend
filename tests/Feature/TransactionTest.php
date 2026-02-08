<?php

namespace Tests\Feature;

use App\Models\Budget;
use App\Models\Category;
use App\Models\Tenant;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Create Role if not exists
        if (!Role::where('name', 'Tenant Owner')->exists()) {
            Role::create(['name' => 'Tenant Owner', 'guard_name' => 'web']);
        }
    }

    public function test_user_can_list_transactions()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['current_tenant_id' => $tenant->id]);
        
        $category = Category::factory()->create(['tenant_id' => $tenant->id]);
        $budget = Budget::factory()->create(['tenant_id' => $tenant->id]);

        Transaction::factory()->count(3)->create([
            'tenant_id' => $tenant->id,
            'category_id' => $category->id,
            'budget_id' => $budget->id,
            'created_by' => $user->id,
        ]);

        Passport::actingAs($user);

        $response = $this->getJson('/api/transactions');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_transaction()
    {
        $tenant = Tenant::factory()->create();
        $user = User::factory()->create(['current_tenant_id' => $tenant->id]);
        
        $category = Category::factory()->create(['tenant_id' => $tenant->id]);
        $budget = Budget::factory()->create(['tenant_id' => $tenant->id]);

        Passport::actingAs($user);

        $data = [
            'category_id' => $category->id,
            'budget_id' => $budget->id,
            'description' => 'Test Transaction',
            'amount' => 100.50,
            'transaction_date' => now()->toDateString(),
            'type' => 'income',
            'currency' => 'USD',
        ];

        $response = $this->postJson('/api/transactions', $data);

        $response->assertStatus(201)
            ->assertJsonPath('data.description', 'Test Transaction');

        $this->assertDatabaseHas('transactions', [
            'description' => 'Test Transaction',
            'amount' => 100.50,
            'tenant_id' => $tenant->id,
        ]);
    }

    public function test_user_cannot_update_transaction_of_another_tenant()
    {
        // Tenant 1
        $tenant1 = Tenant::factory()->create();
        $user1 = User::factory()->create(['current_tenant_id' => $tenant1->id]);
        $category1 = Category::factory()->create(['tenant_id' => $tenant1->id]);
        $budget1 = Budget::factory()->create(['tenant_id' => $tenant1->id]);
        $transaction1 = Transaction::factory()->create([
            'tenant_id' => $tenant1->id,
            'category_id' => $category1->id,
            'budget_id' => $budget1->id,
        ]);

        // Tenant 2
        $tenant2 = Tenant::factory()->create();
        $user2 = User::factory()->create(['current_tenant_id' => $tenant2->id]);
        
        Passport::actingAs($user2);

        $updateData = ['description' => 'Hacked Transaction'];

        // Should return 404 because of tenant scope check in Service::findOrFail
        $response = $this->putJson("/api/transactions/{$transaction1->id}", $updateData);

        $response->assertStatus(404);
    }
}
