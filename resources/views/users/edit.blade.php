<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">Edit Data User</h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-md rounded-xl border-t-4 border-yellow-500">
                
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT') {{-- Penting untuk Update --}}

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full p-2.5 bg-white text-gray-900" 
                                      type="text" name="name" :value="old('name', $user->name)" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full p-2.5 bg-white text-gray-900" 
                                      type="email" name="email" :value="old('email', $user->email)" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="role" :value="__('Jabatan / Role')" />
                        <select name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 bg-white text-gray-900 p-2.5">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="my-6 border-t border-gray-100 pt-4">
                        <h3 class="text-sm font-bold text-gray-500 mb-2">Ubah Password (Opsional)</h3>
                        <p class="text-xs text-gray-400 mb-4">Biarkan kosong jika tidak ingin mengganti password.</p>
                        
                        <div class="mb-4">
                            <x-input-label for="password" :value="__('Password Baru')" />
                            <x-text-input id="password" class="block mt-1 w-full p-2.5 bg-white text-gray-900" type="password" name="password" autocomplete="new-password" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full p-2.5 bg-white text-gray-900" type="password" name="password_confirmation" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Batal</a>
                        <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-lg font-bold hover:bg-yellow-600 shadow-md">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>