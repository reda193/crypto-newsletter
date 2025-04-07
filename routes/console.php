<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('newsletter:test', function () {
    $this->call('newsletter:minute');
    $this->info('Newsletter minute command executed!');
})->purpose('Test newsletter command');

// Define schedules directly in the console.php file
Schedule::command('newsletter:minute')->everyMinute();
Schedule::command('newsletter:hour')->hourly();
Schedule::command('newsletter:daily')->dailyAt('00:00');