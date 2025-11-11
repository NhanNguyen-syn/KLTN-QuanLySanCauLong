<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // e.g. 06:00-06:30
            $table->time('start_time');
            $table->time('end_time'); // 30-minute duration fixed
            $table->string('days_of_week'); // csv 1..7
            $table->unsignedSmallInteger('duration_minutes')->default(30);
            $table->timestamps();
        });

        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['weekday', 'weekend', 'holiday', 'custom']);
            $table->time('from_time');
            $table->time('to_time');
            $table->decimal('price', 12, 2);
            $table->integer('priority')->default(100); // lower = higher priority
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->index(['type', 'priority']);
        });

        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('court_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained('courts');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->enum('status', ['available', 'reserved', 'booked', 'blocked'])->default('available');
            $table->decimal('base_price', 12, 2)->nullable();
            $table->foreignId('applied_rule_id')->nullable()->constrained('pricing_rules');
            $table->timestamps();
            $table->unique(['court_id', 'start_at']); // fixed 30-min duration ensures uniqueness per start time
            $table->index(['court_id', 'status', 'start_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('court_slots');
        Schema::dropIfExists('holidays');
        Schema::dropIfExists('pricing_rules');
        Schema::dropIfExists('time_slots');
    }
};

