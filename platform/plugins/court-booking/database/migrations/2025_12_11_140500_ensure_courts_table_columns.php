<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Ensure court_types table
        if (! Schema::hasTable('court_types')) {
            Schema::create('court_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        // Ensure court_statuses table
        if (! Schema::hasTable('court_statuses')) {
            Schema::create('court_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        // Ensure courts table
        if (! Schema::hasTable('courts')) {
            Schema::create('courts', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('image')->nullable();
                $table->foreignId('court_type_id')->nullable()->constrained('court_types');
                $table->foreignId('status_id')->nullable()->constrained('court_statuses');
                $table->string('location')->nullable();
                $table->text('note')->nullable();
                $table->integer('order')->default(0);
                $table->string('status', 60)->default('published');
                $table->timestamps();
                $table->index(['court_type_id', 'status_id']);
            });
        } else {
            Schema::table('courts', function (Blueprint $table) {
                if (! Schema::hasColumn('courts', 'name')) {
                    $table->string('name')->after('id');
                }
                if (! Schema::hasColumn('courts', 'image')) {
                    $table->string('image')->nullable()->after('name');
                }
                if (! Schema::hasColumn('courts', 'court_type_id')) {
                    $table->unsignedBigInteger('court_type_id')->nullable()->after('image');
                }
                if (! Schema::hasColumn('courts', 'status_id')) {
                    $table->unsignedBigInteger('status_id')->nullable()->after('court_type_id');
                }
                if (! Schema::hasColumn('courts', 'location')) {
                    $table->string('location')->nullable()->after('status_id');
                }
                if (! Schema::hasColumn('courts', 'note')) {
                    $table->text('note')->nullable()->after('location');
                }
                if (! Schema::hasColumn('courts', 'order')) {
                    $table->integer('order')->default(0)->after('note');
                }
                if (! Schema::hasColumn('courts', 'status')) {
                    $table->string('status', 60)->default('published')->after('order');
                }
                if (! Schema::hasColumn('courts', 'created_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down(): void
    {
        // Do not drop tables; only cleanup extra columns if needed
        // Keep as no-op for safety
    }
};

