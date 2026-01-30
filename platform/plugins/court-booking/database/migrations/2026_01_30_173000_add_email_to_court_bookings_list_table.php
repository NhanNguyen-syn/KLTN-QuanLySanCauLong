<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('court_bookings_list') && !Schema::hasColumn('court_bookings_list', 'email')) {
            Schema::table('court_bookings_list', function (Blueprint $table) {
                $table->string('email')->nullable()->after('contact')->comment('Email khách hàng');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('court_bookings_list') && Schema::hasColumn('court_bookings_list', 'email')) {
            Schema::table('court_bookings_list', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
    }
};
