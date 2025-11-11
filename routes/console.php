<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Scheduler: generate next 30 days of slots every midnight
Schedule::command('slots:generate --days=30')->dailyAt('00:05');
// Scheduler: cleanup expired holds frequently
Schedule::command('holds:cleanup')->everyFiveMinutes();
