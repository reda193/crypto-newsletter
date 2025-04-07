<!DOCTYPE html>
<html>
<head>
    <title>Unsubscribe Confirmation</title>
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
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #718096;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Unsubscription Confirmed</h1>
    
    <p>Hello {{ $name }},</p>
    
    <p>This email confirms that you have successfully unsubscribed from our cryptocurrency newsletter. You will no longer receive updates or notifications from us.</p>
    
    <p>We're sorry to see you go. If you'd like to subscribe again in the future, you can do so by visiting our website.</p>
    
    <p>If you unsubscribed by mistake or have any questions, please don't hesitate to contact us.</p>
    
    <div class="footer">
        <p>
            This is an automated message sent to {{ $email }}. Please do not reply to this email.
        </p>
    </div>
</body>
</html>