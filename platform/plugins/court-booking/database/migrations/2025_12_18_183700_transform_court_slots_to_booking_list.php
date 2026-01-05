<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Drop legacy placeholder tables if any
        if (Schema::hasTable('court_bookings_translations')) {
            Schema::drop('court_bookings_translations');
        }
        if (Schema::hasTable('court_bookings')) {
            Schema::drop('court_bookings');
        }

        // 2) Remove foreign keys referencing court_slots to allow dropping it safely
        if (Schema::hasTable('booking_items')) {
            try {
                Schema::table('booking_items', function (Blueprint $table) {
                    if (Schema::hasColumn('booking_items', 'court_slot_id')) {
                        $table->dropForeign(['court_slot_id']);
                    }
                });
            } catch (\Throwable $e) {
                // ignore if FK doesn't exist
            }
        }
        if (Schema::hasTable('booking_holds')) {
            try {
                Schema::table('booking_holds', function (Blueprint $table) {
                    if (Schema::hasColumn('booking_holds', 'court_slot_id')) {
                        $table->dropForeign(['court_slot_id']);
                    }
                });
            } catch (\Throwable $e) {
                // ignore if FK doesn't exist
            }
        }

        // 3) Drop existing court_bookings_list (clean slate)
        if (Schema::hasTable('court_bookings_list')) {
            Schema::drop('court_bookings_list');
        }

        // 4) Drop court_slots table as requested
        if (Schema::hasTable('court_slots')) {
            Schema::drop('court_slots');
        }

        // 5) Create court_bookings_list with required structure
        Schema::create('court_bookings_list', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Mã hóa đơn (BD-YYYYMMDD-XXX) - có thể lặp lại trên nhiều dòng (1 hóa đơn nhiều slot)
            $table->string('order_code', 32)->index();

            // Sân
            $table->unsignedBigInteger('court_id')->nullable();
            $table->string('court_name', 255)->nullable();

            // Ngày & thời gian
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            // Trạng thái
            $table->string('status', 50)->default('processing')->index();

            // Khách hàng & liên hệ
            $table->string('customer_name', 255)->nullable();
            $table->string('contact', 255)->nullable();

            // Giá & đã thanh toán (cọc)
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);

            // Ghi chú
            $table->text('notes')->nullable();

            // Ngày tạo/cập nhật hóa đơn
            $table->dateTime('invoice_created_at')->nullable();
            $table->dateTime('invoice_updated_at')->nullable();

            $table->index(['date']);
        });
    }

    public function down(): void
    {
        // Rollback: just drop the new table. Not recreating old structures.
        Schema::dropIfExists('court_bookings_list');
    }
};

