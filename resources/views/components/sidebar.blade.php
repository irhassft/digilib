<aside class="w-64 fixed h-screen bg-white dark:bg-[#162a1b] border-r border-gray-100 dark:border-gray-800 flex flex-col justify-between p-4 z-50">
    <div class="flex flex-col gap-8">
        {{-- LOGO --}}
        <div class="flex items-center gap-3 px-2">
            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-white">medical_services</span>
            </div>
            <div class="flex flex-col">
                <h1 class="text-[#0d1b11] dark:text-white text-sm font-bold leading-tight">RS PKU Library</h1>
                <p class="text-primary text-[10px] font-medium uppercase tracking-wider">Staff Medis Portal</p>
            </div>
        </div>

            {{-- NAVIGATION --}}
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

                {{-- Menu Khusus Super Admin --}}
                @role('super-admin')
                <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('users.*') ? 'bg-primary/10 text-primary' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}" 
                   href="{{ route('users.index') }}">
                    <span class="material-symbols-outlined {{ request()->routeIs('users.*') ? 'fill-1' : '' }}">manage_accounts</span>
                    <span class="text-sm {{ request()->routeIs('users.*') ? 'font-semibold' : 'font-medium' }}">Manajemen User</span>
                </a>
                @endrole

            <div class="my-4 border-t border-gray-100 dark:border-gray-800"></div>
         
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="text-sm font-medium">Log Out</span>
                </a>
            </form>
        </nav>
    </div>
    
    {{-- USER PROFILE --}}
    <div class="bg-gray-50 dark:bg-gray-800/50 p-3 rounded-xl flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-cover bg-center flex items-center justify-center bg-green-200 text-green-700 font-bold">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div class="flex flex-col overflow-hidden">
            <p class="text-xs font-bold truncate">{{ Auth::user()->name }}</p>
            <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email }}</p>
        </div>
    </div>
</aside>
