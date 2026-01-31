<x-new-layout title="Dashboard - RS PKU Digital Library">
    <x-slot:header>
        {{-- Header Responsif: Stack di HP, Baris di Desktop --}}
        <div class="w-full px-4 sm:px-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 py-4 md:py-0">
            
            {{-- Search Bar: Full width di semua layar kecil --}}
            <div class="w-full md:flex-1 max-w-2xl">
                <form action="{{ route('collections.index') }}" method="GET" class="relative group w-full">
                    <div class="flex items-center w-full gap-2">
                        <div class="relative flex-1 min-w-0"> {{-- min-w-0 Mencegah overflow --}}
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-gray-400 text-[20px]">search</span>
                            </div>
                            <input name="search" value="{{ request('search') }}" 
                                   class="block w-full pl-10 pr-3 py-2.5 bg-white border-none rounded-xl text-sm shadow-sm focus:ring-2 focus:ring-primary transition-all truncate" 
                                   placeholder="Cari dokumen..." type="text"/>
                        </div>
                        <button type="submit" class="shrink-0 inline-flex items-center px-4 py-2.5 bg-primary text-[#0d1b11] text-sm font-bold rounded-xl hover:scale-[1.02] active:scale-95 transition-all shadow-sm">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end w-full md:w-auto gap-3">
                <button class="w-10 h-10 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center text-gray-500 hover:text-primary transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                </button>
                
                @hasanyrole('admin|super-admin')
                <a href="{{ route('documents.create') }}" class="px-4 py-2.5 bg-primary text-[#0d1b11] text-xs font-bold rounded-xl flex items-center gap-2 shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all whitespace-nowrap">
                    <span class="material-symbols-outlined text-[18px]">upload_file</span>
                    Upload
                </a>
                @endhasanyrole
            </div>
        </div>
    </x-slot:header>
    
    {{-- LAYOUT UTAMA: Gunakan 'xl' (Extra Large) untuk split layout. --}}
    {{-- Di bawah 1280px (Tablet & Laptop Kecil), layout akan turun ke bawah (flex-col) agar tidak sempit --}}
    <div class="w-full px-4 sm:px-6 flex flex-col xl:flex-row gap-6 pb-8">
        
        <div class="flex-1 flex flex-col gap-8 min-w-0">
            
            <section class="w-full">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold tracking-tight text-[#0d1b11] dark:text-white">Rekomendasi Untukmu</h2>
                    <a href="{{ route('collections.index') }}" class="text-xs font-semibold text-primary hover:text-[#006030] flex items-center gap-1 transition-colors">
                        Selengkapnya
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>

                {{-- Grid Responsif: 1 kolom (HP), 2 (Tablet), 3 (Desktop) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($documents->take(3) as $doc)
                    <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="bg-white dark:bg-gray-800 rounded-2xl p-3 flex flex-col relative shadow-sm hover:shadow-md transition-all border border-gray-100 dark:border-gray-800 group/card no-underline h-auto min-h-[260px]">
                        
                        {{-- Cover Image Wrapper --}}
                        <div class="aspect-[16/9] sm:aspect-[4/3] w-full bg-gray-50 dark:bg-gray-700/50 rounded-xl flex items-center justify-center relative overflow-hidden group-hover/card:shadow-lg transition-all mb-3">
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
                        </div>
                        
                        {{-- Content --}}
                        <div class="flex flex-col gap-2 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <span class="px-2 py-0.5 rounded-md bg-green-50 dark:bg-green-900/30 text-[10px] font-bold text-green-600 dark:text-green-400 uppercase tracking-wide truncate max-w-[70%]">
                                    {{ $doc->category->name ?? 'UMUM' }}
                                </span>
                            </div>
                            
                            <h3 class="text-[13px] font-bold text-[#0d1b11] dark:text-white leading-snug line-clamp-2 mb-auto">
                                {{ $doc->title }}
                            </h3>
                            
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-gray-50 dark:border-gray-700/50">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <div class="w-5 h-5 rounded-full bg-gray-200 dark:bg-gray-700 shrink-0"></div>
                                    <span class="text-[11px] text-gray-500 truncate">{{ $doc->user->name ?? 'Admin' }}</span>
                                </div>
                                <span class="text-[10px] text-gray-400 shrink-0">{{ $doc->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>

            <section class="w-full">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base font-bold tracking-tight text-[#0d1b11] dark:text-white">Kategori</h2>
                    <a href="{{ route('collections.index') }}" class="text-xs font-semibold text-primary hover:text-[#006030] flex items-center gap-1 transition-colors">
                        Selengkapnya
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
                
                {{-- Grid Responsif Kategori --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($categories->take(4) as $category)
                    <a href="{{ route('collections.index', ['category_id' => $category->id, 'mode' => 'all']) }}" class="group p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-primary/50 hover:shadow-lg hover:shadow-primary/5 transition-all text-left flex flex-col gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center group-hover:bg-primary group-hover:text-[#0d1b11] transition-colors text-gray-400">
                            <span class="material-symbols-outlined text-[20px]">folder</span> 
                        </div>
                        <div>
                            <h3 class="font-bold text-[13px] text-[#0d1b11] dark:text-white line-clamp-2 leading-tight mb-1">{{ $category->name }}</h3>
                            <p class="text-[10px] text-gray-400">{{ $category->documents_count ?? 0 }} Dokumen</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
        </div>

        {{-- Diubah breakpoint ke XL. Jadi di Laptop biasa (1366px) sidebar ini akan ada di BAWAH, bukan di kanan. --}}
        {{-- Ini membuat konten utama sangat lega dan responsif. --}}
        <aside class="w-full xl:w-80 flex flex-col gap-6 shrink-0 mt-4 xl:mt-0">
            <div class="bg-primary/10 rounded-3xl p-6 relative overflow-hidden border border-primary/5">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-primary/20 rounded-full blur-3xl"></div>
                <h3 class="font-bold text-base text-[#0d1b11] relative z-10">Total Arsip</h3>
                <p class="text-4xl font-bold text-primary mt-2 relative z-10">{{ $totalDocuments }}</p>
                <div class="flex items-center gap-1 mt-2 text-xs text-gray-600 relative z-10">
                    <span class="material-symbols-outlined text-sm text-green-600">trending_up</span>
                    <span>+{{ $documents->where('created_at', '>=', now()->subWeek())->count() }} minggu ini</span>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800/50 rounded-3xl p-6 border border-gray-100 dark:border-gray-800">
                <h3 class="font-bold text-base text-[#0d1b11] dark:text-white mb-4">Aktivitas Terbaru</h3>
                <div class="relative pl-4 border-l-2 border-dashed border-gray-200 dark:border-gray-700 space-y-6">
                    @foreach($latestUploads as $upload)
                    <div class="relative group">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-gray-300 group-hover:bg-primary transition-colors border-4 border-white dark:border-gray-900"></div>
                        <p class="text-[10px] uppercase tracking-wider font-semibold text-gray-400 mb-1">{{ $upload->created_at->diffForHumans() }}</p>
                        <p class="text-[13px] text-gray-600 dark:text-gray-300 leading-snug">
                            <span class="font-bold text-slate-900 dark:text-white">{{ $upload->user->name ?? 'Seseorang' }}</span> 
                            mengunggah 
                            <a href="#" class="text-primary font-medium hover:underline block mt-0.5 truncate">{{ $upload->title }}</a>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </aside>
    </div>
</x-new-layout>