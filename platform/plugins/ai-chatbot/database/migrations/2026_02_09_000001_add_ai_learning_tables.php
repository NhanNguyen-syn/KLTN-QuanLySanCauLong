<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // User interaction logs for learning behavior
        Schema::create('ai_interaction_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->index();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('query', 500); // User's question
            $table->string('action_clicked', 100); // URL of action button clicked
            $table->string('action_label', 200); // Label of button clicked
            $table->boolean('was_helpful')->nullable(); // Optional feedback
            $table->timestamps();
            
            $table->index(['query', 'action_clicked']);
            $table->index('created_at');
        });

        // Query patterns - aggregated data for improving suggestions
        Schema::create('ai_query_patterns', function (Blueprint $table) {
            $table->id();
            $table->string('pattern', 200)->unique(); // Normalized query pattern
            $table->string('best_action_url', 100); // Most clicked action
            $table->string('best_action_label', 200);
            $table->unsignedInteger('click_count')->default(0);
            $table->decimal('success_rate', 5, 2)->default(0); // % marked as helpful
            $table->timestamps();
            
            $table->index(['pattern', 'click_count']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_query_patterns');
        Schema::dropIfExists('ai_interaction_logs');
    }
};
