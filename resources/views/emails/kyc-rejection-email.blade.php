<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYC Rejected</title>
</head>
<body style="background-color: #f9fafb; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <div style="max-width: 672px; margin: 32px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden;">
        <div style="background-color: #dc2626; padding: 24px 32px; text-align: center;">
            <h1 style="font-size: 24px; font-weight: 700; color: #ffffff; margin: 0;">KYC Rejected</h1>
        </div>

        <div style="padding: 32px;">
            <p>Hello {{ $data->user->lname }},</p>
            <p>Unfortunately, your KYC submission was not approved due to one or more of the following reasons:</p>
            <ul>
                <li>Blurry or unclear documents</li>
                <li>Incorrect or incomplete details</li>
                <li>Expired document submission</li>
            </ul>
            <p>Please log in and resubmit your KYC with accurate and complete information.</p>
            
            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ url('/dashboard') }}" style="background-color: #dc2626; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none;">Resubmit KYC</a>
            </div>
        </div>
    </div>
</body>
</html>
