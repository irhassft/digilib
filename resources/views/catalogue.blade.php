<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Katalog - Digital Library RS PKU Aisyiyah Boyolali</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style type="text/tailwindcss">
        :root {
            --pku-green: #008844;
            --pku-glow: rgba(0, 136, 68, 0.15);  
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }
        .search-glass {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .search-glass:focus-within {
            background: rgba(255, 255, 255, 0.8);
            border-color: rgba(0, 136, 68, 0.3);
            box-shadow: 0 0 0 3px rgba(0, 136, 68, 0.1);
        }
        .pku-shadow {
            box-shadow: 0 20px 40px -15px var(--pku-glow);
        }
        .pku-glow-text {
            text-shadow: 0 0 20px var(--pku-glow);
        }
        .navbar-hidden {
            transform: translateY(-100%);
            opacity: 0;
        }
        .doc-card {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .doc-card:hover {
            transform: translateY(-8px);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: false,
            theme: {
                extend: {
                    colors: {
                        "primary": "#008844",
                        "primary-light": "#00a851",
                        "primary-dark": "#006633",
                        "background-light": "#FAFBFC",
                        "surface-light": "#FFFFFF",
                    },
                    borderRadius: {
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "4xl": "2rem",
                    },
                    spacing: {
                        "128": "32rem",
                    },
                    typography: {
                        DEFAULT: {
                            css: {
                                maxWidth: 'none',
                            },
                        },
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-background-light text-slate-900 antialiased overflow-x-hidden">
    <div class="relative flex min-h-screen w-full flex-col">
        <!-- Header -->
        <header id="navbar" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-6 sm:px-8 md:px-12 lg:px-16 py-4 sm:py-5 transition-all duration-300 bg-background-light/90 backdrop-blur-xl border-b border-slate-200/50">
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 sm:gap-3 hover:opacity-80 transition-opacity duration-200 group">
                    <div class="relative">
                        <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="h-9 sm:h-10 w-auto group-hover:scale-110 transition-transform duration-200">
                    </div>
                    <div class="flex flex-col">
                        <h2 class="text-lg sm:text-xl font-bold tracking-tight text-slate-900 leading-tight">Digital Library</h2>
                        <p class="text-xs font-semibold text-primary uppercase tracking-widest hidden sm:block">RS PKU Aisyiyah</p>
                    </div>
                </a>
            </div>
            <div class="flex items-center gap-6 sm:gap-10">
                <nav class="hidden md:flex gap-8">
                    <a class="text-sm font-semibold text-slate-700 hover:text-primary transition-colors duration-200 relative group" href="{{ route('welcome') }}">
                        Beranda
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a class="text-sm font-semibold text-primary transition-colors duration-200 relative group" href="{{ route('catalogue') }}">
                        Katalog
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary transition-all duration-300"></span>
                    </a>
                </nav>
                <a href="{{ route('login') }}" class="px-5 sm:px-6 py-2 sm:py-2.5 bg-primary hover:bg-primary-dark text-white rounded-xl sm:rounded-full text-xs sm:text-sm font-bold transition-all duration-200 pku-shadow hover:shadow-lg active:scale-95 transform">
                    Portal Login
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 mt-16 sm:mt-20">
            <!-- Page Header with Search -->
            <section class="py-4 sm:py-6 bg-gradient-to-br from-primary/8 via-primary/3 to-transparent">
                <div class="container mx-auto px-6 sm:px-8 md:px-12 lg:px-16">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                        
                        <!-- Search Bar -->
                        <form action="{{ route('catalogue') }}" method="GET" class="w-full md:w-auto md:flex-1 md:max-w-2xl">
                            <div class="search-glass p-2.5 sm:p-3 rounded-2xl flex items-center gap-3 ring-1 ring-slate-200 focus-within:ring-2 focus-within:ring-primary/30">
                                <div class="flex items-center justify-center pl-2 sm:pl-3 text-primary flex-shrink-0">
                                    <span class="material-symbols-outlined text-xl">search</span>
                                </div>
                                <input name="search" value="{{ $searchQuery ?? '' }}" class="bg-transparent border-none focus:ring-0 w-full py-2 text-sm text-slate-800 placeholder:text-slate-400 font-medium" placeholder="Cari dokumen..." type="text"/>
                                @if($searchQuery)
                                    <a href="{{ route('catalogue') }}" class="px-2 text-slate-400 hover:text-slate-600 transition-colors duration-200 flex-shrink-0">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                    </a>
                                @endif
                                <button type="submit" class="bg-primary hover:bg-primary-dark text-white px-3 sm:px-4 py-1.5 sm:py-2 rounded-lg font-bold transition-all duration-200 pku-shadow hover:shadow-lg active:scale-95 hidden sm:block text-xs sm:text-sm flex-shrink-0">
                                    Cari
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Category Filter Section -->
            <section class="py-4 sm:py-5 bg-white border-b border-slate-100">
                <div class="container mx-auto px-6 sm:px-8 md:px-12 lg:px-16">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4">
                        <label for="category-filter" class="text-sm font-semibold text-slate-700 flex-shrink-0">Kategori:</label>
                        <select id="category-filter" name="category" onchange="window.location.href = this.value;" class="w-full sm:w-auto px-3 py-2 rounded-lg border border-slate-200 bg-white text-slate-900 font-semibold text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-transparent transition-all duration-200 cursor-pointer hover:border-primary/50">
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
            <section class="py-6 sm:py-8 bg-white">
                <div class="container mx-auto px-6 sm:px-8 md:px-12 lg:px-16">
                    <!-- Results info -->
                    <div class="mb-6 sm:mb-8">
                        <p class="text-xs sm:text-sm text-slate-600">
                            Menampilkan <span class="font-bold text-slate-900 text-primary">{{ $documents->count() }}</span> dari <span class="font-bold text-slate-900">{{ $documents->total() }}</span> dokumen
                        </p>
                    </div>

                    @if($documents->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 lg:gap-6">
                            @foreach($documents as $doc)
                                <a href="{{ route('documents.view-public', $doc->id) }}" target="_blank" class="group cursor-pointer no-underline block transition-all duration-300 doc-card">
                                    <!-- Card Container -->
                                    <div class="bg-white rounded-xl sm:rounded-2xl overflow-hidden border border-slate-200/50 transition-all duration-300 hover:border-primary/30 pku-shadow hover:shadow-xl h-full flex flex-col">
                                        <!-- Image Container -->
                                        <div class="relative overflow-hidden aspect-[3/4] bg-gradient-to-br from-slate-100 to-slate-200 flex-shrink-0">
                                            @if($doc->cover_image && file_exists(public_path('storage/'.$doc->cover_image)))
                                                <img src="{{ asset('storage/'.$doc->cover_image) }}" alt="{{ $doc->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-7xl sm:text-8xl text-primary/30 group-hover:text-primary/50 transition-colors duration-300">description</span>
                                                </div>
                                            @endif
                                            <!-- Overlay Gradient -->
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                            <!-- Badge Background -->
                                            <div class="absolute top-4 left-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        </div>
                                        
                                        <!-- Content -->
                                        <div class="flex flex-col flex-grow p-4 sm:p-5 space-y-2 sm:space-y-3">
                                            <!-- Category Badge -->
                                            @if($doc->category)
                                                <div class="inline-flex items-center gap-2 w-fit">
                                                    <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-primary/15 text-primary uppercase tracking-wide">
                                                        {{ $doc->category->name }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            <!-- Title -->
                                            <h3 class="text-sm sm:text-base font-bold leading-snug text-slate-900 group-hover:text-primary transition-colors duration-300 line-clamp-2">
                                                {{ $doc->title }}
                                            </h3>
                                            
                                            <!-- Description -->
                                            <p class="text-xs text-slate-600 line-clamp-1 leading-relaxed flex-grow">
                                                {{ $doc->description ?? 'Dokumen medis profesional' }}
                                            </p>

                                            <!-- Meta Info -->
                                            <div class="flex items-center justify-between pt-2 sm:pt-3 border-t border-slate-200/50">
                                                <div class="flex items-center gap-2">
                                                    <div class="flex items-center gap-1 text-xs text-slate-500 font-medium">
                                                        @if($doc->year)
                                                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                                                            <span>{{ $doc->year }}</span>
                                                        @else
                                                            <span>Tahun tidak tersedia</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    <span class="text-xs text-slate-500 font-medium">
                                                        {{ $doc->formatted_file_size }}
                                                    </span>
                                                    <div class="flex items-center gap-1 text-slate-400 group-hover:text-primary transition-colors duration-300">
                                                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform duration-300">arrow_forward</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($documents->hasPages())
                            <div class="mt-6 sm:mt-8 flex justify-center">
                                <div class="flex flex-wrap gap-2 sm:gap-3 justify-center">
                                    {{-- Previous Page Link --}}
                                    @if ($documents->onFirstPage())
                                        <span class="px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed font-semibold">
                                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                                        </span>
                                    @else
                                        <a href="{{ $documents->previousPageUrl() }}" class="px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg bg-primary hover:bg-primary-dark text-white transition-all duration-200 font-semibold pku-shadow hover:shadow-lg active:scale-95">
                                            <span class="material-symbols-outlined text-lg">chevron_left</span>
                                        </a>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($documents->getUrlRange(1, $documents->lastPage()) as $page => $url)
                                        @if ($page == $documents->currentPage())
                                            <span class="px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg bg-primary text-white font-bold text-sm sm:text-base">{{ $page }}</span>
                                        @else
                                            <a href="{{ $url }}" class="px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-900 transition-all duration-200 font-semibold text-sm sm:text-base">{{ $page }}</a>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($documents->hasMorePages())
                                        <a href="{{ $documents->nextPageUrl() }}" class="px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg bg-primary hover:bg-primary-dark text-white transition-all duration-200 font-semibold pku-shadow hover:shadow-lg active:scale-95">
                                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                                        </a>
                                    @else
                                        <span class="px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed font-semibold">
                                            <span class="material-symbols-outlined text-lg">chevron_right</span>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="py-8 sm:py-12 text-center">
                            <div class="mb-4 sm:mb-6 flex justify-center">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-primary/10 blur-3xl rounded-full"></div>
                                    <span class="material-symbols-outlined text-7xl sm:text-8xl text-slate-300 relative">library_books</span>
                                </div>
                            </div>
                            <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-2">Tidak ada dokumen ditemukan</h3>
                            <p class="text-slate-600 mb-6 text-xs sm:text-sm">Coba ubah kata kunci pencarian atau pilih kategori yang berbeda.</p>
                            <a href="{{ route('catalogue') }}" class="inline-block px-5 sm:px-6 py-2 sm:py-2.5 bg-primary hover:bg-primary-dark text-white rounded-lg sm:rounded-xl font-bold transition-all duration-200 pku-shadow hover:shadow-lg active:scale-95">
                                Lihat Semua Dokumen
                            </a>
                        </div>
                    @endif
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-slate-50 border-t border-slate-200 py-6 sm:py-8">
            <div class="container mx-auto px-6 sm:px-8 md:px-12 lg:px-16 text-center">
                <p class="text-xs sm:text-sm text-slate-500">
                    © {{ date('Y') }} RS PKU Aisyiyah Boyolali. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

    <script>
        // Hide navbar on scroll down with smooth animation
        let lastScrollTop = 0;
        const navbar = document.getElementById('navbar');
        const scrollThreshold = 50;
        let isHidden = false;

        window.addEventListener('scroll', function() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            
            if (currentScroll > scrollThreshold) {
                if (currentScroll > lastScrollTop && !isHidden) {
                    // Scrolling DOWN - hide navbar
                    navbar.classList.add('navbar-hidden');
                    isHidden = true;
                } else if (currentScroll < lastScrollTop && isHidden) {
                    // Scrolling UP - show navbar
                    navbar.classList.remove('navbar-hidden');
                    isHidden = false;
                }
            } else {
                // At top of page
                navbar.classList.remove('navbar-hidden');
                isHidden = false;
            }
            
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });

        // Add active class to current link
        const currentLocation = location.pathname;
        const menuItems = document.querySelectorAll('nav a');
        menuItems.forEach(item => {
            if (item.getAttribute('href') === currentLocation) {
                item.classList.add('text-primary');
            }
        });
    </script>
</body>
</html>
