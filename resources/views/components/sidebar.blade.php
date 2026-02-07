<div x-data="{ sidebarOpen: false }" class="flex flex-col lg:flex-row h-screen bg-white dark:bg-[#0A140E]">

    <!-- Mobile Top Bar - Modern Header -->
    <div class="fixed top-0 left-0 right-0 z-40 flex items-center justify-between px-4 py-3.5 bg-gradient-to-r from-primary via-green-400 to-green-500 shadow-md shadow-primary/20 lg:hidden backdrop-blur-sm">
        <!-- Menu Button -->
        <button @click="sidebarOpen = !sidebarOpen" 
                :class="sidebarOpen ? 'bg-white/20' : 'hover:bg-white/15'"
                class="p-2.5 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-white/30 transition-all duration-300 active:scale-95">
            <span class="material-symbols-outlined text-xl">menu</span>
        </button>

        <div class="flex-1"></div>
    </div>

    <!-- Mobile Sidebar Overlay - Smooth Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-all ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-all ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-gradient-to-r from-black/40 to-black/30 lg:hidden backdrop-blur-sm">
    </div>

    <!-- Sidebar Navigation - Premium Design -->
    <aside :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full shadow-lg'"
           class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-white via-slate-50 to-gray-50 dark:from-[#162a1b] dark:via-[#0f1f18] dark:to-[#0a140e] border-r border-gray-200/40 dark:border-gray-800/50 flex flex-col justify-between p-5 pt-12 transition-all duration-300 ease-out lg:pt-5 lg:static lg:translate-x-0 lg:w-64 lg:shadow-none overflow-y-auto">
        
        <div class="flex flex-col gap-2">
            <!-- Logo Area - Mobile & Desktop -->
            <div class="flex items-center justify-between px-2 lg:px-0">
                <a href="{{ route('welcome') }}" class="flex items-center gap-3 hover:opacity-85 transition-all duration-300 group">
                    <div class="relative">
                        <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="w-10 h-10 group-hover:scale-110 transition-transform duration-300">
                    </div>
                    <div class="flex flex-col">
                        <h1 class="text-[#0d1b11] dark:text-white text-sm font-bold leading-tight">Digital Library</h1>
                        <p class="text-primary text-[10px] font-semibold uppercase tracking-wider">RS PKU Boyolali</p>
                    </div>
                </a>
                
                <!-- Close Button Mobile -->
                <button @click="sidebarOpen = false" 
                        class="lg:hidden text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 transition-colors duration-200 ml-auto p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Navigation Menu - Enhanced Styling -->
            <nav class="flex flex-col gap-1.5 -mx-1">
                <div class="px-3 py-1.5 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Menu Utama</div>

                <a class="group flex items-center gap-3.5 px-3.5 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-primary/15 to-green-400/10 text-primary dark:text-primary shadow-sm shadow-primary/10' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50' }}" 
                   href="{{ route('dashboard') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'fill-1 text-primary' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-200' }} transition-colors duration-200">dashboard</span>
                    <span class="text-sm {{ request()->routeIs('dashboard') ? 'font-semibold' : 'font-medium group-hover:font-medium' }} transition-all duration-200">Dashboard</span>
                    @if(request()->routeIs('dashboard'))
                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></div>
                    @endif
                </a>
                
                @if(Route::has('collections.index'))
                <a class="group flex items-center gap-3.5 px-3.5 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('collections.*') ? 'bg-gradient-to-r from-primary/15 to-green-400/10 text-primary dark:text-primary shadow-sm shadow-primary/10' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50' }}" 
                   href="{{ route('collections.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('collections.*') ? 'fill-1 text-primary' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-200' }} transition-colors duration-200">menu_book</span>
                    <span class="text-sm {{ request()->routeIs('collections.*') ? 'font-semibold' : 'font-medium group-hover:font-medium' }} transition-all duration-200">Daftar Dokumen</span>
                    @if(request()->routeIs('collections.*'))
                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></div>
                    @endif
                </a>
                @endif

                @role('super-admin')
                <div class="px-3 py-1.5 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Administrasi</div>
                <a class="group flex items-center gap-3.5 px-3.5 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-gradient-to-r from-blue-500/15 to-blue-400/10 text-blue-600 dark:text-blue-400 shadow-sm shadow-blue-500/10' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50' }}" 
                   href="{{ route('users.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('users.*') ? 'fill-1 text-blue-600 dark:text-blue-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-200' }} transition-colors duration-200">manage_accounts</span>
                    <span class="text-sm {{ request()->routeIs('users.*') ? 'font-semibold' : 'font-medium group-hover:font-medium' }} transition-all duration-200">Manajemen User</span>
                    @if(request()->routeIs('users.*'))
                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-blue-600 dark:bg-blue-400 animate-pulse"></div>
                    @endif
                </a>
                @endrole

                <div class="my-3 h-px bg-gradient-to-r from-gray-200 via-gray-200 to-transparent dark:from-gray-800 dark:via-gray-800 dark:to-transparent"></div>
            </nav>
        </div>
        
        <!-- Bottom Sidebar Section - User Profile & Logout -->
        <div class="flex flex-col gap-2 mt-auto pt-4 border-t border-gray-200/40 dark:border-gray-800/50">
            <a href="{{ route('profile.edit') }}" 
               class="group flex items-center gap-3.5 px-3.5 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-gradient-to-r from-purple-500/15 to-purple-400/10 text-purple-600 dark:text-purple-400 shadow-sm shadow-purple-500/10' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800/50' }}">
                <span class="material-symbols-outlined {{ request()->routeIs('profile.*') ? 'fill-1 text-purple-600 dark:text-purple-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-200' }} transition-colors duration-200">person</span>
                <span class="text-sm {{ request()->routeIs('profile.*') ? 'font-semibold' : 'font-medium' }} transition-all duration-200">Profil Saya</span>
                @if(request()->routeIs('profile.*'))
                <div class="ml-auto w-1.5 h-1.5 rounded-full bg-purple-600 dark:bg-purple-400 animate-pulse"></div>
                @endif
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full group flex items-center gap-3.5 px-3.5 py-3 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 transition-all duration-200 active:scale-95">
                    <span class="material-symbols-outlined text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors duration-200">logout</span>
                    <span class="text-sm font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col w-full pt-16 lg:pt-0 overflow-hidden">
        {{ $slot ?? '' }}
    </div>

</div>