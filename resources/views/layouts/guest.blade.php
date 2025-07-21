<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SpaLab Bintan') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <div class="min-h-screen flex items-center justify-center">
            <div class="w-full sm:max-w-md px-6 pb-8 bg-white shadow-md overflow-hidden sm:rounded-lg">
                
                <!-- Centered Logo inside the white box -->
                <div class="flex justify-center">
                    <a href="/">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-40 h-40 ">
                    </a>
                </div>
    
                <!-- Form Slot (e.g., Login Form) -->
                {{ $slot }}
    
            </div>
        </div>
    </body>
</html>
