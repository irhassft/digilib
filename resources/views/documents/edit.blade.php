<x-new-layout title="Edit Dokumen - RS PKU Digital Library">
    <x-slot:header>
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-8 h-full">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <span class="material-symbols-outlined text-3xl text-black">edit_document</span>
                    <h1 class="text-3xl font-bold text-black">Edit Dokumen</h1>
                </div>
                <p class="text-gray-650">{{ $document->title }}</p>
            </div>
        </div>
    </x-slot:header>

    <div class="max-w-5xl mx-auto px-4 py-8">
        <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Form Fields -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div class="bg-gradient-to-r from-primary/10 to-primary/5 dark:from-primary/5 dark:to-primary/10 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">info</span>
                                Informasi Dasar
                            </h2>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                    Judul Dokumen <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="title" 
                                    name="title" 
                                    value="{{ $document->title }}" 
                                    required 
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                    placeholder="Masukkan judul dokumen"
                                />
                                @error('title')
                                    <div class="mt-2 flex items-center gap-2 text-red-500 text-sm">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label for="category_id" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                        Kategori <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        name="category_id" 
                                        id="category_id"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all cursor-pointer"
                                    >
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $document->category_id == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="mt-2 flex items-center gap-2 text-red-500 text-sm">
                                            <span class="material-symbols-outlined text-sm">error</span>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Year -->
                                <div>
                                    <label for="year" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                        Tahun Publikasi
                                    </label>
                                    <input 
                                        type="number" 
                                        id="year" 
                                        name="year" 
                                        value="{{ $document->year }}" 
                                        min="1900" 
                                        max="2100"
                                        class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
                                        placeholder="2025"
                                    />
                                    @error('year')
                                        <div class="mt-2 flex items-center gap-2 text-red-500 text-sm">
                                            <span class="material-symbols-outlined text-sm">error</span>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-bold text-gray-900 dark:text-white mb-2">
                                    Deskripsi
                                </label>
                                <textarea 
                                    name="description" 
                                    id="description"
                                    rows="5" 
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all resize-none"
                                    placeholder="Masukkan deskripsi dokumen..."
                                >{{ $document->description }}</textarea>
                                @error('description')
                                    <div class="mt-2 flex items-center gap-2 text-red-500 text-sm">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- File Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-5 dark:from-blue-900/20 dark:to-blue-900/10 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">folder_open</span>
                                File Dokumen
                            </h2>
                        </div>
                        
                        <div class="p-6 space-y-6">
                            <!-- Current PDF -->
                            <div class="p-4 bg-gradient-to-br from-blue-50 to-blue-100/50 dark:from-blue-900/30 dark:to-blue-900/10 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="flex items-start gap-4">
                                    <div class="flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-lg flex-shrink-0">
                                        <span class="material-symbols-outlined">picture_as_pdf</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-blue-700 dark:text-blue-300 uppercase tracking-wider mb-1">File PDF Saat Ini</p>
                                        <a href="{{ route('documents.download', $document) }}" target="_blank" class="text-blue-700 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 font-semibold break-all transition-colors">
                                            {{ $document->title }}.pdf
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload New PDF -->
                            <div>
                                <label for="document_file" class="block text-sm font-bold text-gray-900 dark:text-white mb-3">
                                    Ganti File PDF
                                </label>
                                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center hover:border-primary dark:hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10 transition-all cursor-pointer group" onclick="document.getElementById('document_file').click()">
                                    <div class="flex flex-col items-center">
                                        <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-full group-hover:bg-primary/20 dark:group-hover:bg-primary/20 transition-colors mb-3">
                                            <span class="material-symbols-outlined text-4xl text-gray-400 dark:text-gray-500 group-hover:text-primary transition-colors">cloud_upload</span>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">Klik atau drag file ke sini</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Format: PDF (Maksimal 50MB)</p>
                                    </div>
                                </div>
                                <input 
                                    type="file" 
                                    id="document_file" 
                                    name="document_file" 
                                    accept=".pdf" 
                                    class="hidden"
                                />
                                @error('document_file')
                                    <div class="mt-2 flex items-center gap-2 text-red-500 text-sm">
                                        <span class="material-symbols-outlined text-sm">error</span>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Cover Image & Visibility -->
                <div class="space-y-6">
                    <!-- Cover Image -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div class="bg-gradient-to-r from-amber-50 to-amber-5 dark:from-amber-900/20 dark:to-amber-900/10 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="material-symbols-outlined text-amber-600 dark:text-amber-400">image</span>
                                Cover
                            </h2>
                        </div>
                        
                        <div class="p-4">
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-4 text-center hover:border-primary dark:hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10 transition-all cursor-pointer group mb-4" onclick="document.getElementById('cover_image').click()">
                                @php
                                    $cover = $document->cover_image;
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
                                    <img src="{{ $coverUrl }}" alt="Current cover" class="w-full h-40 object-cover rounded-lg mb-3">
                                @else
                                    <div class="p-6 bg-gray-100 dark:bg-gray-700 rounded-lg mb-3 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-5xl text-gray-300 dark:text-gray-600">image</span>
                                    </div>
                                @endif
                                
                                <p class="text-xs font-bold text-gray-700 dark:text-gray-300">Klik untuk mengganti</p>
                            </div>
                            <input 
                                type="file" 
                                id="cover_image" 
                                name="cover_image" 
                                accept="image/*" 
                                class="hidden"
                            />
                            @error('cover_image')
                                <div class="flex items-center gap-2 text-red-500 text-xs">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Visibility -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
                        <div class="bg-gradient-to-r from-purple-50 to-purple-5 dark:from-purple-900/20 dark:to-purple-900/10 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">shield</span>
                                Akses
                            </h2>
                        </div>
                        
                        <div class="p-4 space-y-3">
                            <!-- Public Option -->
                            <label class="block p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-green-400 dark:hover:border-green-400 hover:bg-green-50 dark:hover:bg-green-900/10 transition-all group">
                                <div class="flex items-start gap-3">
                                    <input 
                                        type="radio" 
                                        name="visibility" 
                                        value="public" 
                                        {{ $document->visibility === 'public' ? 'checked' : '' }}
                                        class="w-5 h-5 mt-0.5 accent-green-500"
                                    />
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                                            <span class="material-symbols-outlined text-green-500 text-base">public</span>
                                            Public
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Semua orang bisa melihat</p>
                                    </div>
                                </div>
                            </label>

                            <!-- Private Option -->
                            <label class="block p-4 border-2 border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:border-red-400 dark:hover:border-red-400 hover:bg-red-50 dark:hover:bg-red-900/10 transition-all group">
                                <div class="flex items-start gap-3">
                                    <input 
                                        type="radio" 
                                        name="visibility" 
                                        value="private" 
                                        {{ $document->visibility === 'private' ? 'checked' : '' }}
                                        class="w-5 h-5 mt-0.5 accent-red-500"
                                    />
                                    <div class="flex-1">
                                        <p class="font-bold text-gray-900 dark:text-white text-sm flex items-center gap-2">
                                            <span class="material-symbols-outlined text-red-500 text-base">lock</span>
                                            Private
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Hanya Anda & admin</p>
                                    </div>
                                </div>
                            </label>
                        </div>

                        @error('visibility')
                            <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700 flex items-center gap-2 text-red-500 text-sm">
                                <span class="material-symbols-outlined text-sm">error</span>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex gap-3">
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-primary hover:bg-primary/90 dark:hover:bg-primary/80 text-white dark:text-gray-900 font-bold rounded-lg transition-colors flex items-center gap-2 shadow-lg hover:shadow-xl"
                >
                    <span class="material-symbols-outlined">check_circle</span>
                    Simpan Perubahan
                </button>
                <a 
                    href="{{ route('collections.index') }}" 
                    class="px-8 py-3 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors flex items-center gap-2"
                >
                    <span class="material-symbols-outlined">close</span>
                    Batal
                </a>
            </div>
        </form>
    </div>

    <x-slot:scripts>
        <script>
            // Image preview
            document.getElementById('cover_image')?.addEventListener('change', function(e) {
                if (e.target.files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const container = e.target.parentElement.querySelector('[onclick*="cover_image"]');
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.className = 'w-full h-40 object-cover rounded-lg mb-3';
                        const existing = container.querySelector('img');
                        if (existing) {
                            existing.replaceWith(img);
                        } else {
                            const imageDiv = container.querySelector('[class*="bg-gray"]');
                            imageDiv?.replaceWith(img);
                        }
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            // Drag and drop for files
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                document.getElementById('document_file')?.parentElement?.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                document.getElementById('document_file')?.parentElement?.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                document.getElementById('document_file')?.parentElement?.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                this.classList.add('border-primary', 'bg-primary/5');
            }

            function unhighlight(e) {
                this.classList.remove('border-primary', 'bg-primary/5');
            }

            document.getElementById('document_file')?.parentElement?.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                document.getElementById('document_file').files = files;
            }
        </script>
    </x-slot:scripts>
</x-new-layout>