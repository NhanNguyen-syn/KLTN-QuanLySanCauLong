<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('courts')) {
            Schema::table('courts', function (Blueprint $table) {
                if (! Schema::hasColumn('courts', 'image')) {
                    $table->string('image')->nullable()->after('name');
                }
                if (! Schema::hasColumn('courts', 'order')) {
                    $table->integer('order')->default(0)->after('note');
                }
                if (! Schema::hasColumn('courts', 'status')) {
                    $table->string('status', 60)->default('published')->after('order');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('courts')) {
            Schema::table('courts', function (Blueprint $table) {
                if (Schema::hasColumn('courts', 'status')) {
                    $table->dropColumn('status');
                }
                if (Schema::hasColumn('courts', 'order')) {
                    $table->dropColumn('order');
                }
                if (Schema::hasColumn('courts', 'image')) {
                    $table->dropColumn('image');
                }
            });
        }
    }
};

