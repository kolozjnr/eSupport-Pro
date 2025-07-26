<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Every hour between 8 AM and 8 PM on weekdays
Schedule::command('subscriptions:check')
    ->hourly()
    ->between('8:00', '20:00')
    ->weekdays()
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/subscription-check.log'));
