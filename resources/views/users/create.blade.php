<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">Tambah User Baru</h2>
    </x-slot>

    {{-- WRAPPER UTAMA: bg-gray-50 --}}
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            {{-- KARTU FORM: bg-white --}}
            <div class="bg-white p-8 shadow-md rounded-xl border-t-4 border-green-600">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full p-2.5 bg-white text-gray-900" type="text" name="name" required autofocus />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full p-2.5 bg-white text-gray-900" type="email" name="email" required />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="role" :value="__('Jabatan / Role')" />
                        <select name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 bg-white text-gray-900 p-2.5">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full p-2.5 bg-white text-gray-900" type="password" name="password" required />
                    </div>
                    <div class="mb-8">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full p-2.5 bg-white text-gray-900" type="password" name="password_confirmation" required />
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Batal</a>
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-green-700 shadow-md">Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>