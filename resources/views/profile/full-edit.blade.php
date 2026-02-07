<x-new-layout title="Edit Profil - RS PKU Digital Library">
    <x-slot:header>
        <div class="w-full px-4 sm:px-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 py-4 md:py-0">
            
            {{-- Title Section --}}
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                    <span class="material-symbols-outlined text-[28px]">manage_accounts</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-[#0d1b11] dark:text-white leading-tight">Pengaturan Profil</h1>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Kelola informasi akun dan keamanan Anda</p>
                </div>
            </div>

            {{-- Back Button (Diubah menjadi Dashboard) --}}
            <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-xs font-bold text-gray-600 dark:text-gray-300 hover:text-primary hover:border-primary/50 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px] group-hover:-translate-x-1 transition-transform">arrow_back</span>
                Dashboard
            </a>
        </div>
    </x-slot:header>

    <div class="w-full px-4 sm:px-6 pb-12">
        <div class="max-w-4xl mx-auto flex flex-col gap-8">
            
            {{-- Card 1: Update Profile Information --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-xl shadow-gray-200/40 dark:shadow-none border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                {{-- Decorative Background Blob --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row gap-6 md:gap-10">
                    {{-- Icon / Illustration Left --}}
                    <div class="hidden md:flex flex-col gap-2 w-1/3 border-r border-gray-100 dark:border-gray-700 pr-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 mb-2">
                            <span class="material-symbols-outlined">badge</span>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Informasi Dasar</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Perbarui nama profil dan alamat email akun Anda. Pastikan menggunakan email yang aktif untuk keperluan notifikasi.
                        </p>
                    </div>

                    {{-- Form Area --}}
                    <div class="flex-1">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Card 2: Update Password --}}
            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-8 shadow-xl shadow-gray-200/40 dark:shadow-none border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                {{-- Decorative Background Blob --}}
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 dark:bg-orange-900/10 rounded-bl-full pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row gap-6 md:gap-10">
                    {{-- Icon / Illustration Left --}}
                    <div class="hidden md:flex flex-col gap-2 w-1/3 border-r border-gray-100 dark:border-gray-700 pr-6">
                        <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-600 mb-2">
                            <span class="material-symbols-outlined">lock_reset</span>
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white">Keamanan</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Pastikan akun Anda tetap aman dengan menggunakan kata sandi yang panjang dan acak.
                        </p>
                    </div>

                    {{-- Form Area --}}
                    <div class="flex-1">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-new-layout>