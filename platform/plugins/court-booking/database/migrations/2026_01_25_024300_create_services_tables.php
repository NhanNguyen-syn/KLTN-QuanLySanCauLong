<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Bảng services - Dịch vụ & Sản phẩm
        if (!Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->enum('type', ['service', 'product'])->default('product');
                $table->enum('category', [
                    'beverage',
                    'food',
                    'equipment',
                    'accessory',
                    'stringing',
                    'coaching',
                    'rental',
                    'other'
                ])->default('other');
                $table->decimal('price', 12, 0);
                $table->decimal('cost', 12, 0)->nullable();
                $table->integer('stock')->default(0);
                $table->boolean('track_stock')->default(false);
                $table->string('unit')->default('cái');
                $table->string('image')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // Bảng trung gian booking_services
        if (!Schema::hasTable('booking_services')) {
            Schema::create('booking_services', function (Blueprint $table) {
                $table->id();
                $table->foreignId('booking_list_id')
                    ->constrained('court_bookings_list')
                    ->onDelete('cascade');
                $table->foreignId('service_id')
                    ->constrained('services')
                    ->onDelete('cascade');
                $table->integer('quantity')->default(1);
                $table->decimal('unit_price', 12, 0);
                $table->decimal('total_price', 12, 0);
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->index(['booking_list_id', 'service_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_services');
        Schema::dropIfExists('services');
    }
};
