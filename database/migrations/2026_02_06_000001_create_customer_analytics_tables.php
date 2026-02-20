<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Customer Analytics Table
        Schema::create('customer_analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->integer('rfm_recency')->default(0)->comment('Days since last booking');
            $table->integer('rfm_frequency')->default(0)->comment('Total bookings');
            $table->decimal('rfm_monetary', 15, 2)->default(0)->comment('Total spent');
            $table->string('segment', 20)->nullable()->comment('VIP/Regular/At-Risk/New/Churned');
            $table->decimal('lifetime_value', 15, 2)->default(0);
            $table->timestamp('last_calculated_at')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->index('member_id');
            $table->index('segment');
            $table->index('last_calculated_at');
        });

        // Customer Segments Table
        Schema::create('customer_segments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('segment_type', 30)->comment('VIP/Regular/At-Risk/New/Churned');
            $table->integer('score')->default(0)->comment('Segmentation score 0-100');
            $table->json('metadata')->nullable()->comment('Booking patterns, preferences');
            $table->timestamp('assigned_at');
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->index('member_id');
            $table->index('segment_type');
            $table->index('assigned_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_segments');
        Schema::dropIfExists('customer_analytics');
    }
};
