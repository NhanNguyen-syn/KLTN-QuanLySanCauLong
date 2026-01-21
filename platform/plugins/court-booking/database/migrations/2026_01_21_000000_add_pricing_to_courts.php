<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('courts')) {
            Schema::table('courts', function (Blueprint $table) {
                if (! Schema::hasColumn('courts', 'default_price')) {
                    $table->decimal('default_price', 12, 2)->default(150000)->after('location');
                }
                if (! Schema::hasColumn('courts', 'member_price')) {
                    $table->decimal('member_price', 12, 2)->default(100000)->after('default_price');
                }
                if (! Schema::hasColumn('courts', 'address')) {
                    $table->string('address')->nullable()->after('member_price');
                }
                if (! Schema::hasColumn('courts', 'booking_url')) {
                    $table->string('booking_url')->nullable()->after('address');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('courts')) {
            Schema::table('courts', function (Blueprint $table) {
                $columns = ['booking_url', 'address', 'member_price', 'default_price'];
                foreach ($columns as $col) {
                    if (Schema::hasColumn('courts', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
