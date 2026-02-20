<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Dynamic Pricing Rules Table
        if (!Schema::hasTable('pricing_rules')) {
            Schema::create('pricing_rules', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('court_id')->nullable()->comment('Null = apply to all courts');
                $table->tinyInteger('day_of_week')->nullable()->comment('0-6, null = all days');
                $table->time('time_start')->nullable();
                $table->time('time_end')->nullable();
                $table->decimal('base_multiplier', 5, 2)->default(1.00)->comment('1.5 = 150% price');
                $table->decimal('demand_multiplier', 5, 2)->nullable()->comment('Extra multiplier based on demand');
                $table->enum('demand_threshold', ['low', 'medium', 'high'])->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('priority')->default(0)->comment('Higher priority applies first');
                $table->timestamps();

                $table->index(['court_id', 'is_active']);
                $table->index('priority');
            });
        }


        // Price History Table
        if (!Schema::hasTable('price_history')) {
            Schema::create('price_history', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('court_id')->nullable();
                $table->date('date');
                $table->tinyInteger('hour');
                $table->decimal('base_price', 10, 2);
                $table->decimal('final_price', 10, 2);
                $table->decimal('applied_multiplier', 5, 2)->default(1.00);
                $table->integer('demand_level')->default(0)->comment('Predicted bookings');
                $table->timestamp('created_at');

                $table->index(['court_id', 'date', 'hour']);
                $table->index('date');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('price_history');
        Schema::dropIfExists('pricing_rules');
    }
};
