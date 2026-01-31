<x-new-layout title="Pengaturan Akun - RS PKU Digital Library">
    <x-slot:header>
        <div class="w-full px-6 flex items-center justify-between gap-4 h-full">
            <div class="flex items-center gap-4">
                <div class="bg-green-100 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-[#0d1b11]">Pengaturan Akun</h1>
                    <p class="text-xs text-gray-500">Kelola informasi profil dan keamanan akun Anda.</p>
                </div>
            </div>
        </div>
    </x-slot:header>

    <div class="w-full px-6 flex flex-col gap-6">
        <div class="flex-1">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Logout kini tersedia di sidebar; card aksi dihilangkan dari halaman ini --}}
        </div>
    </div>
</x-new-layout>