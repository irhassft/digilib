<x-new-layout title="Tambah User - RS PKU Digital Library">
    
    <x-slot:header>
        <div class="flex items-center gap-4">
             <a href="{{ route('users.index') }}" class="w-10 h-10 rounded-full bg-white text-gray-500 flex items-center justify-center hover:bg-gray-100 hover:text-primary transition-all">
                 <span class="material-symbols-outlined">arrow_back</span>
             </a>
             <h2 class="text-xl font-bold text-[#0d1b11] dark:text-white">Tambah User Baru</h2>
         </div>
    </x-slot:header>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                
                <div class="flex gap-4 mb-6 items-center bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl text-blue-800 dark:text-blue-300">
                     <span class="material-symbols-outlined">info</span>
                     <p class="text-sm">Password default akan diset. Pastikan user menggantinya saat login pertama.</p>
                </div>

                <!-- Grid Input -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    <!-- Nama Lengkap -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="name">Nama Lengkap</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('name') border-red-500 @enderror" 
                            id="name" type="text" name="name" required placeholder="Contoh: Dr. Budi Santoso" value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="username">Username</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('username') border-red-500 @enderror" 
                            id="username" type="text" name="username" required placeholder="username (tanpa spasi)" value="{{ old('username') }}">
                        @error('username')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="email">Email <span class="text-xs text-gray-400">(Opsional)</span></label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('email') border-red-500 @enderror" 
                            id="email" type="email" name="email" placeholder="email@rspku.com" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role Selection -->
                    <div class="col-span-2">
                        <label class="block text-sm font-bold mb-4 text-gray-700 dark:text-gray-300">Hak Akses Role</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($roles as $role)
                            <label class="cursor-pointer flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/50 peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/40 hover:shadow-md transition-all">
                                <input type="radio" name="role" value="{{ $role->name }}" class="peer sr-only" required {{ old('role') == $role->name ? 'checked' : '' }}>
                                
                                <!-- Radio Button Circle -->
                                <div class="flex-shrink-0 w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-600 peer-checked:border-blue-500 peer-checked:bg-blue-500 flex items-center justify-center transition-all">
                                    <span class="material-symbols-outlined text-sm text-white opacity-0 peer-checked:opacity-100">check</span>
                                </div>
                                
                                <!-- Content -->
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white capitalize">{{ $role->name }}</h3>
                            </label>
                            @endforeach
                        </div>
                        @error('role')
                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Section -->
                    <div class="col-span-2 mt-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold mb-4">Keamanan Akun</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="password">Password</label>
                                <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('password') border-red-500 @enderror" 
                                    id="password" type="password" name="password" required>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="password_confirmation">Konfirmasi Password</label>
                                <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" 
                                    id="password_confirmation" type="password" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 mt-8">
                    <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-primary text-[#0d1b11] font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                        Simpan User Baru
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-new-layout>