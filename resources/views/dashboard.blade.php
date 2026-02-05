<x-new-layout title="Dashboard - RS PKU Digital Library">
    <x-slot:header>
        <!-- Header Responsif -->
        <div class="w-full flex flex-col gap-4">
            <!-- Search Bar & Upload Button -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                <form action="{{ route('collections.index') }}" method="GET" class="relative group flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center w-full gap-3">
                        <div class="relative flex-1 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-lg hover:shadow-xl transition-all border border-white/50 dark:border-gray-700/50">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-primary text-[24px]">search</span>
                            </div>
                            <input name="search" value="{{ request('search') }}" 
                                   class="block w-full pl-14 pr-4 py-3 sm:py-2.5 bg-transparent border-none text-base sm:text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none font-medium" 
                                   placeholder="Cari dokumen..." type="text"/>
                        </div>
                        <button type="submit" class="shrink-0 inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-2.5 bg-gradient-to-r from-teal-700 via-teal-600 to-teal-700 text-white text-sm font-bold rounded-2xl hover:shadow-lg active:scale-95 transition-all shadow-md whitespace-nowrap">
                            <span class="hidden sm:inline">Cari</span>
                            <span class="sm:hidden material-symbols-outlined">search</span>
                        </button>
                    </div>
                </form>

                <!-- Upload Button - Desktop Only -->
                @hasanyrole('admin|super-admin')
                <a href="{{ route('documents.create') }}" class="hidden sm:inline-flex items-center justify-center px-6 py-2.5 bg-gradient-to-r from-amber-500 to-amber-600 text-white text-sm font-bold rounded-2xl shadow-md hover:shadow-lg hover:scale-[1.02] active:scale-95 transition-all gap-2 whitespace-nowrap">
                    <span class="material-symbols-outlined text-[18px]">upload_file</span>
                    <span>Upload</span>
                </a>
                @endhasanyrole
            </div>
        </div>
    </x-slot:header>
    
    <!-- Main Content - Responsive Layout -->
    <div class="w-full flex flex-col lg:flex-row gap-6 pb-8">
        
        <!-- Left Content (Main) -->
        <div class="flex-1 flex flex-col gap-8 min-w-0">
            
            <!-- Rekomendasi Section -->
            <section class="w-full">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-0 mb-6 sm:mb-8">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Rekomendasi</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Dokumen pilihan untuk Anda</p>
                    </div>
                    <a href="{{ route('collections.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-teal-700 hover:text-teal-800 dark:text-amber-400 dark:hover:text-amber-300 transition-colors whitespace-nowrap">
                        Lihat Semua
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>

                <!-- Document Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($documents->take(3) as $doc)
                    <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="group bg-white dark:bg-gray-800/50 backdrop-blur-sm rounded-2xl sm:rounded-3xl overflow-hidden shadow-md hover:shadow-xl transition-all border border-gray-200 dark:border-gray-700/50 hover:border-teal-600/30 flex flex-col h-full hover:-translate-y-1">
                        
                        <!-- Cover Image -->
                        <div class="relative aspect-video w-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden">
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
                                <img src="{{ $coverUrl }}" alt="{{ $doc->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                                    <span class="material-symbols-outlined text-5xl sm:text-7xl text-gray-300 dark:text-gray-600 group-hover:scale-110 transition-transform duration-700">description</span>
                                </div>
                            @endif
                            
                            <!-- Category Badge - Subtle -->
                            <div class="absolute top-3 left-3 sm:top-4 sm:left-4">
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-black/40 dark:bg-black/50 backdrop-blur-sm text-[10px] sm:text-xs font-medium text-white/80 uppercase tracking-wide">
                                    {{ $doc->category->name ?? 'UMUM' }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-4 sm:p-6 flex flex-col gap-3 sm:gap-4 flex-1">
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white leading-snug line-clamp-2 group-hover:text-teal-700 transition-colors">
                                {{ $doc->title }}
                            </h3>
                            
                            <!-- Metadata Footer -->
                            <div class="mt-auto pt-3 sm:pt-4 border-t border-gray-200 dark:border-gray-700/50 flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">
                                    <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full bg-gradient-to-br from-teal-700 to-teal-800 shrink-0 flex items-center justify-center text-white text-xs font-bold shadow-md">
                                        {{ substr($doc->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 truncate">{{ $doc->user->name ?? 'Admin' }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $doc->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-400 shrink-0">{{ $doc->created_at->diffForHumans() }}</span>
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
                        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Kategori</h2>
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
                    <a href="{{ route('collections.index', ['category_id' => $category->id, 'mode' => 'all']) }}" class="group p-4 sm:p-6 bg-white dark:bg-gray-800/50 backdrop-blur-sm rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700/50 hover:border-teal-600/30 shadow-sm hover:shadow-md transition-all hover:scale-105 hover:-translate-y-1 flex flex-col gap-3 sm:gap-4">
                        <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-lg sm:rounded-xl bg-gradient-to-br from-teal-700/30 to-teal-600/30 dark:from-teal-700/20 dark:to-teal-600/20 flex items-center justify-center group-hover:from-teal-700 group-hover:to-teal-600 group-hover:shadow-lg transition-all text-teal-700 group-hover:text-white">
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
            <div class="bg-gradient-to-br from-teal-700/25 via-teal-600/25 to-teal-500/25 dark:from-teal-700/15 dark:via-teal-600/15 dark:to-teal-500/15 rounded-2xl sm:rounded-3xl p-6 sm:p-8 relative overflow-hidden border border-teal-700/20 dark:border-teal-700/10 shadow-lg">
                <div class="absolute -right-12 -top-12 w-48 h-48 bg-teal-700/40 rounded-full blur-3xl opacity-50"></div>
                <div class="absolute -left-12 -bottom-12 w-32 h-32 bg-teal-600/30 rounded-full blur-3xl opacity-30"></div>
                
                <div class="relative z-10 space-y-4 sm:space-y-6">
                    <div>
                        <p class="text-xs sm:text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Total Dokumen</p>
                        <p class="text-4xl sm:text-5xl lg:text-6xl font-bold text-teal-700 dark:text-teal-400 mt-2 sm:mt-3">{{ $totalDocuments }}</p>
                    </div>
                    
                    <div class="pt-4 sm:pt-6 border-t border-teal-700/20 dark:border-teal-700/10">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg bg-white/50 dark:bg-gray-800/50 shrink-0">
                                <span class="material-symbols-outlined text-lg sm:text-xl text-amber-500">trending_up</span>
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
                            <div class="flex-shrink-0 inline-flex items-center justify-center h-9 sm:h-10 w-9 sm:w-10 rounded-lg bg-gradient-to-br from-teal-700/30 to-teal-600/30 dark:from-teal-700/20 dark:to-teal-600/20 text-teal-700">
                                <span class="material-symbols-outlined text-base sm:text-lg">upload_file</span>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                                {{ $upload->user->name ?? 'Seseorang' }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">Mengunggah</p>
                            <a href="#" class="text-sm font-semibold text-teal-700 hover:text-teal-800 dark:text-amber-400 dark:hover:text-amber-300 truncate block mt-1">
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
<a href="{{ route('documents.create') }}" class="fixed bottom-6 right-6 lg:hidden z-30 w-14 h-14 bg-primary text-[#0d1b11] rounded-full flex items-center justify-center shadow-lg shadow-primary/40 hover:scale-110 active:scale-95 transition-all">
    <span class="material-symbols-outlined text-2xl">add</span>
</a>
@endhasanyrole