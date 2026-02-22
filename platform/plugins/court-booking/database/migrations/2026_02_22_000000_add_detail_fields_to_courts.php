<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('courts', function (Blueprint $table) {
            if (! Schema::hasColumn('courts', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('name');
            }
            if (! Schema::hasColumn('courts', 'description')) {
                $table->text('description')->nullable()->after('note');
            }
            if (! Schema::hasColumn('courts', 'surface')) {
                $table->string('surface')->nullable()->after('description');
            }
            if (! Schema::hasColumn('courts', 'court_size')) {
                $table->string('court_size')->nullable()->after('surface');
            }
            if (! Schema::hasColumn('courts', 'lighting')) {
                $table->string('lighting')->nullable()->after('court_size');
            }
            if (! Schema::hasColumn('courts', 'air_conditioned')) {
                $table->boolean('air_conditioned')->default(false)->after('lighting');
            }
            if (! Schema::hasColumn('courts', 'features')) {
                $table->text('features')->nullable()->after('air_conditioned');
            }
            if (! Schema::hasColumn('courts', 'gallery')) {
                $table->text('gallery')->nullable()->after('features');
            }
            if (! Schema::hasColumn('courts', 'availability')) {
                $table->string('availability')->nullable()->after('gallery');
            }
        });
    }

    public function down(): void
    {
        Schema::table('courts', function (Blueprint $table) {
            $columns = ['slug', 'description', 'surface', 'court_size', 'lighting', 'air_conditioned', 'features', 'gallery', 'availability'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('courts', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
