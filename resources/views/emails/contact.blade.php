<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contact Message</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            padding: 30px;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .section {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f1f1;
        }
        .section:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            width: 80px;
        }
        .value {
            margin-left: 10px;
        }
        .message {
            background-color: #f8f9fa;
            padding: 15px;
            border-left: 4px solid #3498db;
            white-space: pre-line;
            border-radius: 4px;
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📩 New Contact Message</h2>

        <div class="section">
            <span class="label">From:</span>
            <span class="value">{{ $data['name'] }} &lt;{{ $data['email'] }}&gt;</span>
        </div>

        @if(!empty($data['phone']))
        <div class="section">
            <span class="label">Phone:</span>
            <span class="value">{{ $data['phone'] }}</span>
        </div>
        @endif

        <div class="section">
            <span class="label">Subject:</span>
            <span class="value">{{ $data['subject'] ?? 'No Subject' }}</span>
        </div>

        <div class="section">
            <span class="label">Message:</span>
            <div class="message">
                {{ $data['message'] }}
            </div>
        </div>

        <div class="footer">
            This message was sent via your website contact form on {{ now()->format('F j, Y \a\t g:i a') }}
        </div>
    </div>
</body>
</html>