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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('categories');
            $table->string('name');
            $table->enum('type',
                array_map(fn(\App\Enums\CategoryType $case)=>$case->value,
                \App\Enums\CategoryType::cases())); // income, expense, transfer
            $table->string('color', 7)->default('#000000');
            $table->string('icon')->nullable();
            $table->boolean('is_system')->default(false); // prevent deletion
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['tenant_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
