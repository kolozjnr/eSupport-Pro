<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Error' }} - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Error Styles -->
    <style>
        body {
            font-family: 'Figtree', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a202c;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .error-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            width: 90%;
            margin: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .error-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 2rem;
        }

        .error-404 { background: linear-gradient(135deg, #667eea, #764ba2); }
        .error-403 { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .error-500 { background: linear-gradient(135deg, #4facfe, #00f2fe); }
        .error-503 { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        .error-405 { background: linear-gradient(135deg, #fa709a, #fee140); }
        .error-419 { background: linear-gradient(135deg, #ffeaa7, #fab1a0); }
        .error-default { background: linear-gradient(135deg, #a8edea, #fed6e3); }

        .error-code {
            font-size: 4rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            line-height: 1;
        }

        .error-title {
            font-size: 1.875rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1rem;
        }

        .error-description {
            font-size: 1.125rem;
            color: #4a5568;
            margin-bottom: 2.5rem;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            min-width: 140px;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #4a5568;
            border: 2px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            background: white;
            border-color: #cbd5e0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            color: #4a5568;
            text-decoration: none;
        }

        .error-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .wave {
            animation: wave 0.6s ease-in-out infinite alternate;
        }

        @keyframes wave {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(15deg); }
        }

        @keyframes ripple {
            0% { transform: scale(0); opacity: 1; }
            100% { transform: scale(2); opacity: 0; }
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .error-container {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }

            .error-code {
                font-size: 3rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .error-description {
                font-size: 1rem;
            }

            .error-actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 280px;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .error-container {
                background: rgba(26, 32, 44, 0.95);
                color: #e2e8f0;
            }

            .error-title {
                color: #f7fafc;
            }

            .error-description {
                color: #cbd5e0;
            }

            .btn-secondary {
                background: rgba(45, 55, 72, 0.9);
                color: #e2e8f0;
                border-color: #4a5568;
            }

            .btn-secondary:hover {
                background: #2d3748;
                border-color: #718096;
                color: #e2e8f0;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon {{ $iconClass ?? 'error-default' }} error-animation">
            {!! $icon ?? '?' !!}
        </div>
        
        <div class="error-code">{{ $code ?? '500' }}</div>
        
        <h1 class="error-title">{{ $errorTitle ?? 'Something went wrong' }}</h1>
        
        <p class="error-description">
            {{ $message ?? 'We encountered an unexpected error. Please try again later.' }}
        </p>

        <div class="error-actions">
            @auth
                @if(Route::has('dashboard'))
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9,22 9,12 15,12 15,22"/>
                        </svg>
                        Back to Dashboard
                    </a>
                @else
                    <a href="{{ url('/') }}" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9,22 9,12 15,12 15,22"/>
                        </svg>
                        Back to Home
                    </a>
                @endif
            @else
                @if(Route::has('login'))
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10,17 15,12 10,7"/>
                            <line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        Login
                    </a>
                @else
                    <a href="{{ url('/') }}" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9,22 9,12 15,12 15,22"/>
                        </svg>
                        Back to Home
                    </a>
                @endif
            @endauth
            
            <button onclick="history.back()" class="btn btn-secondary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15,18 9,12 15,6"/>
                </svg>
                Go Back
            </button>
        </div>
    </div>

    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Add click animation to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // Don't create ripple if it's the back button
                    if (this.onclick) return;
                    
                    // Create ripple effect
                    const ripple = document.createElement('div');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        border-radius: 50%;
                        background: rgba(255,255,255,0.3);
                        transform: scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                    `;
                    
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
        });
    </script>
</body>
</html>