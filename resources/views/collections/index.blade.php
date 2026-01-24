<x-new-layout title="Daftar Dokumen - RS PKU Digital Library">
    <x-slot:header>
        <div class="max-w-6xl mx-auto flex items-center justify-between gap-8 h-full">
            <div class="flex-1 max-w-2xl">
                <h1 class="text-lg font-bold">Daftar Dokumen</h1>
                <p class="text-sm text-gray-500 mt-1">Semua dokumen yang Anda unggah. Gunakan filter kategori untuk menyesuaikan tampilan.</p>
            </div>
        </div>
    </x-slot:header>

    <div class="max-w-6xl mx-auto flex gap-8">
        <div class="flex-1 flex flex-col gap-6 min-w-0">
            <!-- Mode toggle & Categories Filter -->
            <section class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <!-- Search & Mode Toggle Row -->
                <div class="flex items-center justify-between mb-6 gap-4">
                    <!-- Mode Toggle Tabs -->
                    <div class="flex items-center gap-4">
                        @hasanyrole('admin|super-admin')
                        <a href="{{ route('collections.index', array_merge(request()->except('page'), ['mode' => 'mine'])) }}" class="px-4 py-2 rounded-full font-medium text-sm transition-all {{ ($mode ?? 'mine') === 'mine' ? 'bg-primary text-[#0d1b11]' : 'text-gray-600 dark:text-gray-400 hover:text-primary' }}">
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">upload_file</span>
                                My Uploads
                            </span>
                        </a>
                        @endhasanyrole
                        <a href="{{ route('collections.index', array_merge(request()->except('page'), ['mode' => 'all'])) }}" class="px-4 py-2 rounded-full font-medium text-sm transition-all {{ ($mode ?? 'mine') === 'all' ? 'bg-primary text-[#0d1b11]' : 'text-gray-600 dark:text-gray-400 hover:text-primary' }}">
                            All Documents
                        </a>
                        <a href="{{ route('collections.index', array_merge(request()->except('page'), ['mode' => 'favorites'])) }}" class="px-4 py-2 rounded-full font-medium text-sm transition-all flex items-center gap-2 {{ ($mode ?? 'mine') === 'favorites' ? 'bg-primary text-[#0d1b11]' : 'text-gray-600 dark:text-gray-400 hover:text-primary' }}">
                            <span class="material-symbols-outlined text-sm">bookmark</span>
                            Favorites
                        </a>
                    </div>

                    <!-- Search Form -->
                    <form action="{{ route('collections.index') }}" method="GET" class="flex-shrink-0 max-w-xs">
                        <!-- Keep other parameters -->
                        <input type="hidden" name="mode" value="{{ $mode ?? 'mine' }}">
                        @if(request('category_id'))
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif

                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-outlined text-sm text-gray-400">search</span>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="block w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all" 
                                   placeholder="Cari koleksi..."/>
                            @if(request('search'))
                            <a href="{{ route('collections.index', request()->except('search', 'page')) }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-bold text-[#0d1b11] dark:text-white mb-3">Filter Kategori</label>
                    <div class="flex gap-2 flex-wrap">
                        @foreach($categories as $cat)
                            @php
                                $isActive = request('category_id') == $cat->id;
                                $params = request()->except('page');
                                if ($isActive) {
                                    unset($params['category_id']);
                                } else {
                                    $params['category_id'] = $cat->id;
                                }
                                $url = route('collections.index', $params);
                            @endphp
                            <a href="{{ $url }}" class="px-4 py-2 rounded-xl border font-medium text-sm transition-all flex items-center gap-2 {{ $isActive ? 'bg-primary text-[#0d1b11] border-primary shadow-sm' : 'bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-600 hover:border-primary hover:text-primary' }}">
                                <span class="material-symbols-outlined text-sm">folder</span>
                                {{ $cat->name }} 
                                <span class="text-xs opacity-75">({{ $cat->documents_count }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Documents List -->
            <section>
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-[#0d1b11] dark:text-white">Dokumen</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $documents->total() }} dokumen ditemukan</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @forelse($documents as $doc)
                    <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all no-underline group">
                        <!-- Document Cover -->
                        <div class="relative h-48 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center overflow-hidden">
                            @php
                                $cover = $doc->cover_image;
                                $coverUrl = null;
                                $publicPath = $cover ? public_path('storage/'.$cover) : null;
                                if ($cover) {
                                    if ($publicPath && file_exists($publicPath)) {
                                        $coverUrl = asset('storage/'.$cover);
                                    } elseif (Storage::disk('public')->exists($cover)) {
                                        $coverUrl = Storage::disk('public')->url($cover);
                                    }
                                }
                            @endphp

                            @if($coverUrl)
                                <img src="{{ $coverUrl }}" alt="{{ $doc->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <span class="material-symbols-outlined text-8xl text-gray-200 dark:text-gray-600">picture_as_pdf</span>
                            @endif

                            <!-- Overlay on hover -->
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>

                            <!-- Top Right Badges -->
                            <div class="absolute right-3 top-3 flex flex-col gap-2" @click.prevent.stop>
                                {{-- Visibility Badge --}}
                                @if($doc->isPublic())
                                    <span class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-lg flex items-center gap-1 shadow-lg">
                                        <span class="material-symbols-outlined text-sm">public</span> Public
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-lg flex items-center gap-1 shadow-lg">
                                        <span class="material-symbols-outlined text-sm">lock</span> Private
                                    </span>
                                @endif

                                {{-- Favorite Button --}}
                                @php $isFav = $doc->isFavoritedBy(auth()->user()); @endphp
                                <button class="favorite-btn w-10 h-10 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center shadow-lg hover:scale-110 transition-transform" data-id="{{ $doc->id }}" aria-pressed="{{ $isFav ? 'true' : 'false' }}">
                                    <span class="material-symbols-outlined text-lg {{ $isFav ? 'text-primary' : 'text-gray-400' }}">{{ $isFav ? 'bookmark' : 'bookmark_border' }}</span>
                                </button>
                            </div>
                        </div>

                        <!-- Document Info -->
                        <div class="p-4 flex flex-col gap-3">
                            <!-- Category Badge -->
                            <div>
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-lg">
                                    <span class="material-symbols-outlined text-sm">folder</span>
                                    {{ $doc->category->name ?? 'Uncategorized' }}
                                </span>
                            </div>

                            <!-- Title -->
                            <div>
                                <h3 class="font-bold text-sm mb-2 text-[#0d1b11] dark:text-white group-hover:text-primary transition-colors line-clamp-2">{{ $doc->title }}</h3>
                            </div>

                            <!-- Meta Info -->
                            <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400 border-t border-gray-100 dark:border-gray-700 pt-3">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">event</span>
                                    {{ $doc->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="md:col-span-2 lg:col-span-3 p-12 text-center bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
                        <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 block mb-4">folder_open</span>
                        <p class="text-lg font-bold text-gray-600 dark:text-gray-400 mb-1">Tidak ada dokumen</p>
                        <p class="text-sm text-gray-500 dark:text-gray-500">Anda belum mengunggah dokumen apapun atau tidak ada dokumen yang sesuai dengan filter.</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-8">
                    {{ $documents->links() }}
                </div>
            </section>
        </div>

    </div>

    <x-slot:scripts>
        <script>
            document.addEventListener('click', async function (e) {
                const btn = e.target.closest('.favorite-btn');
                if (!btn) return;

                const docId = btn.dataset.id;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                try {
                    btn.disabled = true;
                    const res = await fetch("{{ url('/documents') }}/" + docId + '/favorite', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    });

                    const data = await res.json();
                    if (data.success) {
                        const icon = btn.querySelector('.material-symbols-outlined');
                        if (data.favorited) {
                            icon.textContent = 'bookmark';
                            icon.classList.remove('text-gray-400');
                            icon.classList.add('text-primary');
                            btn.setAttribute('aria-pressed', 'true');
                        } else {
                            icon.textContent = 'bookmark_border';
                            icon.classList.remove('text-primary');
                            icon.classList.add('text-gray-400');
                            btn.setAttribute('aria-pressed', 'false');
                        }
                    } else {
                        console.warn('Failed to toggle favorite', data);
                    }
                } catch (err) {
                    console.error(err);
                } finally {
                    btn.disabled = false;
                }
            });
        </script>
    </x-slot:scripts>
</x-new-layout>