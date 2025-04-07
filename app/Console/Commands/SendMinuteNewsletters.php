<?php

namespace App\Console\Commands;

use App\Mail\CryptoNewsletter;
use App\Models\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        try {
            $response = Http::withoutVerifying()->get('https://api.coinlore.net/api/tickers/');
            
            if (!$response->successful()) {
                $this->error('Failed to fetch cryptocurrency data: ' . $response->status());
                return 1;
            }
            
            $allCryptoData = $response->json()['data'];
            
            // For each subscriber, send newsletter with their selected cryptos
            foreach ($subscribers as $subscriber) {
                $selectedCryptos = $this->getSelectedCryptos($subscriber, $allCryptoData);
                
                if (!empty($selectedCryptos)) {
                    try {
                        Mail::to($subscriber->email)
                            ->send(new CryptoNewsletter($subscriber, $selectedCryptos));
                        $this->info("Newsletter sent to {$subscriber->email}");
                    } catch (\Exception $e) {
                        $this->error("Failed to send newsletter to {$subscriber->email}: " . $e->getMessage());
                        Log::error("Failed to send newsletter: " . $e->getMessage());
                    }
                } else {
                    $this->warn("No selected cryptocurrencies found for {$subscriber->email}");
                }
            }
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Error in newsletter process: ' . $e->getMessage());
            Log::error('Newsletter error: ' . $e->getMessage());
            return 1;
        }
    }
    
    private function getSelectedCryptos($subscriber, $allCryptoData)
    {
        // Extract cryptos the user has selected
        $selectedCryptos = [];
        $cryptoSymbols = ['btc', 'eth', 'doge', 'xrp', 'ltc', 'sol', 'ada', 'avax', 'dot', 'matic'];
        
        foreach ($cryptoSymbols as $field) {
            if ($subscriber->$field) {
                $symbol = strtoupper($field);
                $crypto = collect($allCryptoData)->firstWhere('symbol', $symbol);
                if ($crypto) {
                    $selectedCryptos[] = $crypto;
                }
            }
        }
        
        return $selectedCryptos;
    }
}