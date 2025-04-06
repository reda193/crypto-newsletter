<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'name', 'email', 'frequency', 
        'btc', 'eth', 'doge', 'xrp', 'ltc', 'sol', 'ada', 'avax', 'dot', 'matic',
        'percentage_alert'
    ];
}
