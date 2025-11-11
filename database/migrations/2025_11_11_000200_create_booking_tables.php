<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('code')->unique(); // BKyymmdd + random
            $table->enum('status', ['pending', 'paid', 'cancelled', 'refunded'])->default('pending');
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->dateTime('held_until')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'status']);
        });

        Schema::create('booking_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->foreignId('court_slot_id')->constrained('court_slots');
            $table->decimal('price', 12, 2);
            $table->timestamps();
            $table->unique(['booking_id', 'court_slot_id']);
        });

        Schema::create('booking_holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_slot_id')->constrained('court_slots')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->dateTime('expires_at');
            $table->timestamps();
            $table->unique(['court_slot_id']); // only one holder per slot
            $table->index('expires_at');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('provider'); // vnpay, momo
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('transaction_ref')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->index(['provider', 'status']);
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();
            $table->string('invoice_no')->unique(); // INVyymmdd + random
            $table->dateTime('issued_at');
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('booking_holds');
        Schema::dropIfExists('booking_items');
        Schema::dropIfExists('bookings');
    }
};

