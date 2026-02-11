<x-new-layout title="Daftar Dokumen - RS PKU Digital Library">
    <x-slot:header>
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-8 h-full">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-black">Daftar Dokumen</h1>
                <p class="text-sm text-gray-650 mt-2">Kelola dan jelajahi semua dokumen Anda</p>
            </div>
        </div>
    </x-slot:header>

    <div class="max-w-7xl mx-auto px-4">
        <!-- Filter Section -->
        <div class="mb-4 sm:mb-8">
            <section class="bg-white dark:bg-gray-800 rounded-xl p-4 sm:p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                <!-- Search & Filters Row -->
                <div class="flex flex-col gap-3">
                    <!-- Top Row: Mode Toggle & Search -->
                    <div class="flex items-center justify-between gap-2 flex-wrap">
                        <!-- Mode Toggle Tabs -->
                        <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                            @hasanyrole('admin|super-admin')
                            <a href="{{ route('collections.index', array_merge(request()->except('page'), ['mode' => 'mine'])) }}" class="px-4 py-2 rounded-md font-medium text-sm transition-all {{ ($mode ?? 'mine') === 'mine' ? 'bg-white dark:bg-gray-800 shadow-sm text-primary' : 'text-gray-600 dark:text-gray-400' }}">
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">upload_file</span>
                                    <span class="hidden sm:inline">My Uploads</span>
                                </span>
                            </a>
                            @endhasanyrole
                            <a href="{{ route('collections.index', array_merge(request()->except('page'), ['mode' => 'all'])) }}" class="px-4 py-2 rounded-md font-medium text-sm transition-all {{ ($mode ?? 'mine') === 'all' ? 'bg-white dark:bg-gray-800 shadow-sm text-primary' : 'text-gray-600 dark:text-gray-400' }}">
                                <span class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">public</span>
                                    <span class="hidden sm:inline">All Documents</span>
                                </span>
                            </a>
                        </div>

                        <!-- Search Form -->
                        <form action="{{ route('collections.index') }}" method="GET" class="flex-1 min-w-xs max-w-sm">
                            <input type="hidden" name="mode" value="{{ $mode ?? 'mine' }}">
                            @if(request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                            @endif

                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-outlined text-sm text-gray-400">search</span>
                                </span>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                        class="block w-full pl-10 pr-20 py-2 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" 
                                        placeholder="Cari dokumen..."/>

                                <!-- Search button -->
                                <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center text-white bg-primary hover:bg-primary/90 px-3 py-1 rounded-md">
                                    <span class="material-symbols-outlined text-sm">search</span>
                                </button>

                                @if(request('search'))
                                <a href="{{ route('collections.index', request()->except('search', 'page')) }}" class="absolute inset-y-0 right-10 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Bottom Row: Category Filter -->
                    <div class="border-t border-gray-100 dark:border-gray-700 pt-3">
                        <form action="{{ route('collections.index') }}" method="GET" class="flex items-center gap-2 flex-wrap">
                            <input type="hidden" name="mode" value="{{ $mode ?? 'mine' }}">
                            @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif

                            <label for="category_filter" class="text-sm font-semibold text-gray-700 dark:text-gray-300 whitespace-nowrap">Kategori:</label>
                            <select name="category_id" id="category_filter" onchange="this.form.submit()" class="min-w-[220px] px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent cursor-pointer hover:border-gray-300 dark:hover:border-gray-500 transition-colors">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Visibilitas Filter (Bahasa Indonesia) -->
                            <label for="visibility_filter" class="text-sm font-semibold text-gray-700 dark:text-gray-300 whitespace-nowrap">Visibilitas:</label>
                            <select name="visibility" id="visibility_filter" onchange="this.form.submit()" class="min-w-[160px] px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-sm text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent cursor-pointer hover:border-gray-300 dark:hover:border-gray-500 transition-colors">
                                <option value="all" {{ request('visibility') == 'all' ? 'selected' : (request()->has('visibility') ? '' : 'selected') }}>Semua Visibilitas</option>
                                <option value="public" {{ request('visibility') == 'public' ? 'selected' : '' }}>Publik</option>
                                <option value="private" {{ request('visibility') == 'private' ? 'selected' : '' }}>Privat</option>
                            </select>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        <!-- Documents Grid -->
        <div>
            <!-- Header -->
            <div class="mb-6">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-2xl text-primary">description</span>
                    <div>
                        <h2 class="text-2xl font-bold text-[#0d1b11] dark:text-white">Dokumen</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $documents->total() }} dokumen ditemukan</p>
                    </div>
                </div>
            </div>

            <!-- Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($documents as $doc)
                <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-all duration-300 group flex flex-col">
                    <!-- Document Cover -->
                    <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="relative h-28 sm:h-40 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center overflow-hidden no-underline block">
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
                            <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600">picture_as_pdf</span>
                        @endif

                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors"></div>

                        <!-- Visibility Badge -->
                        <div class="absolute top-3 right-3" @click.prevent.stop>
                            @if($doc->isPublic())
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">
                                    <span class="material-symbols-outlined text-xs">public</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-lg">
                                    <span class="material-symbols-outlined text-xs">lock</span>
                                </span>
                            @endif
                        </div>
                    </a>

                    <!-- Content -->
                    <div class="p-3 sm:p-4 flex-1 flex flex-col gap-2">
                        <!-- Category Badge -->
                        <div>
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary/15 text-primary dark:bg-primary/10 text-xs font-semibold rounded-full">
                                {{ $doc->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <!-- Title -->
                            <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="flex-1 no-underline">
                            <h3 class="font-bold text-xs sm:text-sm text-[#0d1b11] dark:text-white group-hover:text-primary transition-colors line-clamp-2">{{ $doc->title }}</h3>
                        </a>

                        <!-- Footer -->
                        <div class="border-t border-gray-100 dark:border-gray-700 pt-2">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs">calendar_today</span>
                                    {{ $doc->created_at->format('d M Y') }}
                                </span>

                                <!-- Action Icons -->
                                <div class="flex items-center gap-1" @click.stop>
                                    @can('update', $doc)
                                    <a href="{{ route('documents.edit', $doc->id) }}" class="p-2 text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" title="Edit dokumen">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </a>
                                    @endcan

                                    @can('delete', $doc)
                                    <button type="button" onclick="event.stopPropagation(); openDeleteModal('{{ $doc->id }}', '{{ addslashes($doc->title) }}')" class="p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" title="Hapus dokumen">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full p-16 text-center bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700">
                    <span class="material-symbols-outlined text-7xl text-gray-300 dark:text-gray-600 block mb-4 mx-auto">folder_open</span>
                    <p class="text-xl font-bold text-gray-600 dark:text-gray-400 mb-2">Tidak ada dokumen</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500">Anda belum mengunggah dokumen apapun atau tidak ada dokumen yang sesuai dengan filter.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $documents->links() }}
            </div>
        </div>
    </div>

    <x-slot:scripts>
        <script>
            // Delete Modal Management
            let deleteDocId = null;

            function openDeleteModal(docId, docTitle) {
                deleteDocId = docId;
                const modal = document.getElementById('deleteModal');
                const docTitleEl = document.getElementById('deleteDocTitle');
                docTitleEl.textContent = docTitle;
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.classList.remove('active');
                deleteDocId = null;
                document.body.style.overflow = '';
            }

            function confirmDelete() {
                if (deleteDocId) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/documents/${deleteDocId}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                    closeDeleteModal();
                }
            }

            // Close modal on outside click
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('deleteModal');
                if (modal) {
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            closeDeleteModal();
                        }
                    });
                }
            });

            // Close modal on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeDeleteModal();
                }
            });
        </script>
        <style>
            .delete-modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 50;
                opacity: 0;
                transition: opacity 0.3s ease;
                align-items: center;
                justify-content: center;
            }

            .delete-modal.active {
                display: flex;
                opacity: 1;
            }

            .delete-modal-content {
                background: white;
                border-radius: 10px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
                padding: 0;
                max-width: 350px;
                width: 90%;
                animation: slideUp 0.3s ease;
            }

            .delete-modal-content.dark {
                background: #1f2937;
            }

            @keyframes slideUp {
                from {
                    transform: scale(0.95);
                    opacity: 0;
                }
                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }
        </style>
    </x-slot:scripts>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="delete-modal">
        <div class="delete-modal-content bg-white dark:bg-gray-800">
            <!-- Header -->
            <div class="p-6 pb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Hapus Dokumen?</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Anda akan menghapus dokumen: <span class="font-semibold text-gray-900 dark:text-white" id="deleteDocTitle"></span>
                </p>
            </div>

            <!-- Footer -->
            <div class="flex gap-2 p-4 border-t border-gray-200 dark:border-gray-700">
                <button onclick="closeDeleteModal()" class="flex-1 px-3 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors text-sm">
                    Batal
                </button>
                <button onclick="confirmDelete()" class="flex-1 px-3 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors text-sm">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</x-new-layout>