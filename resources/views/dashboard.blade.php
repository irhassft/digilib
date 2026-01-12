<x-app-layout>
    <div class="min-h-screen bg-white">
        {{-- ========================================== --}}
        {{-- MODE KARYAWAN (TAMPILAN SEARCH ENGINE)     --}}
        {{-- ========================================== --}}
        @unlessrole('admin|super-admin')
        <div class="flex flex-col items-center justify-center min-h-[80vh] px-4 sm:px-6 lg:px-8">
            
            {{-- 1. Logo & Judul Center --}}
            <div class="text-center mb-10 animate-fade-in-down">
                {{-- Logo RSPKU --}}
                <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RSPKU" class="h-36 mx-auto mb-6 object-contain drop-shadow-md hover:scale-105 transition-transform duration-300">
                
                {{-- Teks Judul dengan Font Serif Modern / Sans Profesional --}}
                <h1 class="text-3xl md:text-5xl font-extrabold text-green-700 tracking-tight mb-2">
                    DIGITAL LIBRARY
                </h1>
                <p class="text-xl md:text-2xl text-gray-500 font-medium tracking-wide">
                    RS PKU AISYIYAH BOYOLALI
                </p>
                <div class="w-24 h-1 bg-green-500 mx-auto mt-4 rounded-full"></div>
            </div>

            {{-- 2. Form Pencarian Besar & Elegan --}}
            <div class="w-full max-w-4xl">
                <form method="GET" action="{{ route('dashboard') }}" class="relative group">
                    <div class="relative transition-all duration-300 transform group-hover:-translate-y-1">
                        <div class="absolute inset-y-0 left-0 pl-8 flex items-center pointer-events-none">
                            <svg class="h-7 w-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="block w-full pl-20 pr-6 py-5 border-2 border-gray-100 rounded-full leading-5 bg-white text-gray-700 placeholder-gray-400 focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-100 transition duration-200 ease-in-out text-lg shadow-lg"
                            placeholder="Ketik kata kunci dokumen yang ingin anda cari" autofocus>
                        
                        {{-- Tombol Cari di dalam Input (Kanan) --}}
                        <div class="absolute inset-y-2 right-2">
                            <button type="submit" class="h-full px-8 bg-green-600 hover:bg-green-700 text-white font-bold rounded-full shadow-md transition-all flex items-center gap-2">
                                Cari
                            </button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
        @endunlessrole

        {{-- ========================================== --}}
        {{-- MODE ADMIN (DASHBOARD MANAJEMEN)        --}}
        {{-- ========================================== --}}
        @hasanyrole('admin|super-admin')
        <div class="pt-8 pb-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                {{-- Header Admin --}}
                <div class="mb-8 flex flex-col md:flex-row justify-between items-end border-b border-gray-200 pb-4 gap-4">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Dashboard Pengelola</h2>
                        <p class="text-sm text-gray-500 mt-1">Pantau statistik dan kelola dokumen rumah sakit.</p>
                    </div>
                </div>

                {{-- STATISTIK KOTAK (HANYA ADMIN) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    {{-- Card 1 --}}
                    <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow rounded-xl border border-gray-100 p-6 relative">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-20 h-20 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"/></svg>
                        </div>
                        <div class="text-green-600 text-xs font-bold uppercase tracking-widest mb-1">Total Dokumen</div>
                        <div class="text-4xl font-extrabold text-gray-800">{{ $stats['total_documents'] }}</div>
                        <div class="text-xs text-gray-400 mt-2">Arsip digital tersimpan</div>
                    </div>
                    {{-- Card 2 --}}
                    <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow rounded-xl border border-gray-100 p-6 relative">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-20 h-20 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                        </div>
                        <div class="text-blue-600 text-xs font-bold uppercase tracking-widest mb-1">Total Diunduh</div>
                        <div class="text-4xl font-extrabold text-gray-800">{{ $stats['total_downloads'] }}</div>
                        <div class="text-xs text-gray-400 mt-2">Kali akses dokumen</div>
                    </div>
                    {{-- Card 3 --}}
                    <div class="bg-white overflow-hidden shadow-sm hover:shadow-md transition-shadow rounded-xl border border-gray-100 p-6 relative">
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <svg class="w-20 h-20 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                        </div>
                        <div class="text-purple-600 text-xs font-bold uppercase tracking-widest mb-1">Kategori</div>
                        <div class="text-4xl font-extrabold text-gray-800">{{ $stats['total_categories'] }}</div>
                        <div class="text-xs text-gray-400 mt-2">Jenis pengelompokan</div>
                    </div>
                </div>
            </div>
        </div>
        @endhasanyrole

        {{-- ========================================== --}}
        {{-- HASIL PENCARIAN / DAFTAR DOKUMEN        --}}
        {{-- ========================================== --}}
        
        @if(Auth::user()->hasAnyRole(['admin', 'super-admin']) || request('search') || !$documents->isEmpty())
        <div id="hasil-pencarian" class="bg-gray-50 border-t border-gray-200 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                
                {{-- Judul Section & Toolbar --}}
                {{-- PERUBAHAN: items-end diganti items-center agar vertikalnya pas di tengah --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    
                    {{-- Kiri: Judul Tabel --}}
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2 self-start md:self-center">
                        <span class="w-2 h-8 bg-green-600 rounded-full"></span>
                        @if(request('search')) 
                            Hasil: "{{ request('search') }}" 
                        @else 
                            @hasanyrole('admin|super-admin') Arsip Dokumen @else Dokumen Terbaru @endhasanyrole
                        @endif
                    </h3>

                    {{-- Kanan: Toolbar (Search & Upload SEJAJAR) --}}
                    @hasanyrole('admin|super-admin')
                    {{-- PERUBAHAN: Menggunakan flex-row untuk mensejajarkan elemen --}}
                    <div class="flex flex-col md:flex-row items-center gap-3 w-full md:w-auto">
                        
                        {{-- 1. Form Pencarian --}}
                        <form method="GET" action="{{ route('dashboard') }}" class="relative w-full md:w-64">
                            <input type="text" name="search" placeholder="Cari dokumen..." value="{{ request('search') }}" 
                                class="w-full pl-3 pr-10 py-2 rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm bg-white">
                            
                            {{-- Ikon Kaca Pembesar --}}
                            <button type="submit" class="absolute inset-y-0 right-0 px-3 text-gray-400 hover:text-green-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </form>

                        {{-- 2. Tombol Upload --}}
                        <a href="{{ route('documents.create') }}" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-5 rounded-lg shadow text-sm flex items-center justify-center gap-2 transition-transform transform hover:scale-105 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                            <span>Upload Baru</span>
                        </a>

                    </div>
                    @endhasanyrole
                </div>

                {{-- ========================================== --}}
                {{-- 1. TAMPILAN MOBILE (CARD VIEW)           --}}
                {{-- Muncul di HP (md:hidden), Hilang di PC   --}}
                {{-- ========================================== --}}
                <div class="block md:hidden space-y-4">
                    @forelse ($documents as $doc)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col gap-3 active:scale-[0.99] transition-transform duration-100">
                        
                        {{-- Header Kartu: Kategori & Tanggal --}}
                        <div class="flex justify-between items-start">
                            <span class="px-3 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800 border border-green-200">
                                {{ $doc->category->name }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium">
                                {{ $doc->created_at->format('d M Y') }}
                            </span>
                        </div>

                        {{-- Body Kartu: Ikon & Judul --}}
                        <div class="flex items-start gap-4">
                            {{-- Ikon PDF Besar --}}
                            <div class="flex-shrink-0 bg-red-50 p-2 rounded-xl">
                                <a href="{{ route('documents.view', $doc) }}" target="_blank">
                                    <svg class="h-10 w-10 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            </div>
                            
                            {{-- Judul & Deskripsi --}}
                            <div class="flex-grow">
                                {{-- Judul sudah ada Link-nya --}}
                                <a href="{{ route('documents.view', $doc) }}" target="_blank" class="block">
                                    <h4 class="text-lg font-bold text-gray-800 leading-tight mb-1 cursor-pointer hover:text-green-600">
                                        {{ $doc->title }}
                                    </h4>
                                </a>
                                <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">
                                    {{ $doc->description ?? 'Tidak ada deskripsi.' }}
                                </p>
                            </div>
                        </div>

                        {{-- Footer Kartu: Tombol Aksi Full Width --}}
                        <div class="mt-2 pt-3 border-t border-gray-50 flex gap-2">
                            {{-- Tombol Lihat --}}
                            <a href="{{ route('documents.view', $doc) }}" target="_blank" class="flex-1 text-center py-2.5 rounded-lg border border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50 transition">
                                Lihat
                            </a>
                            {{-- Tombol Download --}}
                            <a href="{{ route('documents.download', $doc) }}" class="flex-1 text-center py-2.5 rounded-lg bg-green-600 text-white font-bold text-sm shadow-md hover:bg-green-700 active:bg-green-800 transition">
                                Unduh PDF
                            </a>
                        </div>
                        
                        {{-- Admin Action (Mobile) --}}
                        @hasanyrole('admin|super-admin')
                        <div class="flex justify-end gap-3 text-xs font-bold pt-1">
                            <a href="{{ route('documents.edit', $doc) }}" class="text-yellow-600 uppercase tracking-wide">Edit</a>
                            <form action="{{ route('documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus?');">
                                @csrf @method('DELETE')
                                <button class="text-red-500 uppercase tracking-wide">Hapus</button>
                            </form>
                        </div>
                        @endhasanyrole
                    </div>
                    @empty
                    <div class="text-center py-10 text-gray-400 bg-white rounded-xl border border-dashed border-gray-300">
                        <p>Tidak ada dokumen ditemukan.</p>
                    </div>
                    @endforelse
                    
                    {{-- Pagination Mobile --}}
                    <div class="pt-2">
                        {{ $documents->links() }} {{-- Laravel otomatis menyesuaikan pagination mobile --}}
                    </div>
                </div>


                {{-- ========================================== --}}
                {{-- 2. TAMPILAN DESKTOP (TABLE VIEW)        --}}
                {{-- Muncul di PC (md:block), Hilang di HP    --}}
                {{-- ========================================== --}}
                <div class="hidden md:block bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Judul Dokumen</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Kategori</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-800 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-green-800 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($documents as $doc)
                                <tr class="hover:bg-green-50/50 transition-colors duration-200 group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start">
                                            <a href="{{ route('documents.view', $doc) }}" target="_blank" class="flex-shrink-0" title="Baca Dokumen">
                                                <svg class="h-10 w-10 text-red-500 mr-4 group-hover:scale-110 transition-transform shadow-sm rounded-sm bg-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                                </svg>
                                            </a>
                                            <div class="flex flex-col">
                                                <a href="{{ route('documents.view', $doc) }}" target="_blank" class="text-base font-bold text-gray-800 mb-1 hover:text-green-600 hover:underline transition-colors">
                                                    {{ $doc->title }}
                                                </a>
                                                <a href="{{ route('documents.view', $doc) }}" target="_blank" class="text-sm text-gray-500 line-clamp-2 hover:text-green-600 transition-colors cursor-pointer">
                                                    {{ $doc->description ?? 'Tidak ada deskripsi.' }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                            {{ $doc->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ $doc->created_at->format('d M Y') }}</div>
                                        @hasanyrole('admin|super-admin')
                                            <div class="text-xs text-gray-500 mt-1">Oleh: {{ $doc->uploader->name }}</div>
                                        @endhasanyrole
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('documents.download', $doc) }}" class="inline-flex items-center text-white bg-green-600 hover:bg-green-700 px-3 py-1.5 rounded-md text-xs font-bold transition mr-2 shadow-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            Unduh
                                        </a>
                                        @hasanyrole('admin|super-admin')
                                            <a href="{{ route('documents.edit', $doc) }}" class="text-yellow-600 hover:text-yellow-800 font-bold mr-2 text-xs uppercase">Edit</a>
                                            <form action="{{ route('documents.destroy', $doc) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus?');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-500 hover:text-red-700 font-bold text-xs uppercase">Hapus</button>
                                            </form>
                                        @endhasanyrole
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center text-gray-500">Belum ada dokumen.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $documents->links() }}
                    </div>
                </div>

            </div>
        </div>
        @endif

        {{-- Footer --}}
        <footer class="bg-white py-8 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-gray-400 text-sm">
                    &copy; {{ date('Y') }} RS PKU Aisyiyah Boyolali. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    {{-- SCRIPT SCROLL OTOMATIS --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // PERBAIKAN: Bungkus dengan tanda kutip agar VS Code tidak error
            // Jika ada request search, isinya akan masuk ke variabel string ini
            const searchKeyword = "{{ request('search') }}";
            
            // Cek jika variabel tidak kosong (artinya user sedang mencari)
            if (searchKeyword) {
                const element = document.getElementById("hasil-pencarian");
                if (element) {
                    setTimeout(() => {
                        element.scrollIntoView({ 
                            behavior: "smooth", 
                            block: "start" 
                        });
                    }, 100); 
                }
            }
        });
    </script>
    
</x-app-layout>