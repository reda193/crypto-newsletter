<!DOCTYPE html>
<html>
<head>
    <title>Cryptocurrency Newsletter Signup</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .error { color: red; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="email"] { width: 300px; padding: 5px; }
        button { padding: 8px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h1>Cryptocurrency Newsletter Signup</h1>
    
    @if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form method="post" action="/signup">
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
            <label for="percentage_alert">Percentage Change Alert (%):</label>
            <input type="text" id="percentage_alert" name="percentage_alert" value="{{ old('percentage_alert') }}" required>
        </div>
        
        <div class="form-group">
            <label for="captcha">Captcha:</label>
            <div>
                <span id="captcha_image">{!! captcha_img() !!}</span>
                <button type="button" id="reload">Reload</button>
            </div>
            <input type="text" id="captcha" name="captcha" required>
        </div>
        
        <div class="form-group">
            <button type="submit">Sign Up</button>
        </div>
    </form>
    
    <script>
        document.getElementById('reload').addEventListener('click', function() {
            fetch('/reload-captcha', {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('captcha_image').innerHTML = data.captcha;
            });
        });
    </script>
</body>
</html>