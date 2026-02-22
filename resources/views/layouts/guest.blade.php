<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-taskflow-dark antialiased bg-white min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 sm:pt-12 pb-12 px-4 bg-dots">
            <div class="mb-8">
                <x-taskflow-logo />
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white border border-gray-200 rounded-xl shadow-sm">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
