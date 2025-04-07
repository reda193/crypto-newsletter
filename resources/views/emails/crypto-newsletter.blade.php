<!DOCTYPE html>
<html>
<head>
    <title>Cryptocurrency Newsletter</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #333; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .positive { background-color: #d4edda; }
        .negative { background-color: #f8d7da; }
        .footer { margin-top: 20px; font-size: 12px; color: #666; }
    </style>
</head>
<body>
    <h1>Your Cryptocurrency Update</h1>
    
    <p>Hello {{ $subscriber->name }},</p>
    
    <p>Here's your latest cryptocurrency update:</p>
    
    <table>
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Price (USD)</th>
                <th>1h Change (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cryptos as $crypto)
                @php
                    $hourChange = isset($crypto['percent_change_1h']) ? (float) $crypto['percent_change_1h'] : 0;
                    $alertThreshold = $subscriber->percentage_alert;
                    $class = '';
                    
                    if (abs($hourChange) >= $alertThreshold) {
                        $class = $hourChange > 0 ? 'positive' : 'negative';
                    }
                @endphp
                
                <tr class="{{ $class }}">
                    <td>{{ $crypto['symbol'] }}</td>
                    <td>{{ $crypto['name'] }}</td>
                    <td>${{ number_format((float) $crypto['price_usd'], 2) }}</td>
                    <td>{{ $crypto['percent_change_1h'] ?? '0' }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>
            This newsletter was sent to {{ $subscriber->email }} at your requested frequency.
            <br>
            To unsubscribe from this newsletter, <a href="{{ url('/newsletter/unsubscribe/' . urlencode($subscriber->email)) }}">click here</a>.
        </p>
    </div>
</body>
</html>