<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- HEADER LOGIN --}}
    <div class="text-center mb-8">
        {{-- Logo RSPKU --}}
        <div class="flex justify-center mb-4">
            {{-- Pastikan file logo ada di public/img/logo-rspku.png --}}
            <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RSPKU" class="h-24 w-auto object-contain">
        </div>

        <h2 class="text-2xl font-bold text-gray-800">
            Digital Library
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Silakan login untuk mengakses dokumen
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            {{-- Label kita sembunyikan atau buat kecil agar mirip referensi --}}
            <x-input-label for="email" :value="__('Email')" class="sr-only" /> 
            
            <x-text-input id="email" class="block mt-1 w-full px-5 py-3 rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-green-500 focus:ring-green-500 placeholder-gray-400" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                        placeholder="Masukkan Email Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" class="sr-only" />

            <x-text-input id="password" class="block mt-1 w-full px-5 py-3 rounded-xl border-gray-300 bg-gray-50 focus:bg-white focus:border-green-500 focus:ring-green-500 placeholder-gray-400"
                            type="password" name="password" required autocomplete="current-password" 
                            placeholder="Masukkan Password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-green-600 hover:text-green-800 font-medium underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full justify-center py-3.5 px-4 border border-transparent rounded-full shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 uppercase tracking-widest transition ease-in-out duration-150">
                {{ __('Masuk') }}
            </button>
        </div>
        
        {{-- TAMBAHAN: LINK REGISTER --}}
        <div class="text-center pt-1">
            <p class="text-sm text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-green-600 hover:text-green-800 hover:underline transition">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>