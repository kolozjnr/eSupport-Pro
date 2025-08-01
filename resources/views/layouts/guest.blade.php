<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'esupport Pro') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Eltech support pro built to ease access to support from our customers." name="description">
    <meta content="Tecknow" name="author">
    <!-- Open Graph for Facebook/LinkedIn -->
    <meta property="og:title" content="{{ config('app.name', 'esupport Pro') }}">
    <meta property="og:description" content="Eltech support pro built to ease access to support from our customers.">
    <meta property="og:image" content="{{ asset('storage/' . $settings->light_logo) }}">
    <meta property="og:url" content="https://esupportpro.com/">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name', 'esupport Pro') }}">
    <meta name="twitter:description" content="Eltech support pro built to ease access to support from our customers.">
    <meta name="twitter:image" content="{{ asset('storage/' . $settings->light_logo) }}">


    <!-- Add this to your HTML head -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('storage/'. $settings->favicon)}}">

   

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        {{-- @include('partials.head-css') --}}
  

      @vite(['resources/landing/css/style.css', 'resources/landing/css/animate.css', 'resources/landing/js/index.js', 'resources/landing/js/typewriter.js'])
      
    </head>
    {{-- <body class="font-sans text-gray-900 antialiased"> --}}
          <body class="dark:bg-dark">
            @include("landing.partials.header")
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
         {{ $slot }}
        {{-- <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
               
            </div>
        </div> --}}
    </body>
</html>
