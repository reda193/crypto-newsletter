<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestScheduler extends Command
{
    protected $signature = 'scheduler:test';
    protected $description = 'Test if the scheduler is working';
    
    public function handle()
    {
        $this->info('Scheduler test executed at: ' . now());
        file_put_contents(
            storage_path('logs/scheduler-test.log'),
            'Executed at: ' . now() . PHP_EOL,
            FILE_APPEND
        );
        return 0;
    }
}