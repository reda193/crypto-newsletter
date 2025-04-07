@extends('layouts.app')

@section('title', 'Sign Up')

@section('heading', 'Cryptocurrency Newsletter Signup')

@section('content')
    @if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form method="post" action="{{ route('signup.process') }}">
    @csrf
        
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email Address:</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        
        <div class="form-group">
            <label>Newsletter Frequency:</label>
            <div>
                <input type="radio" id="minute" name="frequency" value="minute" {{ old('frequency') == 'minute' ? 'checked' : '' }}>
                <label for="minute">Every minute</label>
            </div>
            <div>
                <input type="radio" id="hour" name="frequency" value="hour" {{ old('frequency') == 'hour' ? 'checked' : '' }}>
                <label for="hour">Every hour</label>
            </div>
            <div>
                <input type="radio" id="daily" name="frequency" value="daily" {{ old('frequency') == 'daily' ? 'checked' : '' }}>
                <label for="daily">Daily at midnight</label>
            </div>
        </div>
        
        <div class="form-group">
            <label>Cryptocurrency Tickers:</label>
            <div class="crypto-options">
                <div>
                    <input type="checkbox" id="btc" name="btc" value="1" {{ old('btc') ? 'checked' : '' }}>
                    <label for="btc">Bitcoin (BTC)</label>
                </div>
                <div>
                    <input type="checkbox" id="eth" name="eth" value="1" {{ old('eth') ? 'checked' : '' }}>
                    <label for="eth">Ethereum (ETH)</label>
                </div>
                <div>
                    <input type="checkbox" id="doge" name="doge" value="1" {{ old('doge') ? 'checked' : '' }}>
                    <label for="doge">Dogecoin (DOGE)</label>
                </div>
                <div>
                    <input type="checkbox" id="xrp" name="xrp" value="1" {{ old('xrp') ? 'checked' : '' }}>
                    <label for="xrp">Ripple (XRP)</label>
                </div>
                <div>
                    <input type="checkbox" id="ltc" name="ltc" value="1" {{ old('ltc') ? 'checked' : '' }}>
                    <label for="ltc">Litecoin (LTC)</label>
                </div>
                <div>
                    <input type="checkbox" id="sol" name="sol" value="1" {{ old('sol') ? 'checked' : '' }}>
                    <label for="sol">Solana (SOL)</label>
                </div>
                <div>
                    <input type="checkbox" id="ada" name="ada" value="1" {{ old('ada') ? 'checked' : '' }}>
                    <label for="ada">Cardano (ADA)</label>
                </div>
                <div>
                    <input type="checkbox" id="avax" name="avax" value="1" {{ old('avax') ? 'checked' : '' }}>
                    <label for="avax">Avalanche (AVAX)</label>
                </div>
                <div>
                    <input type="checkbox" id="dot" name="dot" value="1" {{ old('dot') ? 'checked' : '' }}>
                    <label for="dot">Polkadot (DOT)</label>
                </div>
                <div>
                    <input type="checkbox" id="matic" name="matic" value="1" {{ old('matic') ? 'checked' : '' }}>
                    <label for="matic">Polygon (MATIC)</label>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="percentage_alert">Percentage Change Alert (%):</label>
            <input type="text" id="percentage_alert" name="percentage_alert" value="{{ old('percentage_alert') }}" required>
        </div>
        
        <div class="form-group">
            <button type="submit">Sign Up</button>
        </div>
    </form>
@endsection