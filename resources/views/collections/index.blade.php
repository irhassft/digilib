<x-new-layout title="Koleksi Saya - RS PKU Digital Library">
    <x-slot:header>
        <div class="max-w-6xl mx-auto flex items-center justify-between gap-8 h-full">
            <div class="flex-1 max-w-2xl">
                <h1 class="text-lg font-bold">Koleksi Saya</h1>
                <p class="text-sm text-gray-500 mt-1">Semua dokumen yang Anda unggah. Gunakan filter kategori untuk menyesuaikan tampilan.</p>
            </div>
        </div>
    </x-slot:header>

    <div class="max-w-6xl mx-auto flex gap-8">
        <div class="flex-1 flex flex-col gap-6 min-w-0">
            <!-- Mode toggle & Categories Filter -->
            <section>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('collections.index', array_merge(request()->except('page'), ['mode' => 'mine'])) }}" class="px-3 py-1 rounded-full border {{ ($mode ?? 'mine') === 'mine' ? 'bg-primary text-[#0d1b11]' : 'bg-white text-gray-600' }}">My Uploads</a>
                        <a href="{{ route('collections.index', array_merge(request()->except('page'), ['mode' => 'all'])) }}" class="px-3 py-1 rounded-full border {{ ($mode ?? 'mine') === 'all' ? 'bg-primary text-[#0d1b11]' : 'bg-white text-gray-600' }}">All Documents</a>
                        <a href="{{ route('collections.index', array_merge(request()->except('page'), ['mode' => 'favorites'])) }}" class="px-3 py-1 rounded-full border {{ ($mode ?? 'mine') === 'favorites' ? 'bg-primary text-[#0d1b11]' : 'bg-white text-gray-600' }}">Favorites</a>
                    </div>
                </div>

                <div class="flex gap-2 flex-wrap">
                    @foreach($categories as $cat)
                        <a href="{{ route('collections.index', array_merge(request()->except('page'), ['category_id' => $cat->id])) }}" class="px-3 py-1 rounded-full border {{ request('category_id') == $cat->id ? 'bg-primary text-[#0d1b11]' : 'bg-white text-gray-600' }}">
                            {{ $cat->name }} <span class="text-xs text-gray-400">({{ $cat->documents_count }})</span>
                        </a>
                    @endforeach
                </div>
            </section>

            <!-- Documents List -->
            <section>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($documents as $doc)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 shadow-sm border border-gray-100 relative">
                        <div class="absolute right-4 top-4 z-20">
                            @php $isFav = $doc->isFavoritedBy(auth()->user()); @endphp
                            <button class="favorite-btn w-9 h-9 rounded-lg bg-white flex items-center justify-center shadow-sm" data-id="{{ $doc->id }}" aria-pressed="{{ $isFav ? 'true' : 'false' }}">
                                <span class="material-symbols-outlined text-sm {{ $isFav ? 'text-primary' : 'text-gray-400' }}">{{ $isFav ? 'bookmark' : 'bookmark_border' }}</span>
                            </button>
                        </div>

                        <div class="h-40 rounded-lg overflow-hidden mb-3 bg-gray-50 flex items-center justify-center">
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
                                <img src="{{ $coverUrl }}" alt="{{ $doc->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-6xl text-gray-300">picture_as_pdf</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-sm mb-1">{{ $doc->title }}</h3>
                        <p class="text-xs text-gray-500">{{ $doc->category->name ?? 'Uncategorized' }} • {{ $doc->created_at->format('d M Y') }}</p>
                        <div class="mt-3 flex items-center justify-between">
                            <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="text-sm text-primary font-semibold">Preview</a>
                            <form action="{{ route('documents.download', $doc->id) }}" method="GET" target="_blank">
                                <button class="text-sm px-3 py-1 bg-gray-100 rounded-lg">Download</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-gray-500 bg-white rounded-2xl">
                        Anda belum mengunggah dokumen apapun.
                    </div>
                    @endforelse
                </div>

                <div class="mt-6">
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