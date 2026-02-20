<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Booking Forecasts Table
        Schema::create('booking_forecasts', function (Blueprint $table) {
            $table->id();
            $table->date('forecast_date');
            $table->tinyInteger('hour')->comment('0-23');
            $table->unsignedBigInteger('court_id')->nullable();
            $table->integer('predicted_bookings')->default(0);
            $table->decimal('confidence_score', 5, 2)->default(0)->comment('0-100');
            $table->integer('actual_bookings')->nullable()->comment('Filled after the date');
            $table->timestamp('created_at');

            $table->index(['forecast_date', 'hour']);
            $table->index('court_id');
            $table->index('created_at');
        });

        // AI Insights Table
        Schema::create('ai_insights', function (Blueprint $table) {
            $table->id();
            $table->string('insight_type', 30)->comment('peak_hours/trend/anomaly/recommendation');
            $table->string('title');
            $table->text('description');
            $table->json('data')->nullable()->comment('Related metrics/charts data');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('is_read')->default(false);
            $table->timestamp('created_at');

            $table->index('insight_type');
            $table->index('priority');
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_insights');
        Schema::dropIfExists('booking_forecasts');
    }
};
