<x-app-layout>
    {{-- TAMBAHAN: Load SweetAlert2 --}}
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Upload Dokumen Baru') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-md sm:rounded-xl border-t-4 border-green-600">
                <div class="p-8 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-5">
                            <x-input-label for="title" :value="__('Judul Dokumen')" />
                            <x-text-input id="title" class="block mt-1 w-full p-3" type="text" name="title" :value="old('title')" required autofocus placeholder="Masukkan judul dokumen" />
                        </div>

                        <div class="mb-6" x-data="{ showModal: false, newCategory: '' }">
                            <x-input-label for="category_id" :value="__('Kategori Dokumen')" class="mb-1" />
                            
                            <div class="flex gap-2">
                                <div class="relative flex-grow">
                                    <select name="category_id" id="category_id" class="block w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-l-md rounded-r-none shadow-sm cursor-pointer bg-white text-gray-900 py-2.5">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                {{-- Tombol Tambah --}}
                                <button type="button" @click="showModal = true" title="Tambah Kategori" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-none border-l border-green-700 transition flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                                </button>

                                {{-- Tombol Hapus (DENGAN SWEETALERT) --}}
                                <button type="button" title="Hapus Kategori" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-r-md transition flex items-center justify-center"
                                        @click="
                                            const select = document.getElementById('category_id');
                                            const id = select.value;
                                            const name = select.options[select.selectedIndex]?.text;

                                            // 1. Cek jika belum pilih kategori
                                            if(!id) {
                                                Swal.fire({
                                                    icon: 'warning',
                                                    title: 'Pilih Kategori',
                                                    text: 'Silakan pilih kategori yang ingin dihapus terlebih dahulu.',
                                                    confirmButtonColor: '#16a34a'
                                                });
                                                return;
                                            }

                                            // 2. Konfirmasi Hapus Modern
                                            Swal.fire({
                                                title: 'Hapus Kategori?',
                                                text: `Anda yakin ingin menghapus kategori '${name}'?`,
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#ef4444',
                                                cancelButtonColor: '#6b7280',
                                                confirmButtonText: 'Ya, Hapus!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Tampilkan loading saat proses
                                                    Swal.fire({title: 'Memproses...', didOpen: () => Swal.showLoading()});

                                                    fetch('/categories/' + id + '/ajax', { 
                                                        method: 'DELETE', 
                                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' } 
                                                    })
                                                    .then(res => res.json())
                                                    .then(data => {
                                                        if(data.success) {
                                                            select.remove(select.selectedIndex);
                                                            select.value = '';
                                                            // Pesan Sukses
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Terhapus!',
                                                                text: 'Kategori berhasil dihapus.',
                                                                timer: 2000,
                                                                showConfirmButton: false
                                                            });
                                                        } else {
                                                            // Pesan Gagal (Misal dipakai dokumen lain)
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'Gagal',
                                                                text: data.message
                                                            });
                                                        }
                                                    })
                                                    .catch(err => {
                                                        Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                                                    });
                                                }
                                            })
                                        ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                </button>
                            </div>

                            <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm" x-transition.opacity>
                                <div class="bg-white p-6 rounded-xl shadow-2xl w-96">
                                    <h3 class="text-lg font-bold text-gray-800 mb-4">Tambah Kategori</h3>
                                    <input type="text" x-model="newCategory" placeholder="Nama Kategori..." class="w-full border-gray-300 rounded-lg mb-4 p-3 focus:ring-green-500 focus:border-green-500 text-gray-900">
                                    <div class="flex justify-end gap-2">
                                        <button type="button" @click="showModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                                        <button type="button" @click="if(!newCategory) return; fetch('{{ route('categories.ajax.store') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ name: newCategory }) }).then(r => r.json()).then(d => { if(d.success) { const s = document.getElementById('category_id'); s.add(new Option(d.category.name, d.category.id)); s.value = d.category.id; newCategory = ''; showModal = false; Swal.fire({icon: 'success', title: 'Berhasil', text: 'Kategori ditambahkan', timer: 1500, showConfirmButton: false}); } else { Swal.fire('Gagal', 'Mungkin nama sudah ada.', 'error'); } });" class="px-5 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <x-input-label for="description" :value="__('Deskripsi Singkat')" />
                            <textarea name="description" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500 bg-white text-gray-900">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-8" x-data="{ 
                            isDragging: false, 
                            fileName: '', 
                            handleDrop(e) {
                                e.preventDefault();
                                this.isDragging = false;
                                if (e.dataTransfer.files.length > 0) {
                                    const file = e.dataTransfer.files[0];
                                    if (file.type === 'application/pdf') {
                                        this.$refs.fileInput.files = e.dataTransfer.files;
                                        this.fileName = file.name;
                                    } else {
                                        // Ganti alert bawaan dengan SweetAlert
                                        Swal.fire({icon: 'error', title: 'Format Salah', text: 'Hanya file PDF yang diperbolehkan!'});
                                    }
                                }
                            },
                            handleFileSelect(e) {
                                if (e.target.files.length > 0) {
                                    this.fileName = e.target.files[0].name;
                                }
                            }
                        }">
                            <x-input-label for="document_file" :value="__('File PDF')" class="mb-2" />
                            
                            {{-- Area Drag & Drop --}}
                            <div 
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="handleDrop($event)"
                                @click="$refs.fileInput.click()"
                                :class="isDragging ? 'border-green-500 bg-green-50 scale-[1.01]' : 'border-gray-300 bg-white hover:bg-gray-50'"
                                class="mt-2 flex justify-center px-6 pt-10 pb-10 border-2 border-dashed rounded-xl transition-all duration-200 cursor-pointer relative group"
                            >
                                <div class="space-y-2 text-center">
                                    <div x-show="!fileName">
                                        <div class="mx-auto h-12 w-12 text-gray-400 group-hover:text-green-500 transition-colors">
                                            <svg stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <div class="flex text-sm text-gray-600 justify-center mt-2">
                                            <span class="font-bold text-green-600 hover:text-green-500">
                                                Klik untuk upload
                                            </span>
                                            <p class="pl-1 text-gray-500">atau drag file PDF ke sini</p>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">Maksimal ukuran 10MB</p>
                                    </div>

                                    <div x-show="fileName" style="display: none;" class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-500 mb-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-sm font-bold text-gray-900" x-text="fileName"></p>
                                        <p class="text-xs text-green-600 mt-1 font-semibold">Siap diupload (Klik lagi untuk ganti)</p>
                                    </div>

                                    <input x-ref="fileInput" @change="handleFileSelect($event)" id="document_file" name="document_file" type="file" class="sr-only" accept=".pdf" required>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">Batal</a>
                            <x-primary-button class="bg-green-600 hover:bg-green-700 active:bg-green-800">
                                {{ __('Upload Dokumen') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>