<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('vip_customers')) {
            Schema::create('vip_customers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('phone')->unique();
                $table->string('email')->nullable();
                $table->enum('type', ['member', 'vip', 'gold', 'platinum'])->default('member');
                $table->decimal('discount_percent', 5, 2)->default(0);
                $table->decimal('credit_limit', 12, 0)->default(0); // Hạn mức công nợ
                $table->decimal('current_debt', 12, 0)->default(0); // Công nợ hiện tại
                $table->date('member_since')->nullable();
                $table->date('valid_until')->nullable();
                $table->text('notes')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('vip_customers');
    }
};
