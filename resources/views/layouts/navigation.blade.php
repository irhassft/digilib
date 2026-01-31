<nav x-data="{ open: false }" class="bg-green-600 border-b border-green-700 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> {{-- Tinggi sedikit ditambah agar gagah --}}
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="h-12 w-auto">
                        <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="h-12 w-auto">
                        <h1 class="text-xl font-bold text-white tracking-wide leading-tight">
                            Digital Library <br><span class="text-sm font-light text-green-50">RS PKU Aisyiyah Boyolali</span>
                        </h1>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-4 {{ request()->routeIs('dashboard') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-green-200' }} text-base font-bold transition duration-150 ease-in-out">
                        {{ __('Dashboard') }}
                    </a>

                    @role('super-admin')
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-1 pt-1 border-b-4 {{ request()->routeIs('users.*') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-green-200' }} text-base font-bold transition duration-150 ease-in-out">
                            {{ __('Kelola User') }}
                        </a>
                    @endrole

                    @hasanyrole('admin|super-admin')
                        <a href="{{ route('documents.create') }}" class="inline-flex items-center px-1 pt-1 border-b-4 {{ request()->routeIs('documents.create') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-green-200' }} text-base font-bold transition duration-150 ease-in-out">
                            {{ __('Upload Dokumen') }}
                        </a>
                    @endhasanyrole
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-bold rounded-full text-green-700 bg-white hover:bg-green-50 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-green-600">
                                    <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                                </svg>
                                {{ Auth::user()->name }}
                            </div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
             <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-green-100 hover:text-white hover:bg-green-500 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    {{-- Responsive Menu (Mobile) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-green-700">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            
            @role('super-admin')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="text-white">
                    {{ __('Kelola User') }}
                </x-responsive-nav-link>
            @endrole

            @hasanyrole('admin|super-admin')
            <x-responsive-nav-link :href="route('documents.create')" ...>
                {{ __('Upload Dokumen') }}
            </x-responsive-nav-link>
            @endhasanyrole

        </div>
            <div class="pt-4 pb-1 border-t border-green-500">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="text-white">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                </div>
            </div>
    </div>
</nav>