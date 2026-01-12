<x-app-layout>
    {{-- Tambahkan CDN SweetAlert2 di bagian head (khusus halaman ini) --}}
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Sukses dari Controller (SweetAlert Toast) --}}
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}", 
                        timer: 3000,
                        showConfirmButton: false
                    });
                </script>
            @endif

            <div class="mb-6 flex justify-between items-center px-4 sm:px-0">
                <p class="text-gray-600 text-sm">Kelola akun admin dan karyawan.</p>
                <a href="{{ route('users.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition transform hover:scale-105">
                    + Tambah User
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-green-800 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full 
                                        {{ $user->hasRole('super-admin') ? 'bg-red-100 text-red-800' : 
                                           ($user->hasRole('admin') ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($user->getRoleNames()->first()) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($user->id !== auth()->id() && $user->id !== 1)
                                        <div class="flex justify-end gap-2">
                                            {{-- TOMBOL EDIT --}}
                                            <a href="{{ route('users.edit', $user) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded-md text-xs font-bold shadow-sm transition">
                                                Edit
                                            </a>

                                            {{-- FORM HAPUS DENGAN SWEETALERT --}}
                                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST">
                                                @csrf @method('DELETE')
                                                
                                                {{-- PERBAIKAN: Menambahkan addslashes() agar aman dari error tanda kutip --}}
                                                <button type="button" onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')" 
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-bold shadow-sm transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs italic">Terkunci</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPT SWEETALERT UNTUK KONFIRMASI HAPUS --}}
    <script>
        function confirmDelete(userId, userName) {
            Swal.fire({
                title: 'Hapus User?',
                text: "Anda akan menghapus user: " + userName,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33', // Merah
                cancelButtonColor: '#3085d6', // Biru
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#fff',
                customClass: {
                    popup: 'rounded-xl shadow-xl', // Styling tambahan
                    confirmButton: 'font-bold',
                    cancelButton: 'font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form secara manual jika user klik Ya
                    document.getElementById('delete-form-' + userId).submit();
                }
            })
        }
    </script>
</x-app-layout>