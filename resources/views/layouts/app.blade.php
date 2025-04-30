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

        @include('partials.head-css');
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="flex wrapper">
            @include('partials.sidenav')
              <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="page-content">
                @include('partials.topbar')
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
                @include('partials.footer')
            </div>
            @include('partials.customizer')
            @include('partials.footer-scripts')
        </div>
        {{ asset('assets/libs/apexcharts/apexcharts.min.js') }}
        {{ asset('assets/js/pages/dashboard.js') }}
    </body>
</html>
