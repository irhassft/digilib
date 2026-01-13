<x-new-layout title="Dashboard - RS PKU Digital Library">
    <x-slot:header>
        <div class="max-w-6xl mx-auto flex items-center justify-between gap-8 h-full">
            <div class="flex-1 max-w-2xl">
                <form action="{{ route('dashboard') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors">search</span>
                    </div>
                    <input name="search" value="{{ request('search') }}" 
                           class="block w-full pl-11 pr-4 py-2.5 bg-white dark:bg-gray-800 border-none rounded-xl text-sm shadow-sm focus:ring-2 focus:ring-primary transition-all" 
                           placeholder="Cari dokumen, SOP, atau panduan..." type="text"/>
                </form>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center text-gray-500 hover:text-primary transition-colors shadow-sm">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                
                @hasanyrole('admin|super-admin')
                <a href="{{ route('documents.create') }}" class="px-4 py-2 bg-primary text-[#0d1b11] text-sm font-bold rounded-xl flex items-center gap-2 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-sm">upload_file</span>
                    Upload Riset
                </a>
                @endhasanyrole
            </div>
        </div>
    </x-slot:header>

    <div class="max-w-6xl mx-auto flex gap-8">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col gap-8 min-w-0">
            
            <!-- Recommendations Carousel -->
            <section class="w-full relative group">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold tracking-tight text-[#0d1b11] dark:text-white">Rekomendasi Untukmu</h2>
                    <div class="flex gap-2">
                        <button class="w-8 h-8 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center text-gray-400 hover:text-primary shadow-sm transition-colors prev-btn">
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                        </button>
                        <button class="w-8 h-8 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center text-gray-400 hover:text-primary shadow-sm transition-colors next-btn">
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </div>

                {{-- Scroll Container --}}
                <div class="flex gap-4 overflow-x-auto pb-4 scroll-smooth snap-x scrollbar-hide" id="recommendations-container">
                    
                    @foreach($documents->take(5) as $doc)
                    <div class="min-w-[280px] h-[320px] bg-white dark:bg-gray-800 rounded-2xl p-4 flex flex-col justify-between relative shadow-sm hover:shadow-md transition-all snap-start border border-gray-100 dark:border-gray-800 group/card">
                        
                        <div class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center opacity-0 group-hover/card:opacity-100 transition-opacity cursor-pointer hover:bg-white hover:text-red-500 text-white">
                            <span class="material-symbols-outlined text-sm">favorite</span>
                        </div>

                        {{-- Cover Image or PDF Icon --}}
                        <div class="h-40 bg-gray-50 dark:bg-gray-700/50 rounded-xl flex items-center justify-center relative overflow-hidden group-hover/card:shadow-lg transition-all">
                            @if($doc->cover_image && Storage::disk('public')->exists($doc->cover_image))
                                <img src="{{ Storage::disk('public')->url($doc->cover_image) }}" alt="{{ $doc->title }}" class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-500">
                            @else
                                <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 group-hover/card:scale-110 transition-transform duration-500">picture_as_pdf</span>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                        </div>
                        
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 rounded-md bg-green-50 dark:bg-green-900/30 text-[10px] font-bold text-green-600 dark:text-green-400 uppercase tracking-wide">
                                    {{ $doc->category->name ?? 'UMUM' }}
                                </span>
                                @if($doc->year)
                                <span class="px-2 py-1 rounded-md bg-blue-50 dark:bg-blue-900/30 text-[10px] font-bold text-blue-600 dark:text-blue-400">
                                    {{ $doc->year }}
                                </span>
                                @endif
                                <span class="text-[10px] text-gray-400 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[10px]">visibility</span>
                                    1.2k
                                </span>
                            </div>
                            <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="text-sm font-bold text-[#0d1b11] dark:text-white leading-snug line-clamp-2 visited:text-[#0d1b11] hover:text-primary transition-colors">
                                {{ $doc->title }}
                            </a>
                            <div class="flex items-center justify-between mt-1">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                                    <span class="text-xs text-gray-500 truncate max-w-[80px]">{{ $doc->user->name ?? 'Admin' }}</span>
                                </div>
                                <span class="text-[10px] text-gray-400">{{ $doc->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </section>

            <!-- Categories Grid -->
            <section>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold tracking-tight text-[#0d1b11] dark:text-white">Kategori</h2>
                    <a href="{{ route('dashboard') }}" class="text-xs font-bold text-primary hover:underline">Lihat Semua</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($categories as $category)
                    <a href="{{ route('dashboard', ['category_id' => $category->id]) }}" class="group p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 transition-all text-left">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center mb-3 group-hover:bg-primary group-hover:text-[#0d1b11] transition-colors text-gray-400">
                            <span class="material-symbols-outlined">folder</span> 
                        </div>
                        <h3 class="font-bold text-sm text-[#0d1b11] dark:text-white">{{ $category->name }}</h3>
                        <p class="text-xs text-gray-400">{{ $category->documents_count ?? 0 }} Dokumen</p>
                    </a>
                    @endforeach
                </div>
            </section>

            <!-- Latest Documents List -->
            <section>
                <h2 class="text-lg font-bold tracking-tight text-[#0d1b11] dark:text-white mb-4">Dokumen Terbaru</h2>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($documents as $doc)
                        <div class="p-4 flex items-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group cursor-pointer">
                            <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-500 shrink-0 overflow-hidden">
                                @if($doc->cover_image && Storage::disk('public')->exists($doc->cover_image))
                                    <img src="{{ Storage::disk('public')->url($doc->cover_image) }}" alt="{{ $doc->title }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined">picture_as_pdf</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-sm text-[#0d1b11] dark:text-white truncate group-hover:text-primary transition-colors">{{ $doc->title }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs text-gray-500">{{ $doc->category->name ?? 'Uncategorized' }}</span>
                                    @if($doc->year)
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-xs text-gray-500">{{ $doc->year }}</span>
                                    @endif
                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                    <span class="text-xs text-gray-400">{{ $doc->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <form action="{{ route('documents.download', $doc->id) }}" method="GET" target="_blank"> 
                                    <button title="Download" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-primary hover:text-white transition-colors">
                                        <span class="material-symbols-outlined text-sm">download</span>
                                    </button>
                                </form>
                                <a href="{{ route('documents.view', $doc->id) }}" target="_blank" title="Preview" class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-blue-500 hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </a>
                                @hasanyrole('admin|super-admin')
                                <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button title="Hapus" class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition-colors">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </form>
                                @endhasanyrole
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-gray-500">
                            Belum ada dokumen yang diupload.
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="mt-4">
                    {{ $documents->links() }}
                </div>
            </section>
        </div>

        <!-- Right Side Stats (Optional) -->
        <aside class="w-80 hidden xl:flex flex-col gap-8 shrink-0">
            <div class="bg-primary/10 rounded-3xl p-6 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
                <h3 class="font-bold text-lg text-[#0d1b11] relative z-10">Total Arsip</h3>
                <p class="text-4xl font-bold text-primary mt-2 relative z-10">{{ $totalDocuments }}</p>
                <p class="text-sm text-gray-600 mt-1 relative z-10">+{{ $documents->where('created_at', '>=', now()->subWeek())->count() }} minggu ini</p>
            </div>

            <div>
                <h3 class="font-bold text-[#0d1b11] dark:text-white mb-4">Aktivitas Terbaru</h3>
                <div class="relative pl-4 border-l-2 border-dashed border-gray-200 dark:border-gray-700 space-y-6">
                    @foreach($latestUploads as $upload)
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-primary border-4 border-white dark:border-gray-900"></div>
                        <p class="text-xs text-gray-400 mb-1">{{ $upload->created_at->diffForHumans() }}</p>
                        <p class="text-sm font-bold text-[#0d1b11] dark:text-white leading-tight">
                            {{ $upload->user->name ?? 'Seseorang' }} Mengupload <span class="text-primary">{{ Str::limit($upload->title, 20) }}</span>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>

    {{-- Script for auto-scroll recommendations --}}
    <x-slot:scripts>
        <script>
            const container = document.getElementById('recommendations-container');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');

            if(container) {
                nextBtn.addEventListener('click', () => {
                    container.scrollBy({ left: 300, behavior: 'smooth' });
                });
                
                prevBtn.addEventListener('click', () => {
                    container.scrollBy({ left: -300, behavior: 'smooth' });
                });
            }
        </script>
    </x-slot:scripts>
</x-new-layout>