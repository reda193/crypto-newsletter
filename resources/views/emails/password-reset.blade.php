<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            color: #2d3748;
        }
        .btn {
            display: inline-block;
            background-color: #3490dc;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #718096;
        }
    </style>
</head>
<body>
    <h1>Password Reset Request</h1>
    
    <p>Hello {{ $userName }},</p>
    
    <p>We received a request to reset your password. If you didn't make this request, you can safely ignore this email.</p>
    
    <p>To reset your password, click the button below:</p>
    
    <a href="{{ $resetUrl }}" class="btn">Reset Password</a>
    
    <p>If the button doesn't work, copy and paste the following URL into your browser:</p>
    <p>{{ $resetUrl }}</p>
    
    <p>This password reset link will expire in 60 minutes.</p>
    
    <div class="footer">
        <p>
            If you're having trouble, please contact our support team.
        </p>
    </div>
</body>
</html>