<?php

namespace App\Console\Commands;

use App\Mail\PasswordResetMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetTest extends Command
{
    protected $signature = 'password:reset-test {email?}';
    protected $description = 'Send a test password reset email';

    public function handle()
    {
        $email = $this->argument('email') ?: 'mohamed.reda33@outlook.com';
        $userName = "Test User";
        
        // Generate a fake reset URL - in a real app this would create a token
        $resetUrl = url('/reset-password/'.bin2hex(random_bytes(16)));
        
        Mail::to($email)->send(new PasswordResetMail($resetUrl, $userName));
        
        $this->info("Password reset email sent to $email!");
        
        if (config('mail.default') === 'log') {
            $this->info("Email was logged to storage/logs/laravel.log");
        }
    }
}