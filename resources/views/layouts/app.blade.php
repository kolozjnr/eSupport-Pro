<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'esupport Pro') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

         <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        
        <!-- quill css -->
        {{-- <link href="{{ asset('assets/libs/quill/quill.core.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('assets/libs/quill/quill.bubble.css') }}" rel="stylesheet" type="text/css" >
        <link href="{{ asset('assets/libs/quill/quill.snow.css') }}" rel="stylesheet" type="text/css" > --}}

        
         <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" >


        <!-- datepicker css -->
        <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

        <!-- One of the following themes -->
        <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/classic.min.css') }}"> <!-- 'classic' theme -->
        <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/monolith.min.css') }}"> <!-- 'monolith' theme -->
        <link rel="stylesheet" href="{{ asset('assets/libs/@simonwep/pickr/themes/nano.min.css') }}"> <!-- 'nano' theme -->

   

            {{-- @include('partials.head-css') --}}
            <!-- Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])

                
            <!-- Gridjs Plugin css -->
            <link href="{{ asset('assets/libs/gridjs/theme/mermaid.min.css') }}" rel="stylesheet" type="text/css" >

            {{-- Select2 --}}
            <link href="{{ asset('assets/libs/nice-select2/css/nice-select2.css')}}" rel="stylesheet" type="text/css">

             <!-- App css -->
             <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">

             <!-- Icons css -->
             <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
     
             <!-- Theme Config Js -->
             <script src="{{ asset('assets/js/config.js') }}"></script>
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
                    @if(session('success'))
                        <x-flash-message type="success" :message="session('success')" />
                    @endif

                    @if(session('error'))
                        <x-flash-message type="error" :message="session('error')" />
                    @endif

                    @if(session('warning'))
                        <x-flash-message type="warning" :message="session('warning')" />
                    @endif

                    @if(session('message'))
                        <x-flash-message type="info" :message="session('message')" />
                    @endif

                    {{-- @@include("./partials/page-title.html", {"subtitle":"Menu","title":"Dashboard"}) --}}
                    {{ $slot }}
                </main>
            </div>
        </div>
       

            <!-- Code Preview Plugin Js -->
            
            <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}" defer></script>
            <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}" defer></script>
            <script src="{{ asset('assets/libs/@frostui/tailwindcss/frostui.js') }}" defer></script>
        
            <!-- App Js -->
            <script src="{{ asset('assets/js/app.js') }}" defer></script>
        >
       
            {{-- <!-- Apexcharts js -->
            <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}" defer></script>

            
            <!-- Apex Chart Demo Js -->
            <script src="{{ asset('assets/js/pages/charts-apex.js') }}" defer></script>  --}}

         {{-- <!-- Gridjs Plugin js -->
         <script src="{{ asset('assets/libs/gridjs/gridjs.umd.js') }}" defer></script>
     
         <!-- Gridjs Demo js -->
         <script src="{{ asset('assets/js/pages/table-gridjs.js') }}" defer></script>
         
         <script src="{{ asset('assets/js/pages/dashboard.js') }}" defer></script>

         

         <script src="{{ asset('assets/libs/nice-select2/js/nice-select2.js') }}" defer></script>

         <!-- Choices Demo js -->
         <script src="{{ asset('assets/js/pages/form-select.js') }}" defer></script>   
 --}}

        
        <!-- Sweet Alerts js -->
        <script src="{{asset('assets/libs/sweetalert2/sweetalert2.min.js')}}" defer></script>

        <!-- Sweet alert init js-->
        <script src="{{ asset('assets/js/pages/extended-sweetalert.js') }}" defer></script>


        {{-- <script src="{{asset('assets/libs/quill/quill.min.js')}}" defer></script>

        <script src="{{asset('assets/js/pages/form-editor.js')}}" defer></script> --}}
      

    </body>
</html>
