<x-new-layout title="Manajemen User - RS PKU Digital Library">
    
    <x-slot:header>
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 md:gap-8">
            <div class="flex-1 max-w-2xl">
                {{-- Search Users --}}
                <form method="GET" action="{{ route('users.index') }}" class="relative group" id="searchForm">
                    <input 
                        name="search" 
                        value="{{ request('search') }}" 
                        class="block w-full pl-4 pr-20 py-3 bg-gradient-to-r from-white to-gray-50 dark:from-gray-800 dark:to-gray-700 border-none rounded-2xl text-base text-gray-700 dark:text-white placeholder-gray-400 focus:outline-none shadow-lg hover:shadow-xl transition-shadow border border-gray-100 dark:border-gray-700 focus:ring-2 focus:ring-primary/20" 
                        placeholder="Cari nama atau email user..." 
                        type="text"
                        id="searchInput"
                        autocomplete="off"
                    />
                    
                    {{-- Clear Button --}}
                    @if(request('search'))
                    <a href="{{ route('users.index') }}" class="absolute inset-y-0 right-12 flex items-center pr-4 cursor-pointer group/clear hover:text-red-500 transition-colors" title="Hapus pencarian">
                        <span class="material-symbols-outlined text-[20px] text-gray-400 group-hover/clear:text-red-500">close</span>
                    </a>
                    @endif
                    
                    {{-- Search Button --}}
                    <button 
                        type="submit" 
                        class="absolute inset-y-0 right-0 px-4 py-3 text-primary hover:text-primary/80 active:scale-95 transition-all flex items-center justify-center"
                        title="Cari (Enter)"
                    >
                        <span class="material-symbols-outlined text-[22px]">search</span>
                    </button>
                </form>
            </div>
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('users.create') }}" class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-xl flex items-center gap-2 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-sm">person_add</span>
                    Tambah User
                </a>
            </div>
        </div>
    </x-slot:header>

    <div class="flex flex-col gap-6">
        
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold tracking-tight text-[#0d1b11] dark:text-white">Daftar Pengguna</h2>
                @if(request('search'))
                <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full">
                    "{{ request('search') }}"
                </span>
                @endif
            </div>
            <span class="text-sm text-gray-500">Total: {{ $users->total() }} User</span>
        </div>
        
        <!-- Alert Success -->
        @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        </script>
        @endif

        <!-- Empty State -->
        @if($users->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 mb-4">person_off</span>
            @if(request('search'))
            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2">Tidak ada hasil pencarian</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Coba gunakan kata kunci yang berbeda</p>
            <a href="{{ route('users.index') }}" class="text-primary font-medium hover:underline">Lihat semua user</a>
            @else
            <h3 class="text-lg font-bold text-gray-700 dark:text-gray-300 mb-2">Belum ada user</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Mulai dengan membuat user baru</p>
            @endif
        </div>
        @else

        <!-- Users Table - Desktop View -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hidden md:block">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bergabung</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <!-- User Info -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-[#0d1b11] dark:text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Role Badge -->
                            <td class="px-6 py-4">
                                @php
                                    $roleColor = 'bg-gray-100 text-gray-600';
                                    if ($user->hasRole('super-admin')) $roleColor = 'bg-red-100 text-red-700 border border-red-200';
                                    elseif ($user->hasRole('admin')) $roleColor = 'bg-blue-100 text-blue-700 border border-blue-200';
                                    else $roleColor = 'bg-green-100 text-green-700 border border-green-200';
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $roleColor }}">
                                    {{ ucfirst($user->getRoleNames()->first() ?? 'Staff') }}
                                </span>
                            </td>
                            
                            <!-- Joined Date -->
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            
                            <!-- Actions -->
                            <td class="px-6 py-4 text-right">
                                @if($user->id !== 1 && $user->id !== Auth::id())
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('users.edit', $user) }}" class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-600 flex items-center justify-center hover:bg-yellow-100 transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-lg">edit</span>
                                        </a>
                                        
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors" title="Delete">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400 italic">Protected</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        </div>

        <!-- Users Card Grid - Mobile View -->
        <div class="md:hidden grid gap-4">
            @foreach($users as $user)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
                <!-- User Info -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold shrink-0">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-[#0d1b11] dark:text-white truncate">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                    </div>
                </div>

                <!-- Role and Date -->
                <div class="flex items-center justify-between gap-2 mb-4">
                    @php
                        $roleColor = 'bg-gray-100 text-gray-600';
                        if ($user->hasRole('super-admin')) $roleColor = 'bg-red-100 text-red-700 border border-red-200';
                        elseif ($user->hasRole('admin')) $roleColor = 'bg-blue-100 text-blue-700 border border-blue-200';
                        else $roleColor = 'bg-green-100 text-green-700 border border-green-200';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $roleColor }}">
                        {{ ucfirst($user->getRoleNames()->first() ?? 'Staff') }}
                    </span>
                    <span class="text-xs text-gray-500 whitespace-nowrap">{{ $user->created_at->format('d M Y') }}</span>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    @if($user->id !== 1 && $user->id !== Auth::id())
                        <a href="{{ route('users.edit', $user) }}" class="flex-1 px-3 py-2 bg-yellow-50 text-yellow-600 rounded-lg flex items-center justify-center gap-2 hover:bg-yellow-100 transition-colors text-sm font-medium">
                            <span class="material-symbols-outlined text-base">edit</span>
                            Edit
                        </a>
                        
                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')" class="flex-1 px-3 py-2 bg-red-50 text-red-600 rounded-lg flex items-center justify-center gap-2 hover:bg-red-100 transition-colors text-sm font-medium">
                                <span class="material-symbols-outlined text-base">delete</span>
                                Hapus
                            </button>
                        </form>
                    @else
                        <span class="flex-1 text-center text-xs text-gray-400 italic py-2">Protected</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="md:hidden">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    {{-- Script Confirmation --}}
    <x-slot:scripts>
        <script>
            function confirmDelete(userId, userName) {
                Swal.fire({
                    title: 'Hapus User?',
                    html: "Anda akan menghapus user <b>" + userName + "</b>.<br>Tindakan ini tidak dapat dibatalkan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    background: '#fff',
                    customClass: {
                        title: 'text-lg font-bold',
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-4 py-2',
                        cancelButton: 'rounded-xl px-4 py-2'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + userId).submit();
                    }
                })
            }

            // Search enhancement
            document.getElementById('searchInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('searchForm').submit();
                }
            });
        </script>
    </x-slot:scripts>
@role('super-admin')
<a href="{{ route('users.create') }}" class="fixed bottom-6 right-6 lg:hidden z-30 w-14 h-14 bg-primary text-[#0d1b11] rounded-full flex items-center justify-center shadow-lg shadow-primary/40 hover:scale-110 active:scale-95 transition-all">
    <span class="material-symbols-outlined text-2xl">person_add</span>
</a>
@endrole

</x-new-layout>