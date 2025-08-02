<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Welcome to Our Service!</?title> --}}
</head>
<body style="background-color: #f9fafb; font-family: Arial, sans-serif; margin: 0; padding: 0;">
    <!-- Email Container -->
    <div style="max-width: 672px; margin: 32px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); overflow: hidden;">
        <!-- Header -->
        <div style="background-color: #2563eb; padding: 24px 32px; text-align: center;">
            <h1 style="font-size: 24px; font-weight: 700; color: #ffffff; margin: 0;">{{ $subjectLine }}</h1>
        </div>
        
        <!-- Content -->
        <div style="padding: 32px; padding-left: 20px; padding-right: 20px;">
            <div style="margin-bottom: 24px; text-align: center;">
                <img src="{{asset('storage/'.$settings->dark_logo)}}" alt="{{$settings->short_name}}" style="height: 64px; margin: 0 auto 16px; display: block;">
                <!-- After the greeting -->
                <h2 style="font-size: 20px; font-weight: 600; color: #1f2937; margin: 0;">Hello {{ $user->lname }},</h2>

                <div style="margin-bottom: 24px;">
                    <p style="margin-top: 8px; color: #374151; line-height: 1.625;">
                        {!! nl2br(e($messageBody)) !!}
                    </p>
                </div>

            </div>
         
            
          
            <!-- Secondary CTA -->
            <div style="text-align: center; margin-bottom: 32px;">
                <p style="font-size: 14px; color: #4b5563; margin-bottom: 8px;">Need help getting started?</p>
                <a href="tel:+2347067317819" style="color: #2563eb; font-size: 14px; font-weight: 500; text-decoration: none;">
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