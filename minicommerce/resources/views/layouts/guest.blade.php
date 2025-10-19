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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 via-white to-purple-50">
            <div class="mb-6">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-3 rounded-xl shadow-lg group-hover:shadow-xl transition-shadow">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        MiniCommerce
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-white/80 backdrop-blur-sm shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} MiniCommerce. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
