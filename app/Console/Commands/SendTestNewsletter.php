<?php

namespace App\Console\Commands;

use App\Mail\CryptoNewsletter;
use App\Models\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestNewsletter extends Command
{
    protected $signature = 'newsletter:test {email?}';
    protected $description = 'Send a test cryptocurrency newsletter';

    public function handle()
    {
        $email = $this->argument('email') ?: 'mohamed.reda33@outlook.com';
        
        $subscriber = new Subscriber();
        $subscriber->name = "Test User";
        $subscriber->email = $email;
        $subscriber->percentage_alert = 2.0;
        
        $cryptoData = [
            [
                'symbol' => 'BTC',
                'name' => 'Bitcoin',
                'price_usd' => '50000.00',
                'percent_change_1h' => '2.5'
            ],
            [
                'symbol' => 'ETH',
                'name' => 'Ethereum',
                'price_usd' => '3000.00',
                'percent_change_1h' => '-1.5'
            ]
        ];
        
        Mail::to($email)->send(new CryptoNewsletter($subscriber, $cryptoData));
        
        $this->info("Test newsletter sent to $email!");
    }
}