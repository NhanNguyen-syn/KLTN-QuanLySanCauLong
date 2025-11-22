<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('court_bookings')) {
            Schema::create('court_bookings', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('court_bookings_translations')) {
            Schema::create('court_bookings_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('court_bookings_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'court_bookings_id'], 'court_bookings_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('court_bookings');
        Schema::dropIfExists('court_bookings_translations');
    }
};
