<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('courts')) {
            Schema::table('courts', function (Blueprint $table) {
                if (! Schema::hasColumn('courts', 'time_display')) {
                    $table->string('time_display')->nullable()->after('booking_url');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('courts')) {
            Schema::table('courts', function (Blueprint $table) {
                if (Schema::hasColumn('courts', 'time_display')) {
                    $table->dropColumn('time_display');
                }
            });
        }
    }
};
