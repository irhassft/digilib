<x-new-layout title="Dashboard - RS PKU Digital Library">
    <x-slot:header>
        <div class="w-full px-6 flex items-center justify-between gap-4 h-full">
            <div class="flex-1 max-w-xl">
                <form action="{{ route('dashboard') }}" method="GET" class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-gray-400 group-focus-within:text-primary transition-colors text-[20px]">search</span>
                    </div>
                    <input name="search" value="{{ request('search') }}" 
                           class="block w-full pl-10 pr-3 py-2 bg-white dark:bg-gray-800 border-none rounded-xl text-[13px] shadow-sm focus:ring-2 focus:ring-primary transition-all" 
                           placeholder="Cari dokumen, SOP, atau panduan..." type="text"/>
                </form>
            </div>
            <div class="flex items-center gap-3">
                <button class="w-9 h-9 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center text-gray-500 hover:text-primary transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                </button>
                
                @hasanyrole('admin|super-admin')
                <a href="{{ route('documents.create') }}" class="px-3 py-2 bg-primary text-[#0d1b11] text-xs font-bold rounded-xl flex items-center gap-1.5 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-[18px]">upload_file</span>
                    Upload
                </a>
                @endhasanyrole
            </div>
        </div>
    </x-slot:header>
    
    <div class="w-full px-6 flex flex-col xl:flex-row gap-6 pb-8">
        
        <div class="flex-1 flex flex-col gap-8 min-w-0">
            
            <section class="w-full">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold tracking-tight text-[#0d1b11] dark:text-white">Rekomendasi Untukmu</h2>
                    {{-- Tombol Selengkapnya --}}
                    <a href="{{ route('documents.index') }}" class="text-xs font-semibold text-primary hover:text-[#006030] flex items-center gap-1 transition-colors">
                        Selengkapnya
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                {{-- Grid 3 Kolom --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    
                    @foreach($documents->take(3) as $doc) {{-- Tampilkan hanya 3 --}}
                    <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="bg-white dark:bg-gray-800 rounded-2xl p-3 flex flex-col justify-between relative shadow-sm hover:shadow-md transition-all border border-gray-100 dark:border-gray-800 group/card no-underline h-[280px]">
                        
                        <div class="h-32 bg-gray-50 dark:bg-gray-700/50 rounded-xl flex items-center justify-center relative overflow-hidden group-hover/card:shadow-lg transition-all">
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
                                <img src="{{ $coverUrl }}" alt="{{ $doc->title }}" class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-500">
                            @else
                                <span class="material-symbols-outlined text-5xl text-gray-300 dark:text-gray-600 group-hover/card:scale-110 transition-transform duration-500">picture_as_pdf</span>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                        </div>
                        
                        <div class="flex flex-col gap-1.5 mt-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-md bg-green-50 dark:bg-green-900/30 text-[9px] font-bold text-green-600 dark:text-green-400 uppercase tracking-wide">
                                    {{ $doc->category->name ?? 'UMUM' }}
                                </span>
                            </div>
                            <div class="text-[13px] font-bold text-[#0d1b11] dark:text-white leading-snug line-clamp-2">
                                {{ $doc->title }}
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-5 h-5 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                                    <span class="text-[11px] text-gray-500 truncate max-w-[70px]">{{ $doc->user->name ?? 'Admin' }}</span>
                                </div>
                                <span class="text-[10px] text-gray-400">{{ $doc->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach

                </div>
            </section>

            <section class="w-full">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold tracking-tight text-[#0d1b11] dark:text-white">Kategori</h2>
                    {{-- Tombol Selengkapnya (Asumsi ada route kategori index, jika tidak arahkan ke documents index dengan filter) --}}
                    <a href="{{ route('documents.index') }}" class="text-xs font-semibold text-primary hover:text-[#006030] flex items-center gap-1 transition-colors">
                        Selengkapnya
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
                
                {{-- Grid 4 Kolom --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach($categories->take(4) as $category) {{-- Tampilkan hanya 4 --}}
                    <a href="{{ route('collections.index', ['category_id' => $category->id, 'mode' => 'all']) }}" class="group p-3 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 transition-all text-left h-40 flex flex-col">
                        <div class="w-9 h-9 rounded-xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center mb-2 group-hover:bg-primary group-hover:text-[#0d1b11] transition-colors text-gray-400">
                            <span class="material-symbols-outlined text-[20px]">folder</span> 
                        </div>
                        <h3 class="font-bold text-[13px] text-[#0d1b11] dark:text-white line-clamp-2 flex-1">{{ $category->name }}</h3>
                        <p class="text-[11px] text-gray-400 mt-auto">{{ $category->documents_count ?? 0 }} Dokumen</p>
                    </a>
                    @endforeach
                </div>
            </section>

        </div>

        <aside class="w-full xl:w-72 flex flex-col gap-6 shrink-0">
            <div class="bg-primary/10 rounded-3xl p-5 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
                <h3 class="font-bold text-base text-[#0d1b11] relative z-10">Total Arsip</h3>
                <p class="text-3xl font-bold text-primary mt-1 relative z-10">{{ $totalDocuments }}</p>
                <p class="text-xs text-gray-600 mt-1 relative z-10">+{{ $documents->where('created_at', '>=', now()->subWeek())->count() }} minggu ini</p>
            </div>

            <div>
                <h3 class="font-bold text-base text-[#0d1b11] dark:text-white mb-3">Aktivitas Terbaru</h3>
                <div class="relative pl-4 border-l-2 border-dashed border-gray-200 dark:border-gray-700 space-y-5">
                    @foreach($latestUploads as $upload)
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-primary border-4 border-white dark:border-gray-900"></div>
                        <p class="text-[11px] text-gray-400 mb-0.5">{{ $upload->created_at->diffForHumans() }}</p>
                        <p class="text-[13px] font-bold text-[#0d1b11] dark:text-white leading-tight">
                            {{ $upload->user->name ?? 'Seseorang' }} Mengupload <span class="text-primary">{{ Str::limit($upload->title, 18) }}</span>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</x-new-layout>