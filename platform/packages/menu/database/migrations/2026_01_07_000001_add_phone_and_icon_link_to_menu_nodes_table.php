<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('menu_nodes', function (Blueprint $table): void {
            if (! Schema::hasColumn('menu_nodes', 'phone')) {
                $table->string('phone', 50)->nullable()->after('icon_font');
            }

            if (! Schema::hasColumn('menu_nodes', 'icon_link')) {
                $table->string('icon_link', 255)->nullable()->after('phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('menu_nodes', function (Blueprint $table): void {
            if (Schema::hasColumn('menu_nodes', 'icon_link')) {
                $table->dropColumn('icon_link');
            }

            if (Schema::hasColumn('menu_nodes', 'phone')) {
                $table->dropColumn('phone');
            }
        });
    }
};

