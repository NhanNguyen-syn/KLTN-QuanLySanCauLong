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
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('member_id')->nullable();
                $table->unsignedTinyInteger('rating'); // 1-5
                $table->text('comment');
                $table->json('images')->nullable(); // Array of image URLs
                $table->unsignedInteger('helpful')->default(0);
                $table->boolean('is_approved')->default(true);
                $table->timestamps();
                
                // Indexes
                $table->index('member_id');
                $table->index('is_approved');
                $table->index('created_at');
                $table->index('rating');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
