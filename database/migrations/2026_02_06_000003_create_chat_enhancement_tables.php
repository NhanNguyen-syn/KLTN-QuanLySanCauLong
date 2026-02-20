<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Chat Context Table - for session memory
        Schema::create('chat_context', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100)->unique();
            $table->json('context_data')->nullable()->comment('Last intent, entities, message history');
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index('session_id');
            $table->index('expires_at');
        });

        // Chat Intents Table - for tracking detected intents
        Schema::create('chat_intents', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 100);
            $table->text('message');
            $table->string('detected_intent', 50)->comment('booking/faq/complaint/other');
            $table->decimal('confidence', 5, 2)->default(0)->comment('0-100');
            $table->json('entities')->nullable()->comment('Extracted entities (dates, times, court names)');
            $table->timestamp('created_at');

            $table->index('session_id');
            $table->index('detected_intent');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_intents');
        Schema::dropIfExists('chat_context');
    }
};
