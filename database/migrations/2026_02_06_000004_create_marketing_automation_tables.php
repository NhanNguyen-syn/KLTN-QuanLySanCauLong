<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Email Campaigns Table
        Schema::create('email_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject');
            $table->text('body');
            $table->string('segment_target')->nullable()->comment('VIP/Regular/At-Risk/New/Churned/All');
            $table->enum('trigger_type', ['manual', 'scheduled', 'event'])->default('manual');
            $table->json('trigger_config')->nullable()->comment('Conditions: e.g., no booking in X days');
            $table->enum('status', ['draft', 'active', 'paused', 'completed'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->integer('sent_count')->default(0);
            $table->integer('open_count')->default(0);
            $table->integer('click_count')->default(0);
            $table->timestamps();

            $table->index('status');
            $table->index('segment_target');
            $table->index('scheduled_at');
        });

        // Campaign Logs Table
        Schema::create('campaign_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('member_id');
            $table->enum('status', ['sent', 'opened', 'clicked', 'bounced', 'failed'])->default('sent');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->text('error')->nullable();

            $table->foreign('campaign_id')->references('id')->on('email_campaigns')->onDelete('cascade');
            $table->index(['campaign_id', 'member_id']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_logs');
        Schema::dropIfExists('email_campaigns');
    }
};
