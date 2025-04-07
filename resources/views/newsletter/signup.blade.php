@extends('layouts.app')

@section('title', 'Sign Up')

@section('heading', 'Cryptocurrency Newsletter Signup')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0 py-2">Subscribe to Cryptocurrency Updates</h3>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form method="post" action="{{ route('signup.process') }}">
                @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email Address:</label>
                        <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Newsletter Frequency:</label>
                        <div class="bg-light p-3 rounded">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" id="minute" name="frequency" value="minute" {{ old('frequency') == 'minute' ? 'checked' : '' }}>
                                <label class="form-check-label" for="minute">Every minute (for testing)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" id="hour" name="frequency" value="hour" {{ old('frequency') == 'hour' ? 'checked' : '' }}>
                                <label class="form-check-label" for="hour">Hourly updates</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="daily" name="frequency" value="daily" {{ old('frequency') == 'daily' ? 'checked' : '' }}>
                                <label class="form-check-label" for="daily">Daily digest (at midnight)</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Select Cryptocurrencies to Track:</label>
                        <div class="row bg-light p-3 rounded">
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="btc" name="btc" value="1" {{ old('btc') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="btc">Bitcoin (BTC)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="eth" name="eth" value="1" {{ old('eth') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="eth">Ethereum (ETH)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="doge" name="doge" value="1" {{ old('doge') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="doge">Dogecoin (DOGE)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="xrp" name="xrp" value="1" {{ old('xrp') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="xrp">Ripple (XRP)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="ltc" name="ltc" value="1" {{ old('ltc') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ltc">Litecoin (LTC)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="sol" name="sol" value="1" {{ old('sol') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="sol">Solana (SOL)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="ada" name="ada" value="1" {{ old('ada') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ada">Cardano (ADA)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="avax" name="avax" value="1" {{ old('avax') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="avax">Avalanche (AVAX)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="dot" name="dot" value="1" {{ old('dot') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="dot">Polkadot (DOT)</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="matic" name="matic" value="1" {{ old('matic') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="matic">Polygon (MATIC)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="percentage_alert" class="form-label fw-bold">Price Change Alert Threshold (%):</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="percentage_alert" name="percentage_alert" value="{{ old('percentage_alert') }}" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text">
                            You'll receive highlighted alerts when prices change by more than this percentage.
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Sign Up for Updates</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection