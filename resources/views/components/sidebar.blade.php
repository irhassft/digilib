<div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-50 dark:bg-[#0A140E]">

    <div class="fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-4 py-3 bg-white dark:bg-[#162a1b] border-b border-gray-100 dark:border-gray-800 lg:hidden">
        
        <div class="flex items-center gap-2">
            <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo" class="w-8 h-8">
            <span class="font-bold text-[#0d1b11] dark:text-white text-sm">Digital Library</span>
        </div>

        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/50">
            <span class="material-symbols-outlined text-2xl">menu</span>
        </button>
    </div>

    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 lg:hidden">
    </div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-[#162a1b] border-r border-gray-100 dark:border-gray-800 flex flex-col justify-between p-4 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0">
        
        <div class="flex flex-col gap-8">
            {{-- LOGO AREA (Desktop & Saat Sidebar Terbuka) --}}
            <div class="flex items-center justify-between px-2">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="w-10 h-10">
                    <div class="flex flex-col">
                        <h1 class="text-[#0d1b11] dark:text-white text-sm font-bold leading-tight">Digital Library</h1>
                        <p class="text-primary text-[10px] font-medium uppercase tracking-wider">RS PKU Boyolali</p>
                    </div>
                </div>
                
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-red-500 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            {{-- MENU NAVIGASI --}}
            <nav class="flex flex-col gap-2">
                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}" 
                   href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'fill-1' : '' }}">dashboard</span>
                    <span class="text-sm {{ request()->routeIs('dashboard') ? 'font-semibold' : 'font-medium' }}">Dashboard</span>
                </a>
                
                @if(Route::has('collections.index'))
                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('collections.*') ? 'bg-primary/10 text-primary' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}" 
                   href="{{ route('collections.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('collections.*') ? 'fill-1' : '' }}">menu_book</span>
                    <span class="text-sm {{ request()->routeIs('collections.*') ? 'font-semibold' : 'font-medium' }}">Daftar Dokumen</span>
                </a>
                @else
                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors text-gray-500 dark:text-gray-400">
                    <span class="material-symbols-outlined">menu_book</span>
                    <span class="text-sm font-medium">Daftar Dokumen</span>
                </a>
                @endif

                @role('super-admin')
                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('users.*') ? 'bg-primary/10 text-primary' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}" 
                   href="{{ route('users.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('users.*') ? 'fill-1' : '' }}">manage_accounts</span>
                    <span class="text-sm {{ request()->routeIs('users.*') ? 'font-semibold' : 'font-medium' }}">Manajemen User</span>
                </a>
                @endrole

                <div class="my-4 border-t border-gray-100 dark:border-gray-800"></div>
            </nav>
        </div>
        
        {{-- BAGIAN BAWAH SIDEBAR --}}
        <div class="mt-3 flex flex-col gap-2">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800">
                <span class="material-symbols-outlined">person</span>
                <span class="text-sm font-medium">Profile</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-medium">Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col pt-16 lg:pt-0 overflow-hidden">
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 dark:bg-[#0A140E]">
            {{ $slot ?? '' }}
        </main>
    </div>

</div>