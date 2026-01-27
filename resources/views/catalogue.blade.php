<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Katalog - Digilib RS PKU</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style type="text/tailwindcss">
        :root {
            --pku-green: #008844;
            --pku-glow: rgba(0, 136, 68, 0.4);  
        }
        body {
            font-family: 'Inter', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-card {
            background: rgba(16, 34, 21, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .search-glass {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .dark .search-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .pku-shadow {
            box-shadow: 0 10px 30px -10px var(--pku-glow);
        }
        .pku-glow-text {
            text-shadow: 0 0 20px var(--pku-glow);
        }
        .navbar-hidden {
            transform: translateY(-100%);
            opacity: 0;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#008844",
                        "background-light": "#F8FAFC",
                        "background-dark": "#0A140E",
                    },
                    borderRadius: {
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased overflow-x-hidden">
    <div class="relative flex min-h-screen w-full flex-col">
        <!-- Header -->
        <header id="navbar" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-8 md:px-16 py-6 transition-all duration-300 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md">
            <div class="flex items-center gap-3">
                <a href="{{ route('welcome') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <div class="p-2 bg-primary/10 rounded-xl backdrop-blur-md">
                        <div class="size-7 text-primary">
                            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path clip-rule="evenodd" d="M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z" fill="currentColor" fill-rule="evenodd"></path>
                                <path clip-rule="evenodd" d="M24 8.18819L33.4123 11.574L24 15.2071L14.5877 11.574L24 8.18819ZM9 15.8487L21 20.4805V37.6263L9 32.9945V15.8487ZM27 37.6263V20.4805L39 15.8487V32.9945L27 37.6263ZM25.354 2.29885C24.4788 1.98402 23.5212 1.98402 22.646 2.29885L4.98454 8.65208C3.7939 9.08038 3 10.2097 3 11.475V34.3663C3 36.0196 4.01719 37.5026 5.55962 38.098L22.9197 44.7987C23.6149 45.0671 24.3851 45.0671 25.0803 44.7987L42.4404 38.098C43.9828 37.5026 45 36.0196 45 34.3663V11.475C45 10.2097 44.2061 9.08038 43.0155 8.65208L25.354 2.29885Z" fill="currentColor" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-xl font-semibold tracking-tight">Digilib <span class="text-primary">PKU</span></h2>
                </a>
            </div>
            <div class="flex items-center gap-10">
                <nav class="hidden md:flex gap-8">
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('welcome') }}">Beranda</a>
                    <a class="text-sm font-medium text-primary transition-colors" href="{{ route('catalogue') }}">Katalog</a>
                </nav>
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-primary text-white rounded-full text-sm font-semibold hover:bg-[#00773b] transition-all pku-shadow">
                    Portal Login
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 mt-24">
            <!-- Page Header -->
            <section class="py-12 bg-gradient-to-r from-primary/5 to-transparent dark:from-primary/10 dark:to-transparent">
                <div class="container mx-auto px-8 md:px-16">
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Katalog Lengkap</h1>
                    <p class="text-lg text-slate-600 dark:text-slate-400">Jelajahi seluruh koleksi dokumen medis kami yang telah dikurasi untuk profesional kesehatan.</p>
                </div>
            </section>

            <!-- Search and Filter Section -->
            <section class="py-8 bg-white dark:bg-[#0c1a11] border-b border-slate-200 dark:border-white/5">
                <div class="container mx-auto px-8 md:px-16">
                    <!-- Search Bar -->
                    <form action="{{ route('catalogue') }}" method="GET" class="mb-8">
                        <div class="relative group">
                            <div class="search-glass p-2 rounded-2xl flex items-center gap-3 transition-all duration-300 group-focus-within:ring-2 group-focus-within:ring-primary/30">
                                <div class="flex items-center justify-center pl-4 text-primary">
                                    <span class="material-symbols-outlined text-2xl">search</span>
                                </div>
                                <input name="search" value="{{ $searchQuery ?? '' }}" class="bg-transparent border-none focus:ring-0 w-full py-3 text-base text-slate-800 dark:text-white placeholder:text-slate-500/70 dark:placeholder:text-slate-400/50 font-medium" placeholder="Cari judul, kategori, atau tahun..." type="text"/>
                                @if($searchQuery)
                                    <a href="{{ route('catalogue') }}" class="px-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                        <span class="material-symbols-outlined">close</span>
                                    </a>
                                @endif
                                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-xl font-bold hover:bg-[#00773b] transition-all shadow-md active:scale-95 hidden sm:block mr-1">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Category Filter -->
                    <div class="flex items-center gap-4">
                        <label for="category-filter" class="text-sm font-medium text-slate-600 dark:text-slate-400">Kategori:</label>
                        <select id="category-filter" name="category" onchange="window.location.href = this.value;" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white font-medium text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 transition-all">
                            <option value="{{ route('catalogue') }}">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ route('catalogue', ['category' => $category->id]) }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>

            <!-- Documents Grid -->
            <section class="py-12 bg-white dark:bg-[#0c1a11]">
                <div class="container mx-auto px-8 md:px-16">
                    <!-- Results info -->
                    <div class="mb-8">
                        <p class="text-slate-600 dark:text-slate-400">
                            Menampilkan <span class="font-semibold text-slate-900 dark:text-white">{{ $documents->count() }}</span> dari <span class="font-semibold text-slate-900 dark:text-white">{{ $documents->total() }}</span> dokumen
                        </p>
                    </div>

                    @if($documents->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($documents as $doc)
                                <a href="{{ route('documents.view-public', $doc->id) }}" target="_blank" class="group cursor-pointer no-underline block transition-all hover:scale-105">
                                    <div class="relative overflow-hidden rounded-2xl mb-6 aspect-[3/4] bg-slate-100 dark:bg-slate-800">
                                        @if($doc->cover_image && file_exists(public_path('storage/'.$doc->cover_image)))
                                            <img src="{{ asset('storage/'.$doc->cover_image) }}" alt="{{ $doc->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-6xl text-primary/40">description</span>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    </div>
                                    
                                    <div class="space-y-3">
                                        @if($doc->category)
                                            <div class="inline-block">
                                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-primary/10 text-primary">
                                                    {{ $doc->category->name }}
                                                </span>
                                            </div>
                                        @endif
                                        
                                        <h3 class="text-xl font-bold leading-snug text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2">
                                            {{ $doc->title }}
                                        </h3>
                                        
                                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                                            {{ $doc->description ?? 'Tidak ada deskripsi tersedia' }}
                                        </p>

                                        <div class="flex items-center justify-between pt-3">
                                            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-500">
                                                @if($doc->year)
                                                    <span class="material-symbols-outlined text-sm">calendar_today</span>
                                                    <span>{{ $doc->year }}</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-1 text-slate-400 group-hover:text-primary transition-colors">
                                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($documents->hasPages())
                            <div class="mt-12 flex justify-center">
                                <div class="flex flex-wrap gap-2 justify-center">
                                    {{-- Previous Page Link --}}
                                    @if ($documents->onFirstPage())
                                        <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed">
                                            <span class="material-symbols-outlined">chevron_left</span>
                                        </span>
                                    @else
                                        <a href="{{ $documents->previousPageUrl() }}" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-[#00773b] transition-all">
                                            <span class="material-symbols-outlined">chevron_left</span>
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
                                        @if ($page == $documents->currentPage())
                                            <span class="px-4 py-2 rounded-lg bg-primary text-white font-semibold">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}" class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">{{ $page }}</a>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($documents->hasMorePages())
                                        <a href="{{ $documents->nextPageUrl() }}" class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-[#00773b] transition-all">
                                            <span class="material-symbols-outlined">chevron_right</span>
                                        </a>
                                    @else
                                        <span class="px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 cursor-not-allowed">
                                            <span class="material-symbols-outlined">chevron_right</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="py-24 text-center">
                            <div class="mb-6 flex justify-center">
                                <span class="material-symbols-outlined text-8xl text-slate-300 dark:text-slate-700">library_books</span>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Tidak ada dokumen ditemukan</h3>
                            <p class="text-slate-600 dark:text-slate-400 mb-6">Coba ubah kata kunci pencarian atau pilih kategori yang berbeda.</p>
                            <a href="{{ route('catalogue') }}" class="inline-block px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-[#00773b] transition-all">
                                Lihat Semua Dokumen
                            </a>
                        </div>
                    @endif
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-background-light dark:bg-background-dark border-t border-slate-200 dark:border-white/5 py-12">
            <div class="container mx-auto px-8 md:px-16">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex items-center gap-3 grayscale opacity-70">
                        <div class="size-6 text-primary">
                            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-semibold tracking-tight uppercase">Digilib RS PKU</span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-10">
                        <a class="text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="{{ route('login') }}">Portal Rumah Sakit</a>
                        <a class="text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="{{ route('catalogue') }}">Katalog</a>
                        <a class="text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="#footer">Pusat Bantuan</a>
                        <a class="text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="#footer">Privasi</a>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400">
                        <span class="material-symbols-outlined text-sm">verified_user</span>
                        <p class="text-xs font-medium uppercase tracking-widest">Konten Medis Terverifikasi</p>
                    </div>
                </div>
                <div class="mt-12 text-center text-slate-400 text-xs">
                    © {{ date('Y') }} Platform Perpustakaan Digital RS PKU. Dioptimalkan untuk keunggulan staf medis.
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Hide navbar on scroll down
        let lastScrollTop = 0;
        const navbar = document.getElementById('navbar');
        const scrollThreshold = 50;

        window.addEventListener('scroll', function() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            
            if (currentScroll > scrollThreshold) {
                if (currentScroll > lastScrollTop) {
                    // Scrolling DOWN
                    navbar.classList.add('navbar-hidden');
                } else {
                    // Scrolling UP
                    navbar.classList.remove('navbar-hidden');
                }
            } else {
                // At top of page
                navbar.classList.remove('navbar-hidden');
            }
            
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });
    </script>
</body>
</html>
