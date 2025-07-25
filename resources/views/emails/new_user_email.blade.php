<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Service!</title>
</head>
<body style="background-color: #f9fafb; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <!-- Email Container -->
    <div style="max-width: 672px; margin: 32px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <!-- Header -->
        <div style="background-color: #2563eb; padding: 24px 32px; text-align: center;">
            <h1 style="font-size: 24px; font-weight: 700; color: #ffffff; margin: 0;">Welcome to Eltech Support Pro</h1>
        </div>
        
        <!-- Content -->
        <div style="padding: 32px; padding-left: 20px; padding-right: 20px;">
            <div style="margin-bottom: 24px; text-align: center;">
                <img src="{{asset('storage/'.$settings->dark_logo)}}" alt="{{$settings->short_name}}" style="height: 64px; margin: 0 auto 16px; display: block;">
                <h2 style="font-size: 20px; font-weight: 600; color: #1f2937; margin: 0;">Hello {{$user->lname}},</h2>
            </div>
            
            <div style="margin-bottom: 24px; color: #374151; line-height: 1.625;">
                <p style="margin-bottom: 16px;">Thank you for joining {{$settings->long_name}}! We're excited to have you on board.</p>
                <p style="margin-bottom: 16px;">Our platform helps you create a support ticket and track progress.</p>
                <p style="margin-bottom: 16px;">Here's what you can do next:</p>
                
                <ul style="list-style-type: disc; padding-left: 20px; margin-bottom: 24px; margin-top: 0;">
                    <li style="margin-bottom: 8px;">Explore our dashboard and features</li>
                    <li style="margin-bottom: 8px;">Start creating support tickets</li>
                </ul>

                <strong style="margin-bottom: 16px;">Your Default Login Credentials:</strong>
                
                <ul style="list-style-type: disc; padding-left: 20px; margin-bottom: 24px; margin-top: 0;">
                    <li style="margin-bottom: 8px;">Email: {{$user->email}}</li>
                    <li style="margin-bottom: 8px;">Password: 123456789</li>
                    <p style="margin-bottom: 8px;">You can change your password in your account settings.</p>
                </ul>
            </div>
            
            <!-- Primary CTA -->
            <div style="text-align: center; margin-bottom: 32px;">
                <a href="/dashboard" style="display: inline-block; background-color: #2563eb; color: #ffffff; font-weight: 500; padding: 12px 24px; border-radius: 8px; text-decoration: none; transition: background-color 0.2s;">
                    Get Started Now
                </a>
            </div>
            
            <!-- Secondary CTA -->
            <div style="text-align: center; margin-bottom: 32px;">
                <p style="font-size: 14px; color: #4b5563; margin-bottom: 8px;">Need help getting started?</p>
                <a href="#" style="color: #2563eb; font-size: 14px; font-weight: 500; text-decoration: none;">
                    Call: +234 (706) 731-7819 →
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #f9fafb; padding: 24px 32px; text-align: center; border-top: 1px solid #e5e7eb;">
            <div style="margin-bottom: 16px;">
                <a href="#" style="margin: 0 8px; display: inline-block;">
                    <img src="https://via.placeholder.com/30" alt="Facebook" style="height: 24px; width: 24px; display: inline-block;">
                </a>
                <a href="#" style="margin: 0 8px; display: inline-block;">
                    <img src="https://via.placeholder.com/30" alt="Twitter" style="height: 24px; width: 24px; display: inline-block;">
                </a>
                <a href="#" style="margin: 0 8px; display: inline-block;">
                    <img src="https://via.placeholder.com/30" alt="LinkedIn" style="height: 24px; width: 24px; display: inline-block;">
                </a>
                <a href="#" style="margin: 0 8px; display: inline-block;">
                    <img src="https://via.placeholder.com/30" alt="Instagram" style="height: 24px; width: 24px; display: inline-block;">
                </a>
            </div>
            
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 8px;">
                © 2025 {{$settings->short_name}}. All rights reserved.
            </p>
            <p style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">
                Address:
            </p>
            <p style="font-size: 12px; color: #6b7280; margin: 0;">
                <a href="#" style="color: #2563eb; text-decoration: underline;">Unsubscribe</a> | 
                <a href="#" style="color: #2563eb; text-decoration: underline;">Privacy Policy</a> | 
                <a href="#" style="color: #2563eb; text-decoration: underline;">Terms of Service</a>
            </p>
        </div>
    </div>
</body>
</html>