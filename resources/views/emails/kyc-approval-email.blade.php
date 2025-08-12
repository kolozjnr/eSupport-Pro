<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC Approved</title>
</head>
<body style="background-color: #f9fafb; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <div style="max-width: 672px; margin: 32px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #2563eb; padding: 24px 32px; text-align: center;">
            <h1 style="font-size: 24px; font-weight: 700; color: #ffffff; margin: 0;">KYC Approved</h1>
        </div>

        <div style="padding: 32px;">
            <p>Hello {{ $data->user->lname }},</p>
            <p>Congratulations! Your KYC verification has been successfully approved.</p>
            <p>You now have full access to all features of {{ $settings->long_name ?? 'our platform' }}.</p>
            
            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ url('/dashboard') }}" style="background-color: #2563eb; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none;">Go to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
