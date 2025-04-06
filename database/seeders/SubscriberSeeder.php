<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscribers')->insert([
            [
                'name' => 'Minute User',
                'email' => 'minute@example.com',
                'frequency' => 'minute',
                'btc' => true,
                'eth' => true,
                'doge' => false,
                'xrp' => false,
                'ltc' => true,
                'percentage_alert' => 2.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
