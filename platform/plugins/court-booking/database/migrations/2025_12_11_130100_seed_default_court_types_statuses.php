<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('court_types')) {
            $count = DB::table('court_types')->count();
            if ($count == 0) {
                DB::table('court_types')->insert([
                    ['name' => 'Mặc định', 'created_at' => now(), 'updated_at' => now()],
                ]);
            }
        }

        if (Schema::hasTable('court_statuses')) {
            $count = DB::table('court_statuses')->count();
            if ($count == 0) {
                DB::table('court_statuses')->insert([
                    ['name' => 'active', 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'maintenance', 'created_at' => now(), 'updated_at' => now()],
                    ['name' => 'closed', 'created_at' => now(), 'updated_at' => now()],
                ]);
            }
        }
    }

    public function down(): void
    {
        // No-op: keep seed data
    }
};

