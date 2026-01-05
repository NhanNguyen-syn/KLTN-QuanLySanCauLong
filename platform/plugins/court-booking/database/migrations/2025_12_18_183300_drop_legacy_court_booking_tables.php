<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Xóa các bảng placeholder cũ nếu còn tồn tại
        if (Schema::hasTable('court_bookings_translations')) {
            Schema::drop('court_bookings_translations');
        }
        if (Schema::hasTable('court_bookings')) {
            Schema::drop('court_bookings');
        }
    }

    public function down(): void
    {
        // Không khôi phục lại các bảng cũ
    }
};

