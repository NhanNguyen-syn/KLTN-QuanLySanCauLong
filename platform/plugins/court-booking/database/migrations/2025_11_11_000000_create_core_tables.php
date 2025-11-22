<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('court_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('court_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // active, maintenance, closed
            $table->timestamps();
        });

        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('court_type_id')->constrained('court_types');
            $table->foreignId('status_id')->constrained('court_statuses');
            $table->string('location')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->index(['court_type_id', 'status_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courts');
        Schema::dropIfExists('court_statuses');
        Schema::dropIfExists('court_types');
    }
};

