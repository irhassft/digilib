<div x-data="{ sidebarOpen: false }" class="flex flex-col lg:flex-row h-screen bg-white dark:bg-[#0A140E]">

    <!-- Mobile Top Bar -->
    <div class="fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-4 py-3 bg-gradient-to-r from-primary to-green-500 shadow-lg lg:hidden">
        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/50 transition-colors">
            <span class="material-symbols-outlined text-2xl">menu</span>
        </button>

        <a href="{{ route('welcome') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
            <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo" class="w-8 h-8">
            <div class="flex flex-col">
                <span class="font-bold text-white text-sm leading-tight">Digital Library</span>
                <span class="text-white text-[10px] font-medium">RS PKU Boyolali</span>
            </div>
        </a>

        <div class="w-10"></div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-black/50 lg:hidden">
    </div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-[#162a1b] border-r border-gray-200 dark:border-gray-800 flex flex-col justify-between p-4 pt-20 transition-transform duration-300 ease-in-out lg:pt-4 lg:static lg:translate-x-0 lg:w-64">
        
        <div class="flex flex-col gap-8">
            <!-- Logo Area -->
            <div class="flex items-center justify-between px-2 lg:px-0">
                <a href="{{ route('welcome') }}" class="hidden lg:flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="w-10 h-10">
                    <div class="flex flex-col">
                        <h1 class="text-[#0d1b11] dark:text-white text-sm font-bold leading-tight">Digital Library</h1>
                        <p class="text-primary text-[10px] font-medium uppercase tracking-wider">RS PKU Boyolali</p>
                    </div>
                </a>
                
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-red-500 transition-colors ml-auto">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex flex-col gap-2">
                {{-- <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('welcome') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}" 
                   href="{{ route('welcome') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('welcome') ? 'fill-1' : '' }}">home</span>
                    <span class="text-sm {{ request()->routeIs('welcome') ? 'font-semibold' : 'font-medium' }}">Landing</span>
                </a> --}}

                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}" 
                   href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'fill-1' : '' }}">dashboard</span>
                    <span class="text-sm {{ request()->routeIs('dashboard') ? 'font-semibold' : 'font-medium' }}">Dashboard</span>
                </a>
                
                @if(Route::has('collections.index'))
                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('collections.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}" 
                   href="{{ route('collections.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('collections.*') ? 'fill-1' : '' }}">menu_book</span>
                    <span class="text-sm {{ request()->routeIs('collections.*') ? 'font-semibold' : 'font-medium' }}">Daftar Dokumen</span>
                </a>
                @endif

                @role('super-admin')
                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('users.*') ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}" 
                   href="{{ route('users.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('users.*') ? 'fill-1' : '' }}">manage_accounts</span>
                    <span class="text-sm {{ request()->routeIs('users.*') ? 'font-semibold' : 'font-medium' }}">Manajemen User</span>
                </a>
                @endrole

                <div class="my-4 border-t border-gray-200 dark:border-gray-800"></div>
            </nav>
        </div>
        
        <!-- Bottom Sidebar Section -->
        <div class="flex flex-col gap-2">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                <span class="material-symbols-outlined">person</span>
                <span class="text-sm font-medium">Profile</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-medium">Log Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col w-full pt-16 lg:pt-0 overflow-hidden">
        {{ $slot ?? '' }}
    </div>

</div>