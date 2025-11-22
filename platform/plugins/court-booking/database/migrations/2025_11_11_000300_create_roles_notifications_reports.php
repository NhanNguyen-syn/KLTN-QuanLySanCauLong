<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('type'); // booking_created, booking_paid, booking_cancelled, ...
            $table->string('channel'); // email, sms, realtime
            $table->json('payload');
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();
            $table->index(['type', 'channel', 'status']);
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action');
            $table->string('entity_type')->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->index(['entity_type', 'entity_id']);
        });

        Schema::create('reports_daily', function (Blueprint $table) {
            $table->id();
            $table->date('date')->index();
            $table->foreignId('court_id')->nullable()->constrained('courts')->nullOnDelete();
            $table->integer('total_slots')->default(0);
            $table->integer('booked_slots')->default(0);
            $table->decimal('revenue', 12, 2)->default(0);
            $table->timestamps();
            $table->unique(['date', 'court_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports_daily');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('roles');
    }
};

