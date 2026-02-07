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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->enum('slug',
                array_map(fn(\App\Enums\PlanName $case)=>$case->value,
                \App\Enums\PlanName::cases())); // Free, Pro, Enterprise
            $table->string('stripe_price_id')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('billing_period')->default('monthly');
            $table->json('features'); // ["budgets"=>5, "categories"=>20, "csv_import"=>true]
            $table->json('limits');   // ["transactions_per_month"=>1000]
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
