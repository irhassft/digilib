<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Header Profile --}}
            <div class="flex items-center gap-4 mb-8 px-4 sm:px-0">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Pengaturan Akun</h2>
                    <p class="text-sm text-gray-500">Kelola informasi profil dan keamanan akun Anda.</p>
                </div>
            </div>

            {{-- Grid Layout --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Kiri: Update Info --}}
                <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-xl border-t-4 border-green-500">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Kanan: Update Password --}}
                <div class="p-4 sm:p-8 bg-white shadow-sm sm:rounded-xl border-t-4 border-green-500">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>