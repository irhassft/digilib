<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Digital Library - RS PKU Aisyiyah Boyolali</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-white text-gray-900 font-sans selection:bg-green-500 selection:text-white">
        
        {{-- BAGIAN TOMBOL POJOK KANAN ATAS SUDAH DIHAPUS --}}

        {{-- KONTEN UTAMA: Layout Search Engine (Tengah Layar) --}}
        <div class="flex flex-col items-center justify-center min-h-screen px-4 sm:px-6 lg:px-8 bg-gradient-to-b from-white to-green-50/30">
            
            {{-- 1. Logo & Judul --}}
            <div class="text-center mb-10 animate-fade-in-down">
                <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RSPKU" class="h-32 md:h-40 mx-auto mb-6 object-contain drop-shadow-sm hover:scale-105 transition-transform duration-500">
                
                <h1 class="text-4xl md:text-6xl font-extrabold text-green-700 tracking-tight mb-2">
                    DIGITAL LIBRARY
                </h1>
                <p class="text-lg md:text-2xl text-gray-500 font-medium tracking-wide">
                    RS PKU AISYIYAH BOYOLALI
                </p>
                <div class="w-24 h-1.5 bg-green-500 mx-auto mt-6 rounded-full opacity-80"></div>
            </div>

            {{-- 2. Form Pencarian (Redirect ke Login) --}}
            <div class="w-full max-w-3xl transform transition-all hover:-translate-y-1 duration-300">
                <form action="{{ route('login') }}" method="GET" class="relative group">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-8 flex items-center pointer-events-none">
                            <svg class="h-7 w-7 text-green-500 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>

                        <input type="text" 
                            class="block w-full pl-20 pr-40 py-5 border-2 border-gray-100 rounded-full leading-5 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100 transition duration-200 ease-in-out text-lg shadow-xl"
                            placeholder="ketik kata kunci dokumen yang ingin anda cari" 
                            name="search_trigger"
                        >
                        
                        <div class="absolute inset-y-2 right-2">
                            <button type="submit" class="h-full px-6 md:px-8 bg-green-600 hover:bg-green-700 text-white font-bold rounded-full shadow-md transition-all flex items-center gap-2 uppercase tracking-wide text-sm md:text-base">
                                <span>Masuk</span>
                            </button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>

        <footer class="fixed bottom-0 w-full py-6 text-center bg-white/80 backdrop-blur border-t border-gray-100">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} RS PKU Aisyiyah Boyolali. All rights reserved.
            </p>
        </footer>
    </body>
</html>