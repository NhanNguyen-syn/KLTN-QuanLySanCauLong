<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('pricing_rules') && ! Schema::hasColumn('pricing_rules', 'audience')) {
            Schema::table('pricing_rules', function (Blueprint $table) {
                $table->enum('audience', ['guest','member','all'])->default('all')->after('type');
            });
        }

        if (Schema::hasTable('court_slots') && ! Schema::hasColumn('court_slots', 'member_price')) {
            Schema::table('court_slots', function (Blueprint $table) {
                $table->decimal('member_price', 12, 2)->nullable()->after('base_price');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('court_slots') && Schema::hasColumn('court_slots', 'member_price')) {
            Schema::table('court_slots', function (Blueprint $table) {
                $table->dropColumn('member_price');
            });
        }

        if (Schema::hasTable('pricing_rules') && Schema::hasColumn('pricing_rules', 'audience')) {
            Schema::table('pricing_rules', function (Blueprint $table) {
                $table->dropColumn('audience');
            });
        }
    }
};

