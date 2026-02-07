<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('budget_id')->constrained();
            $table->foreignId('created_by')->constrained('users');
            $table->string('description');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('USD');
            $table->date('transaction_date');
            $table->enum('type',array_map(fn(\App\Enums\TransactionType $case)=>$case->value,\App\Enums\TransactionType::cases())); // income, expense
            $table->string('payment_method')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // For CSV import tracking
            $table->softDeletes();
            $table->timestamps();

            // Optimized indexes for reporting
            $table->index(['tenant_id', 'transaction_date']);
            $table->index(['tenant_id', 'category_id', 'transaction_date']);
            $table->index(['tenant_id', 'budget_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
