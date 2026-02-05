<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Modern Onboarding Experience - Digital Library RS PKU Aisyiyah Boyolali</title>
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
            background: rgba(255, 255, 255, 0.6); /* Sedikit lebih solid untuk mobile */
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
                    screens: {
                        'xs': '475px', // Tambahan breakpoint untuk HP kecil
                    }
                },
            },
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased overflow-x-hidden">
    <div class="relative flex min-h-screen w-full flex-col">
        
        <header id="navbar" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-4 md:px-16 py-4 md:py-6 transition-all duration-300 bg-white/5 backdrop-blur-sm md:bg-transparent md:backdrop-blur-none">
            <div class="flex items-center gap-3">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 md:gap-3 hover:opacity-80 transition-opacity">
                    <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="h-8 md:h-10 w-auto">
                    <div class="flex flex-col">
                        <h2 class="text-lg md:text-xl font-semibold tracking-tight text-slate-900 dark:text-white leading-tight">Digital Library</h2>
                        <p class="text-[10px] md:text-xs font-medium text-primary uppercase tracking-wider">RS PKU Aisyiyah</p>
                    </div>
                </a>
            </div>
            <div class="flex items-center gap-4 md:gap-10">
                <nav class="hidden md:flex gap-8">
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('catalogue') }}">Katalog</a>
                </nav>
                <a href="{{ route('login') }}" class="px-4 py-2 md:px-6 md:py-2.5 bg-primary text-white rounded-full text-xs md:text-sm font-semibold hover:bg-[#00773b] transition-all pku-shadow whitespace-nowrap">
                    Portal Login
                </a>
            </div>
        </header>

        <main class="flex-1">
            <section class="relative h-screen min-h-[600px] lg:min-h-[900px] w-full flex items-center overflow-hidden">
                
                <div class="absolute inset-0 z-0">
                    <div class="absolute inset-0 bg-gradient-to-b md:bg-gradient-to-r from-background-light via-background-light/80 to-transparent dark:from-background-dark dark:via-background-dark/80 z-10"></div>
                    <div class="w-full h-full bg-center bg-cover scale-105" style='background-image: url("{{ asset("img/background_1.jpg") }}");'>
                    </div>
                </div>

                <div class="container mx-auto px-4 md:px-16 relative z-20 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center h-full pt-20 md:pt-0">
                    <div class="max-w-xl mx-auto lg:mx-0 text-center lg:text-left">
                        
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6 md:mb-8 tracking-tight">
                            Elevating <span class="text-primary pku-glow-text block md:inline">Medical</span> Knowledge.
                        </h1>
                        
                        <p class="text-base md:text-xl text-slate-700 dark:text-slate-300 leading-relaxed mb-8 px-2 md:px-0">
                            Selamat datang di Digital Library RS PKU Aisyiyah Boyolali. Hub canggih untuk profesional medis mengakses riset global secara instan.
                        </p>

                        <div class="relative group mb-8 md:mb-10 max-w-md mx-auto lg:mx-0">
                            <form action="{{ route('catalogue') }}" method="GET">
                                <div class="search-glass p-1.5 md:p-2 rounded-2xl flex items-center gap-2 transition-all duration-300 shadow-lg">
                                    <div class="flex items-center justify-center pl-3 text-primary">
                                        <span class="material-symbols-outlined text-2xl md:text-3xl">search</span>
                                    </div>
                                    <input name="search" value="{{ $searchQuery ?? '' }}" class="bg-transparent border-none focus:ring-0 w-full py-3 md:py-4 text-base md:text-lg text-slate-800 dark:text-white placeholder:text-slate-600 dark:placeholder:text-slate-400 font-medium" placeholder="Cari disini..." type="text"/>
                                    <button type="submit" class="bg-primary text-white p-3 md:px-6 md:py-3 rounded-xl font-bold hover:bg-[#00773b] transition-all shadow-md active:scale-95 shrink-0">
                                        <span class="block md:hidden material-symbols-outlined text-xl">arrow_forward</span>
                                        <span class="hidden md:block">CARI</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('catalogue') }}" class="group flex items-center justify-center gap-2 px-6 py-3.5 bg-primary text-white rounded-2xl text-base md:text-lg font-bold transition-all hover:bg-[#00773b] pku-shadow hover:scale-[1.02]">
                                Mulai Sekarang
                                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                            <a href="{{ route('catalogue') }}" class="flex items-center justify-center px-6 py-3.5 bg-white/70 dark:bg-white/5 backdrop-blur-md border border-slate-200 dark:border-white/20 rounded-2xl text-base md:text-lg font-semibold hover:bg-white dark:hover:bg-white/10 transition-all text-slate-800 dark:text-white">
                                Jelajahi Arsip
                            </a>
                        </div>
                    </div>

                    <div class="hidden lg:block">
                        <div class="glass-card rounded-3xl p-8 max-w-md ml-auto pku-shadow hover:-translate-y-2 transition-transform duration-500">
                            <div class="flex gap-4 mb-6">
                                <div class="size-12 rounded-2xl bg-primary flex items-center justify-center text-white shrink-0">
                                    <span class="material-symbols-outlined">menu_book</span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold">Akses Pintar</h3>
                                    <p class="text-sm text-slate-500">Terhubung langsung dengan ID staf Anda</p>
                                </div>
                            </div>
                            <p class="text-slate-600 dark:text-slate-300 leading-relaxed">
                                Sinkronkan daftar bacaan Anda di berbagai workstation rumah sakit dan perangkat pribadi. Akses 10.000+ jurnal medis dan makalah peer-review dengan lancar.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="features" class="py-16 md:py-24 bg-white dark:bg-[#0c1a11]">
                <div class="container mx-auto px-4 md:px-16">
                    @if(isset($searchQuery) && $searchQuery)
                        <div class="mb-8 text-center md:text-left">
                            <h2 class="text-2xl md:text-3xl font-bold mb-2">Hasil Pencarian untuk "{{ $searchQuery }}"</h2>
                            <p class="text-slate-600 dark:text-slate-400">Ditemukan {{ $documents->total() }} dokumen</p>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-12">
                        @php
                            $featureImages = [
                                'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80',
                                'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&q=80',
                                'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&q=80'
                            ];
                            $features = [
                                ['title' => 'Penelitian Terpadu', 'subtitle' => 'Hub Pengetahuan', 'desc' => 'Temukan dan analisis jurnal medis dengan mesin pencarian semantik bertenaga AI kami.', 'badge' => 'Dikurasi khusus untuk staf RS PKU'],
                                ['title' => 'Referensi Cepat', 'subtitle' => 'Panduan Klinis', 'desc' => 'Akses panduan farmasi dan prosedur bedah dalam hitungan detik saat ronde.', 'badge' => 'Data farmasi tingkat tinggi'],
                                ['title' => 'Siap Mobile', 'subtitle' => 'Tetap Sinkron', 'desc' => 'Simpan makalah di desktop Anda dan lanjutkan membaca di mobile saat perjalanan.', 'badge' => 'Kolaborasi lintas perangkat']
                            ];
                            $featureCount = 0;
                        @endphp

                        @forelse($documents->take(4) as $doc)
                            @php
                                $cover = $doc->cover_image;
                                $publicPath = $cover ? public_path('storage/'.$cover) : null;
                                $coverUrl = null;
                                if ($cover) {
                                    if ($publicPath && file_exists($publicPath)) {
                                        $coverUrl = asset('storage/'.$cover);
                                    } elseif (Storage::disk('public')->exists($cover)) {
                                        $coverUrl = Storage::disk('public')->url($cover);
                                    }
                                }
                                $bgImage = $coverUrl ?? $featureImages[$featureCount % 3];
                                $feature = $features[$featureCount % 3];
                                $featureCount++;
                            @endphp

                            <a href="{{ route('documents.view-public', $doc->id) }}" target="_blank" class="group cursor-pointer no-underline block">
                                <div class="relative overflow-hidden rounded-3xl mb-6 aspect-[4/5] bg-slate-100 shadow-sm">
                                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style='background-image: url("{{ $bgImage }}");'></div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-transparent to-transparent opacity-60 md:opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                    <div class="absolute bottom-6 left-6 right-6">
                                        <div class="glass-card p-4 md:p-6 rounded-2xl md:opacity-0 md:translate-y-4 md:group-hover:opacity-100 md:group-hover:translate-y-0 transition-all duration-500">
                                            <h4 class="font-bold text-base md:text-lg mb-1">{{ $doc->category->name ?? $feature['subtitle'] }}</h4>
                                            <p class="text-xs md:text-sm text-slate-600 dark:text-slate-300 line-clamp-2">{{ Str::limit($doc->description, 50) ?: $feature['badge'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="text-xl md:text-2xl font-bold mb-3 group-hover:text-primary transition-colors">{{ $doc->title }}</h3>
                                <p class="text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed hover:text-slate-800 dark:hover:text-slate-200 transition-colors line-clamp-3">
                                    {{ Str::limit($doc->description, 120) ?: $feature['desc'] }}
                                </p>
                            </a>
                        @empty
                            @foreach($features as $index => $feature)
                                <div class="group cursor-pointer">
                                    <div class="relative overflow-hidden rounded-3xl mb-6 aspect-[4/5] bg-slate-100 shadow-sm">
                                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style='background-image: url("{{ $featureImages[$index] }}");'></div>
                                        <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-transparent to-transparent opacity-60 md:opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="absolute bottom-6 left-6 right-6">
                                            <div class="glass-card p-4 md:p-6 rounded-2xl md:opacity-0 md:translate-y-4 md:group-hover:opacity-100 md:group-hover:translate-y-0 transition-all duration-500">
                                                <h4 class="font-bold text-base md:text-lg mb-1">{{ $feature['subtitle'] }}</h4>
                                                <p class="text-xs md:text-sm text-slate-600 dark:text-slate-300">{{ $feature['badge'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold mb-3 group-hover:text-primary transition-colors">{{ $feature['title'] }}</h3>
                                    <p class="text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                                        {{ $feature['desc'] }}
                                    </p>
                                </div>
                            @endforeach
                        @endforelse
                    </div>
                    
                    @if($documents->hasPages())
                        <div class="mt-12 flex justify-center">
                            {{ $documents->links() }}
                        </div>
                    @endif
                </div>
            </section>
        </main>

        <footer id="footer" class="bg-background-light dark:bg-background-dark border-t border-slate-200 dark:border-white/5 py-8 md:py-12">
            <div class="mt-4 md:mt-12 text-center text-slate-400 text-xs px-4">
                © {{ date('Y') }} RS PKU Aisyiyah Boyolali. All rights reserved.
            </div>
        </footer>
    </div>

    <script>
        // Javascript tetap sama
        @if(isset($searchQuery) && $searchQuery)
            document.addEventListener('DOMContentLoaded', function() {
                const featuresSection = document.getElementById('features');
                if (featuresSection) {
                    setTimeout(() => {
                        featuresSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            });
        @endif

        let lastScrollTop = 0;
        const navbar = document.getElementById('navbar');
        const scrollThreshold = 50;

        window.addEventListener('scroll', function() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            
            if (currentScroll > scrollThreshold) {
                if (currentScroll > lastScrollTop) {
                    navbar.classList.add('navbar-hidden');
                } else {
                    navbar.classList.remove('navbar-hidden');
                }
            } else {
                navbar.classList.remove('navbar-hidden');
            }
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });
    </script>
</body>
</html>