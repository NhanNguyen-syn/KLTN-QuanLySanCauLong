<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the table if it exists from a previous attempt
        Schema::dropIfExists('court_bookings_list');

        // Recreate the table with the correct structure
        Schema::create('court_bookings_list', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 32)->nullable()->comment('Mã hóa đơn');
            $table->foreignId('court_id')->nullable()->comment('ID sân');
            $table->string('court_name')->nullable()->comment('Tên sân');
            $table->date('date')->nullable()->comment('Ngày');
            $table->string('start_time')->nullable()->comment('Giờ bắt đầu');
            $table->string('end_time')->nullable()->comment('Giờ kết thúc');
            $table->string('status', 60)->default('processing')->comment('Trạng thái');
            $table->string('customer_name')->nullable()->comment('Tên khách hàng');
            $table->string('contact')->nullable()->comment('Liên hệ (SĐT/Email)');
            $table->decimal('price', 15, 2)->default(0)->comment('Giá');
            $table->decimal('paid_amount', 15, 2)->default(0)->comment('Đã thanh toán');
            $table->text('notes')->nullable()->comment('Ghi chú');
            $table->timestamp('invoice_created_at')->nullable()->comment('Ngày tạo hóa đơn');
            $table->timestamp('invoice_updated_at')->nullable()->comment('Ngày cập nhật hóa đơn');
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('court_bookings_list');
    }
};

