<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    {{-- Background dibuat gradasi Hijau muda ke Putih agar segar --}}
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-green-50 to-white">
            
            {{-- Slot Utama (Tempat Form Login Berada) --}}
            <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100 relative">
                {{-- Hiasan garis atas --}}
                <div class="absolute top-0 left-0 w-full h-2 bg-green-600"></div>
                
                {{ $slot }}
            </div>

            {{-- Footer Kecil --}}
            <div class="mt-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} RS PKU Aisyiyah Boyolali. <br>Digital Library System.
            </div>
        </div>
    </body>
</html>