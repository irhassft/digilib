<x-new-layout title="Dashboard - RS PKU Digital Library">
    <x-slot:header>
        <!-- Header Responsif -->
        <div class="w-full flex flex-col gap-1 sm:gap-4">
            <!-- Search Bar & Upload Button -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <form action="{{ route('dashboard') }}" method="GET" id="dashboardSearchForm" class="relative group flex-1 min-w-0">
                    <div class="relative flex-1 bg-white dark:bg-gray-900/60 backdrop-blur-md rounded-full shadow-md hover:shadow-lg transition-all border border-gray-300 dark:border-gray-700 focus-within:border-primary flex items-center px-2 sm:px-0">
                           <input id="dashboardSearchInput" name="search" value="{{ request('search') }}"
                               class="block w-full pl-4 pr-12 py-2.5 sm:py-2.5 bg-transparent border-none text-lg sm:text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 font-medium rounded-full transition-all" 
                               placeholder="Cari dokumen..." type="text"/>

                        <button type="button" id="clearSearchBtn" class="absolute right-10 top-1/2 -translate-y-1/2 hidden p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>

                        <button type="submit" class="absolute inset-y-0 right-0 px-4 sm:px-6 flex items-center justify-center text-primary hover:text-primary dark:text-primary-light dark:hover:text-primary-light transition-colors">
                            <span class="material-symbols-outlined text-[20px]">search</span>
                        </button>
                    </div>
                </form>

                <!-- Visibility Dropdown -->
                <div class="relative">
                    <select name="visibility" id="visibilityFilter" form="dashboardSearchForm" class="block w-full sm:w-auto px-4 py-2.5 sm:py-2 bg-white dark:bg-gray-900/60 border border-gray-300 dark:border-gray-700 rounded-full text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50 text-sm font-medium pr-10 appearance-none">
                        <option value="all" {{ request('visibility') == 'all' ? 'selected' : '' }}>Semua Visibilitas</option>
                        <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Publik</option>
                        <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Privat</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-700 dark:text-gray-300">
                        <span class="material-symbols-outlined text-[20px]">arrow_drop_down</span>
                    </div>
                </div>

                <!-- Upload Button - Desktop Only -->
                @hasanyrole('admin|super-admin')
                <a href="{{ route('documents.create') }}" class="hidden sm:inline-flex items-center justify-center px-6 py-2.5 bg-primary hover:bg-primary text-white text-sm font-bold rounded-2xl shadow-md hover:shadow-lg hover:scale-[1.02] active:scale-95 transition-all gap-2 whitespace-nowrap">
                    <span class="material-symbols-outlined text-[18px]">upload_file</span>
                    <span>Upload</span>
                </a>
                @endhasanyrole
            </div>
        </div>
    </x-slot:header>
    
    <!-- Main Content - Responsive Layout -->
    <div class="w-full flex flex-col lg:flex-row gap-4 lg:gap-6 pb-8">
        
        <!-- Left Content (Main) -->
        <div class="flex-1 flex flex-col gap-6 sm:gap-8 min-w-0">
            
            <!-- Rekomendasi Section -->
            <section class="w-full -mt-8 sm:mt-0">
                <div class="flex items-center justify-between gap-3 mb-2 sm:mb-8">
                    <div>
                        <h2 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">Rekomendasi</h2>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">Dokumen pilihan untuk Anda</p>
                    </div>
                    <a href="{{ route('collections.index') }}" class="inline-flex items-center gap-2 px-3 py-1 text-xs sm:text-sm font-semibold text-teal-700 hover:text-teal-800 dark:text-amber-400 dark:hover:text-amber-300 transition-colors whitespace-nowrap">
                        Lihat Semua
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                <!-- Document Cards Grid (compact mobile: 2 cols) -->
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    @foreach($documents->take(6) as $doc)
                    <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="group bg-white dark:bg-gray-800/50 backdrop-blur-sm rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-gray-100 dark:border-gray-700/50 hover:border-primary/20 flex flex-col h-full">
                        <!-- Compact Cover -->
                        <div class="w-full h-28 sm:h-36 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden flex-shrink-0">
                            @php
                                $cover = $doc->cover_image;
                                $publicPath = $cover ? public_path('storage/'.$cover) : null;
                                $coverUrl = null;
                                if ($cover) {
                                    if ($publicPath && file_exists($publicPath)) {
                                        $coverUrl = asset('storage/'.$cover);
                                    } elseif (Storage::disk('public')->exists($cover)) {
                                        $coverUrl = Storage::disk('public')->url($cover);
                                    }
                                }
                            @endphp

                            @if($coverUrl)
                                <img src="{{ $coverUrl }}" alt="{{ $doc->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                                    <span class="material-symbols-outlined text-3xl text-gray-300 dark:text-gray-500">description</span>
                                </div>
                            @endif
                        </div>

                        <!-- Compact Content -->
                        <div class="p-2 sm:p-3 flex flex-col gap-1 flex-1">
                            <h3 class="text-sm sm:text-sm font-semibold text-gray-900 dark:text-white leading-tight line-clamp-2 group-hover:text-primary transition-colors">{{ $doc->title }}</h3>
                            <div class="flex items-center justify-between mt-auto pt-1">
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $doc->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>

            <!-- Kategori Section -->
            <section class="w-full">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-0 mb-6 sm:mb-8">
                    <div>
                        <h2 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">Kategori</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Jelajahi berdasarkan kategori</p>
                    </div>
                    <a href="{{ route('collections.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-teal-700 hover:text-teal-800 dark:text-amber-400 dark:hover:text-amber-300 transition-colors whitespace-nowrap">
                        Lihat Semua
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
                
                <!-- Category Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-5">
                    @foreach($categories->take(4) as $category)
                    <a href="{{ route('collections.index', ['category_id' => $category->id, 'mode' => 'all']) }}" class="group p-4 sm:p-6 bg-white dark:bg-gray-800/50 backdrop-blur-sm rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700/50 hover:border-primary/30 shadow-sm hover:shadow-md transition-all hover:scale-105 hover:-translate-y-1 flex flex-col gap-3 sm:gap-4">
                        <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-lg sm:rounded-xl bg-gradient-to-br from-primary/30 to-primary/20 dark:from-primary/20 dark:to-primary/10 flex items-center justify-center group-hover:from-primary group-hover:to-primary group-hover:shadow-lg transition-all text-primary group-hover:text-white">
                            <span class="material-symbols-outlined text-2xl sm:text-3xl">folder_open</span> 
                        </div>
                        <div>
                            <h3 class="font-bold text-sm sm:text-base text-gray-900 dark:text-white line-clamp-2 leading-tight mb-1">{{ $category->name }}</h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-semibold">{{ $category->documents_count ?? 0 }} Dokumen</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- Right Sidebar (Stats & Activity) -->
        <aside class="w-full lg:w-96 flex flex-col gap-4 sm:gap-6 shrink-0">
            <!-- Stats Card -->
            <div class="bg-gradient-to-br from-primary/25 via-primary/20 to-primary/15 dark:from-primary/15 dark:via-primary/10 dark:to-primary/5 rounded-2xl sm:rounded-3xl p-6 sm:p-8 relative overflow-hidden border border-primary/20 dark:border-primary/10 shadow-lg">
                <div class="absolute -right-12 -top-12 w-48 h-48 bg-primary/40 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute -left-12 -bottom-12 w-32 h-32 bg-primary/30 rounded-full blur-3xl opacity-30"></div>
                
                <div class="relative z-10 space-y-4 sm:space-y-6">
                    <div>
                        <p class="text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Total Dokumen</p>
                        <p class="text-4xl sm:text-5xl lg:text-6xl font-bold text-primary dark:text-primary-light mt-2 sm:mt-3">{{ $totalDocuments }}</p>
                    </div>
                    
                    <div class="pt-4 sm:pt-6 border-t border-primary/20 dark:border-primary/10">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-white/50 dark:bg-gray-800/50 shrink-0">
                                <span class="material-symbols-outlined text-lg sm:text-xl text-primary">trending_up</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs text-gray-600 dark:text-gray-400">Minggu ini</p>
                                <p class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">+{{ $documents->where('created_at', '>=', now()->subWeek())->count() }} dokumen</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Feed -->
            <div class="bg-white dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl sm:rounded-3xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700/50 shadow-lg">
                <h3 class="font-bold text-base sm:text-lg text-gray-900 dark:text-white mb-4 sm:mb-6">Aktivitas Terbaru</h3>
                
                <div class="space-y-4 sm:space-y-5">
                    @forelse($latestUploads as $upload)
                    <div class="flex gap-3 sm:gap-4 pb-4 sm:pb-5 border-b border-gray-100 dark:border-gray-700/50 last:border-0 last:pb-0">
                        <div class="flex-shrink-0">
                            <div class="flex-shrink-0 inline-flex items-center justify-center h-9 sm:h-10 w-9 sm:w-10 rounded-lg bg-gradient-to-br from-primary/30 to-primary/20 dark:from-primary/20 dark:to-primary/10 text-primary">
                                <span class="material-symbols-outlined text-base sm:text-lg">upload_file</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                {{ $upload->user->name ?? 'Seseorang' }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">Mengunggah</p>
                            <a href="{{ route('documents.view', $upload->id) }}" target="_blank" class="text-sm font-semibold text-primary hover:text-primary dark:text-primary-light dark:hover:text-primary-light truncate block mt-1">
                                {{ $upload->title }}
                            </a>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">{{ $upload->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 py-6 sm:py-8 text-sm">Belum ada aktivitas</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</x-new-layout>

{{-- Floating Upload Button (Mobile Only) --}}
@hasanyrole('admin|super-admin')
<a href="{{ route('documents.create') }}" aria-label="Upload dokumen" title="Upload Dokumen" class="fixed bottom-4 right-4 lg:hidden z-40 flex items-center gap-3 px-4 py-3 bg-primary text-white rounded-full shadow-xl hover:shadow-2xl transform-gpu hover:scale-105 active:scale-95 transition-all">
    <span class="material-symbols-outlined text-2xl">upload_file</span>
    <span class="text-sm font-semibold">Upload</span>
</a>
@endhasanyrole
    <script>
document.addEventListener('DOMContentLoaded', function(){
    const input = document.getElementById('dashboardSearchInput');
    const clearBtn = document.getElementById('clearSearchBtn');
    const visibilityFilter = document.getElementById('visibilityFilter');
    const searchForm = document.getElementById('dashboardSearchForm');

    function updateClear(){
        if(!input || !clearBtn) return;
        if(input.value && input.value.trim() !== '') clearBtn.classList.remove('hidden');
        else clearBtn.classList.add('hidden');
    }

    if(input){
        input.addEventListener('input', updateClear);
        updateClear(); // Set initial state
    }

    if(clearBtn){
        clearBtn.addEventListener('click', function(){
            if(input) input.value = '';
            updateClear();
            if(searchForm) searchForm.submit(); // Submit form after clearing search
        });
    }

    if(visibilityFilter){
        visibilityFilter.addEventListener('change', function(){
            if(searchForm) searchForm.submit(); // Submit form when visibility changes
        });
    }
});
</script>        input.addEventListener('input', updateClear);
        input.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ input.value = ''; updateClear(); } });
        updateClear();
    }

    if(clearBtn && input){
        clearBtn.addEventListener('click', function(){ input.value = ''; updateClear(); input.focus(); });
    }
});
</script>