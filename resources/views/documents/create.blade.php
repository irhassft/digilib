<x-new-layout title="Upload Dokumen - RS PKU Digital Library">
    
    <x-slot:header>
        <div class="flex items-center gap-4">
             <a href="{{ route('dashboard') }}" class="w-10 h-10 rounded-full bg-white text-gray-500 flex items-center justify-center hover:bg-gray-100 hover:text-primary transition-all">
                 <span class="material-symbols-outlined">arrow_back</span>
             </a>
             <h2 class="text-xl font-bold text-[#0d1b11] dark:text-white">Upload Dokumen Digital</h2>
         </div>
    </x-slot:header>

    <div class="max-w-4xl mx-auto">
        <form id="uploadForm" action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8 flex flex-col gap-6">
                
                {{-- ERROR CONTAINER --}}
                <div id="errorContainer" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-300 px-4 py-3 rounded-xl text-sm">
                    <ul class="list-disc list-inside" id="errorList"></ul>
                </div>

                {{-- JUDUL & KATEGORI --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Judul Dokumen -->
                    <div class="col-span-2 md:col-span-1">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="title">Judul Dokumen</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" 
                            id="title" type="text" name="title" required placeholder="Contoh: SOP Pelayanan Pasien 2024" autofocus>
                    </div>

                    <!-- Kategori dengan Alpine JS Modal -->
                    <div class="col-span-2 md:col-span-1" x-data="{ showModal: false, newCategory: '' }">
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="category_id">Kategori</label>
                        <div class="flex gap-2">
                            <div class="relative flex-grow">
                                <select name="category_id" id="category_id" class="w-full px-4 py-3 rounded-l-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all cursor-pointer">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Tombol Tambah --}}
                            <button type="button" @click="showModal = true" class="bg-primary hover:bg-opacity-90 text-[#0d1b11] px-4 rounded-none border-l border-white/20 transition flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined">add</span>
                            </button>

                            {{-- Tombol Hapus --}}
                            <button type="button" class="bg-red-500 hover:bg-red-600 text-white px-4 rounded-r-xl transition flex items-center justify-center font-bold"
                                @click="
                                    const select = document.getElementById('category_id');
                                    const id = select.value;
                                    const name = select.options[select.selectedIndex]?.text;
                                    if(!id) { Swal.fire({icon: 'warning', title: 'Pilih Kategori', text: 'Pilih kategori dulu untuk dihapus.', confirmButtonColor: '#13ec49'}); return; }
                                    Swal.fire({
                                        title: 'Hapus Kategori?', text: `Yakin hapus '${name}'?`, icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#6b7280', confirmButtonText: 'Hapus', cancelButtonText: 'Batal'
                                    }).then((res) => {
                                        if(res.isConfirmed) {
                                            Swal.showLoading();
                                            fetch('/categories/' + id + '/ajax', { method: 'DELETE', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' } })
                                            .then(r => r.json()).then(d => {
                                                if(d.success) { select.remove(select.selectedIndex); select.value = ''; Swal.fire('Sukses', 'Kategori dihapus', 'success'); }
                                                else { Swal.fire('Gagal', d.message, 'error'); }
                                            });
                                        }
                                    })
                                ">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </div>

                        {{-- MODAL TAMBAH KATEGORI --}}
                        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 backdrop-blur-sm" x-transition.opacity>
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-2xl w-96 transform transition-all scale-100">
                                <h3 class="text-lg font-bold text-[#0d1b11] dark:text-white mb-4">Buat Kategori Baru</h3>
                                <input type="text" x-model="newCategory" placeholder="Nama Kategori..." class="w-full border-gray-200 dark:border-gray-700 rounded-xl mb-4 p-3 bg-gray-50 dark:bg-gray-900 focus:ring-primary focus:border-primary">
                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="showModal = false" class="px-4 py-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg font-bold">Batal</button>
                                    <button type="button" @click="if(!newCategory) return; fetch('{{ route('categories.ajax.store') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ name: newCategory }) }).then(r => r.json()).then(d => { if(d.success) { const s = document.getElementById('category_id'); s.add(new Option(d.category.name, d.category.id)); s.value = d.category.id; newCategory = ''; showModal = false; Swal.fire({icon: 'success', title: 'Berhasil', timer: 1500, showConfirmButton: false}); } else { Swal.fire('Gagal', 'Nama sudah ada', 'error'); } });" class="px-5 py-2 bg-primary text-[#0d1b11] font-bold rounded-lg hover:bg-opacity-90">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- DESKRIPSI --}}
                <div>
                    <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="description">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all"></textarea>
                </div>

                {{-- COVER IMAGE & YEAR --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cover Image -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="cover_image">Gambar Cover (Opsional)</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" 
                            id="cover_image" type="file" name="cover_image" accept="image/*" placeholder="Pilih gambar cover">
                    </div>

                    <!-- Tahun -->
                    <div>
                        <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300" for="year">Tahun Dokumen (Opsional)</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" 
                            id="year" type="number" name="year" min="1900" max="2100" placeholder="Contoh: 2024">
                    </div>
                </div>

                <div x-data="{ 
                    isDragging: false, 
                    fileName: '', 
                    fileSize: '',
                    handleDrop(e) {
                        e.preventDefault();
                        this.isDragging = false;
                        if (e.dataTransfer.files.length > 0) {
                            const file = e.dataTransfer.files[0];
                            if (file.type === 'application/pdf') { this.setFile(file); } 
                            else { Swal.fire({icon: 'error', title: 'Format Salah', text: 'Hanya file PDF yang diperbolehkan!'}); }
                        }
                    },
                    handleFileSelect(e) {
                        if (e.target.files.length > 0) { this.setFile(e.target.files[0]); }
                    },
                    setFile(file) {
                        this.$refs.fileInput.files = this.createFileList(file);
                        this.fileName = file.name;
                        this.fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                    },
                    createFileList(file) {
                        const dt = new DataTransfer(); dt.items.add(file); return dt.files;
                    }
                }">
                    <label class="block text-sm font-bold mb-2 text-gray-700 dark:text-gray-300">Upload File (PDF)</label>
                    
                    <div 
                        @dragover.prevent="isDragging = true"
                        @dragleave.prevent="isDragging = false"
                        @drop.prevent="handleDrop($event)"
                        @click="$refs.fileInput.click()"
                        :class="isDragging ? 'border-primary bg-green-50/50 scale-[1.01]' : 'border-dashed border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
                        class="mt-2 flex flex-col justify-center items-center py-12 px-6 border-2 rounded-2xl transition-all duration-200 cursor-pointer relative group bg-gray-50 dark:bg-gray-900/50"
                    >
                        <div x-show="!fileName" class="text-center">
                            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-3xl text-primary">cloud_upload</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 font-medium">Klik untuk upload atau drag file PDF</p>
                            <p class="text-xs text-gray-400 mt-2">Maksimal ukuran 100 MB</p>
                        </div>

                        <div x-show="fileName" style="display: none;" class="flex flex-col items-center">
                            <span class="material-symbols-outlined text-5xl text-red-500 mb-2">picture_as_pdf</span>
                            <p class="text-lg font-bold text-[#0d1b11] dark:text-white" x-text="fileName"></p>
                            <p class="text-sm text-gray-500" x-text="fileSize"></p>
                            <p class="text-xs text-primary mt-2 font-bold px-3 py-1 bg-primary/10 rounded-full">Siap Diupload</p>
                        </div>

                        <input x-ref="fileInput" @change="handleFileSelect($event)" id="document_file" name="document_file" type="file" class="sr-only" accept=".pdf" required>
                    </div>
                </div>

                {{-- PROGRESS BAR --}}
                <div id="progressContainer" class="hidden">
                    <div class="flex justify-between mb-2">
                        <span class="text-xs font-bold text-primary animate-pulse">Mengupload ke Server...</span>
                        <span class="text-xs font-bold text-primary" id="progressPercent">0%</span>
                    </div>
                    <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-3 overflow-hidden">
                        <div id="progressBar" class="bg-primary h-full rounded-full transition-all duration-300 shadow-[0_0_10px_rgba(19,236,73,0.5)]" style="width: 0%"></div>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="flex justify-end gap-4 mt-4 pt-6 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-gray-600 font-bold hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" id="submitBtn" class="px-8 py-3 rounded-xl bg-primary text-[#0d1b11] font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined">upload_file</span>
                        <span>Upload Dokumen</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <x-slot:scripts>
        <script>
            document.getElementById('uploadForm').addEventListener('submit', function(e) {
                e.preventDefault();
                let form = this;
                let formData = new FormData(form);
                let progressBar = document.getElementById('progressBar');
                let progressPercent = document.getElementById('progressPercent');
                let progressContainer = document.getElementById('progressContainer');
                let submitBtn = document.getElementById('submitBtn');
                let errorContainer = document.getElementById('errorContainer');
                let errorList = document.getElementById('errorList');

                errorContainer.classList.add('hidden');
                errorList.innerHTML = '';

                if(!document.getElementById('document_file').files.length) {
                    Swal.fire('Peringatan', 'Mohon pilih file PDF!', 'warning');
                    return;
                }

                progressContainer.classList.remove('hidden');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin mr-2">progress_activity</span> Sedang Mengupload...';
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

                let xhr = new XMLHttpRequest();
                xhr.open('POST', form.action, true);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        let percentComplete = Math.round((e.loaded / e.total) * 100);
                        progressBar.style.width = percentComplete + '%';
                        progressPercent.innerText = percentComplete + '%';
                        if(percentComplete === 100) {
                            submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin mr-2">dns</span> Menyimpan ke Nextcloud...';
                        }
                    }
                };

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            let response = JSON.parse(xhr.responseText);
                            if(response.success) {
                                Swal.fire({icon: 'success', title: 'Berhasil!', text: 'Dokumen berhasil diupload.', timer: 2000, showConfirmButton: false}).then(() => {
                                    window.location.href = "{{ route('dashboard') }}";
                                });
                            } else {
                                Swal.fire('Gagal', 'Terjadi kesalahan tidak diketahui.', 'error');
                                resetForm();
                            }
                        } catch(e) {
                            Swal.fire('Error', 'Respon server tidak valid.', 'error');
                            resetForm();
                        }
                    } else {
                        let msg = 'Upload Gagal.';
                        try {
                            let res = JSON.parse(xhr.responseText);
                            if(res.message) msg = res.message;
                            if(res.errors) {
                                errorContainer.classList.remove('hidden');
                                for(let key in res.errors) {
                                     let li = document.createElement('li');
                                     li.innerText = res.errors[key][0];
                                     errorList.appendChild(li);
                                }
                            }
                        } catch(e) {}
                        Swal.fire({icon: 'error', title: 'Gagal Upload', text: msg});
                        resetForm();
                    }
                };

                xhr.onerror = function() { Swal.fire('Error', 'Terjadi kesalahan jaringan.', 'error'); resetForm(); };
                xhr.send(formData);

                function resetForm() {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span class="material-symbols-outlined mr-2">upload_file</span> Upload Dokumen';
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    progressContainer.classList.add('hidden');
                    progressBar.style.width = '0%';
                    progressPercent.innerText = '0%';
                }
            });
        </script>
    </x-slot:scripts>
</x-new-layout>