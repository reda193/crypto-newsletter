<?php

namespace App\Console\Commands;

use App\Mail\CryptoNewsletter;
use App\Models\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class SendMinuteNewsletters extends Command
{
    protected $signature = 'newsletter:minute';
    protected $description = 'Send newsletters to minute subscribers';

    public function handle()
    {
        // Get subscribers with 'minute' frequency
        $subscribers = Subscriber::where('frequency', 'minute')->get();
        
        if ($subscribers->isEmpty()) {
            $this->info('No minute subscribers found.');
            return 0;
        }
        
        // Fetch crypto data from CoinLore API
        $response = Http::get('https://api.coinlore.net/api/tickers/');
        
        if (!$response->successful()) {
            $this->error('Failed to fetch cryptocurrency data.');
            return 1;
        }
        
        $allCryptoData = $response->json()['data'];
        
        // For each subscriber, send newsletter with their selected cryptos
        foreach ($subscribers as $subscriber) {
            $selectedCryptos = $this->getSelectedCryptos($subscriber, $allCryptoData);
            
            if (!empty($selectedCryptos)) {
                Mail::to($subscriber->email)
                    ->send(new CryptoNewsletter($subscriber, $selectedCryptos));
                $this->info("Newsletter sent to {$subscriber->email}");
            }
        }
        
        return 0;
    }
    
    private function getSelectedCryptos($subscriber, $allCryptoData)
    {
        // Extract cryptos the user has selected
        $selectedCryptos = [];
        $cryptoSymbols = ['BTC', 'ETH', 'DOGE', 'XRP', 'LTC', 'SOL', 'ADA', 'AVAX', 'DOT', 'MATIC'];
        
        foreach ($cryptoSymbols as $symbol) {
            $field = strtolower($symbol);
            if ($subscriber->$field) {
                $crypto = collect($allCryptoData)->firstWhere('symbol', $symbol);
                if ($crypto) {
                    $selectedCryptos[] = $crypto;
                }
            }
        }
        
        return $selectedCryptos;
    }
}