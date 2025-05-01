<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

         <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        <!-- datepicker css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

        <!-- One of the following themes -->
        <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/classic.min.css') }}"> <!-- 'classic' theme -->
        <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/monolith.min.css') }}"> <!-- 'monolith' theme -->
        <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}"> <!-- 'nano' theme -->

        <!-- App css -->
        <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Icons css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

        <!-- Theme Config Js -->
        <script src="{{ asset('assets/js/config.js') }}"></script>

        {{-- @include('partials.head-css') --}}
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex wrapper">
            @include('layouts.navigation')
              <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="page-content">
                <!-- Page Heading -->
                {{-- @isset($header)
                    <header class="bg-white dark:bg-gray-800 shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset --}}

                <!-- Page Content -->
                <main class="flex-grow p-6">

                    {{-- @@include("./partials/page-title.html", {"subtitle":"Menu","title":"Dashboard"}) --}}
                    {{ $slot }}
                </main>
            </div>
        </div>
           <!-- Code Preview Plugin Js -->
       
      
    </body>
</html>
