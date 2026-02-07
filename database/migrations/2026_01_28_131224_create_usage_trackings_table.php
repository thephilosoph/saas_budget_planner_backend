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
        Schema::create('usage_trackings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
                $table->enum('metric',array_map(fn(\App\Enums\UsageTrackingMetric $case)=>$case->value,\App\Enums\UsageTrackingMetric::cases())); // transactions_count, storage_mb, csv_imports
                $table->integer('value')->default(0);
                $table->integer('year');
                $table->tinyInteger('month');
                $table->tinyInteger('day');
                $table->timestamps();

                $table->unique(['tenant_id', 'metric', 'year' , 'month']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usage_trackings');
    }
};
