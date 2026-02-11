<x-new-layout title="Edit User - RS PKU Digital Library">
    
    <x-slot:header>
        <div class="flex items-center gap-4">
             <a href="{{ route('users.index') }}" class="w-10 h-10 rounded-full bg-white text-gray-500 flex items-center justify-center hover:bg-gray-100 hover:text-primary transition-all">
                 <span class="material-symbols-outlined">arrow_back</span>
             </a>
             <h2 class="text-xl font-bold text-[#0d1b11] dark:text-white">Edit Data User</h2>
         </div>
    </x-slot:header>

    <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">

                <!-- Notification: success or error -->
                @if(session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: "{{ session('success') }}",
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    </script>
                @endif
                @if(session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: "{{ session('error') }}",
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000
                        });
                    </script>
                @endif
                
                <div class="flex gap-4 mb-6 items-center bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-xl text-yellow-800 dark:text-yellow-300">
                     <span class="material-symbols-outlined">edit_square</span>
                     <p class="text-sm">Anda sedang mengedit data akun: <strong>{{ $user->name }}</strong></p>
                </div>

                <!-- Grid Input -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    <!-- Nama Lengkap -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="name">Nama Lengkap</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" 
                            id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <!-- Username -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="username">Username</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" 
                            id="username" type="text" name="username" value="{{ old('username', $user->username) }}" required>
                    </div>

                    <!-- Role Selection -->
                    <div class="col-span-2">
                        <label class="block text-sm font-bold mb-3 text-gray-700 dark:text-gray-300">Hak Akses Role</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($roles as $role)
                            <label class="cursor-pointer">
                                {{-- Cek apakah role ini dimiliki user --}}
                                <input type="radio" name="role" value="{{ $role->name }}" class="peer sr-only" required {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                <div class="p-4 rounded-xl border-2 border-gray-100 dark:border-gray-700 peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/50 transition-all flex items-center gap-3">
                                    <div class="w-5 h-5 rounded-full border border-gray-300 peer-checked:border-primary peer-checked:bg-primary flex items-center justify-center">
                                        <span class="material-symbols-outlined text-xs text-white opacity-0 peer-checked:opacity-100">check</span>
                                    </div>
                                    <span class="text-sm font-bold capitalize">{{ $role->name }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Section (Optional) -->
                    <div class="col-span-2 mt-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold mb-1">Ganti Password</h3>
                        <p class="text-sm text-gray-400 mb-4">Kosongkan jika tidak ingin mengubah password user.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="password">Password Baru</label>
                                <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('password') border-red-500 @enderror" 
                                    id="password" type="password" name="password" autocomplete="new-password">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="password_confirmation">Konfirmasi Password</label>
                                <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" 
                                    id="password_confirmation" type="password" name="password_confirmation">
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
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>
    </div>
</x-new-layout>