<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Add booking_type to bookings table (if table exists)
        if (Schema::hasTable('bookings') && !Schema::hasColumn('bookings', 'booking_type')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->enum('booking_type', ['fixed', 'casual'])->default('casual')->after('status');
            });
        }

        // Add booking_type and priority to booking_holds table (if table exists)
        if (Schema::hasTable('booking_holds') && !Schema::hasColumn('booking_holds', 'booking_type')) {
            Schema::table('booking_holds', function (Blueprint $table) {
                $table->enum('booking_type', ['fixed', 'casual'])->default('casual')->after('expires_at');
                $table->tinyInteger('priority')->default(0)->after('booking_type'); // 0=casual, 1=fixed
            });
        }
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('booking_type');
        });

        Schema::table('booking_holds', function (Blueprint $table) {
            $table->dropColumn(['booking_type', 'priority']);
        });
    }
};
