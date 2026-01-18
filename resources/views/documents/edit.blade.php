<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Dokumen: ') . $document->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- PENTING: Untuk method UPDATE --}}

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Judul Dokumen')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$document->title" required />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select name="category_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $document->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea name="description" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ $document->description }}</textarea>
                        </div>

                        <div class="mb-4">
                            <x-input-label :value="__('Visibilitas Dokumen')" />
                            <div class="mt-2 space-y-2">
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="visibility" value="public" {{ $document->visibility === 'public' ? 'checked' : '' }} required class="rounded-sm accent-primary">
                                    <span class="text-sm">🟢 Public - Dapat dilihat siapa saja</span>
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="radio" name="visibility" value="private" {{ $document->visibility === 'private' ? 'checked' : '' }} class="rounded-sm accent-primary">
                                    <span class="text-sm">🔒 Private - Hanya Anda dan admin</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="cover_image" :value="__('Gambar Cover')" />
                                <input type="file" name="cover_image" accept="image/*" class="block w-full text-sm text-gray-500 mt-1 border-gray-300 rounded-md" />
                                @if($document->cover_image)
                                    <p class="text-sm text-gray-600 mt-2">File saat ini: {{ basename($document->cover_image) }}</p>
                                @endif
                            </div>
                            <div>
                                <x-input-label for="year" :value="__('Tahun')" />
                                <input type="number" name="year" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" min="1900" max="2100" value="{{ $document->year }}" />
                            </div>
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 border rounded-md">
                            <p class="text-sm text-gray-600 mb-2">File saat ini: 
                                <a href="{{ route('documents.download', $document) }}" class="text-blue-600 underline" target="_blank">{{ $document->title }}.pdf</a>
                            </p>
                            <x-input-label for="document_file" :value="__('Ganti File PDF (Kosongkan jika tidak ingin mengganti)')" />
                            <input type="file" name="document_file" accept=".pdf" class="block w-full text-sm text-gray-500 mt-1" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Perubahan') }}</x-primary-button>
                            <a href="{{ route('dashboard') }}" class="text-gray-600">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>