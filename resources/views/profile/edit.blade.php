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

    <div class="w-full px-4 sm:px-6 flex flex-col gap-6">
        <div class="flex-1">
            <div class="max-w-3xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="p-6 sm:p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        <div class="relative">
                            <div class="w-28 h-28 rounded-full ring-4 ring-white dark:ring-gray-800 overflow-hidden bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-3xl font-bold text-green-700 dark:text-green-300">
                                @if(!empty($user->profile_photo_path) && file_exists(public_path('storage/' . $user->profile_photo_path)))
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}" class="w-28 h-28 object-cover">
                                @else
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 w-full">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $user->email }}</p>
                                    <div class="mt-3 flex flex-wrap items-center gap-2">
                                        @foreach($user->getRoleNames() as $role)
                                            <span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-xs font-semibold text-gray-700 dark:text-gray-200">{{ ucfirst($role) }}</span>
                                        @endforeach
                                    </div>
                                </div>


                            </div>

                            <div class="mt-4 grid grid-cols-1 gap-4 text-sm text-gray-600 dark:text-gray-400">
                                <div>
                                    <div class="text-xs font-semibold text-gray-500">Terdaftar</div>
                                    <div class="mt-1">{{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-new-layout>