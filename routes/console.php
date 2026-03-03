<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ----------------------------------------------------------------
// Scheduled Commands
// ----------------------------------------------------------------

// Publish due content every 5 minutes
Schedule::command('content:publish-due')->everyFiveMinutes();

// Generate daily SEO report at midnight
Schedule::command('seo:daily-report')->dailyAt('00:05');
