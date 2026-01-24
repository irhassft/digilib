<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Modern Onboarding Experience - Digilib RS PKU</title>
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
        <header id="navbar" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-8 md:px-16 py-6 transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-primary/10 rounded-xl backdrop-blur-md">
                    <div class="size-7 text-primary">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" d="M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z" fill="currentColor" fill-rule="evenodd"></path>
                            <path clip-rule="evenodd" d="M24 8.18819L33.4123 11.574L24 15.2071L14.5877 11.574L24 8.18819ZM9 15.8487L21 20.4805V37.6263L9 32.9945V15.8487ZM27 37.6263V20.4805L39 15.8487V32.9945L27 37.6263ZM25.354 2.29885C24.4788 1.98402 23.5212 1.98402 22.646 2.29885L4.98454 8.65208C3.7939 9.08038 3 10.2097 3 11.475V34.3663C3 36.0196 4.01719 37.5026 5.55962 38.098L22.9197 44.7987C23.6149 45.0671 24.3851 45.0671 25.0803 44.7987L42.4404 38.098C43.9828 37.5026 45 36.0196 45 34.3663V11.475C45 10.2097 44.2061 9.08038 43.0155 8.65208L25.354 2.29885Z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="text-xl font-semibold tracking-tight">Digilib <span class="text-primary">PKU</span></h2>
            </div>
            <div class="flex items-center gap-10">
                <nav class="hidden md:flex gap-8">
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#catalogue">Catalogue</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#features">Research Tools</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="#footer">Library Help</a>
                </nav>
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-primary text-white rounded-full text-sm font-semibold hover:bg-[#00773b] transition-all pku-shadow">
                    Portal Login
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <!-- Hero Section -->
            <section class="relative h-screen min-h-[900px] w-full flex items-center overflow-hidden">
                <!-- Background -->
                <div class="absolute inset-0 z-0">
                    <div class="absolute inset-0 bg-gradient-to-r from-background-light via-background-light/40 to-transparent dark:from-background-dark dark:via-background-dark/40 z-10"></div>
                    <div class="w-full h-full bg-top bg-cover scale-105" style='background-image: url("{{ asset("img/background_1.jpg") }}");'>
                    </div>
                </div>

                <!-- Hero Content -->
                <div class="container mx-auto px-8 md:px-16 relative z-20 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="max-w-xl">
                        <h1 class="text-6xl md:text-7xl font-bold leading-[1.1] mb-8 tracking-tight">
                            Elevating <span class="text-primary pku-glow-text">Medical</span> Knowledge.
                        </h1>
                        <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 leading-relaxed mb-8 hover:text-slate-900 dark:hover:text-slate-200 transition-colors duration-300">
                            Selamat datang di generasi terbaru Digilib RS PKU. Hub canggih yang dirancang khusus untuk profesional medis mengakses riset global dan wawasan klinis secara instan.
                        </p>

                        <!-- Search Bar -->
                        <div class="relative group mb-10">
                            <form action="{{ url('/') }}" method="GET">
                                <div class="search-glass p-2 rounded-2xl flex items-center gap-3 transition-all duration-300 group-focus-within:ring-2 group-focus-within:ring-primary/30 group-focus-within:bg-white/60 dark:group-focus-within:bg-white/10 shadow-lg">
                                    <div class="flex items-center justify-center pl-4 text-primary">
                                        <span class="material-symbols-outlined text-3xl">search</span>
                                    </div>
                                    <input name="search" value="{{ $searchQuery ?? '' }}" class="bg-transparent border-none focus:ring-0 w-full py-4 text-lg text-slate-800 dark:text-white placeholder:text-slate-500/70 dark:placeholder:text-slate-400/50 font-medium" placeholder="Cari jurnal, buku medis, atau panduan klinis..." type="text"/>
                                    <button type="submit" class="bg-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-[#00773b] transition-all shadow-md active:scale-95 hidden sm:block">
                                        Pencarian
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap gap-5">
                            <a href="#" class="group flex items-center gap-2 px-8 py-4 bg-primary text-white rounded-2xl text-lg font-bold transition-all hover:bg-[#00773b] pku-shadow hover:scale-[1.02]">
                                Mulai Sekarang
                                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                            <a href="#catalogue" class="px-8 py-4 bg-white/50 dark:bg-white/5 backdrop-blur-md border border-white/20 rounded-2xl text-lg font-semibold hover:bg-white/80 dark:hover:bg-white/10 transition-all">
                                Jelajahi Arsip
                            </a>
                        </div>
                    </div>

                    <!-- Smart Access Card (Desktop Only) -->
                    <div class="hidden lg:block">
                        <div class="glass-card rounded-3xl p-8 max-w-md ml-auto pku-shadow hover:-translate-y-2 transition-transform duration-500">
                            <div class="flex gap-4 mb-6">
                                <div class="size-12 rounded-2xl bg-primary flex items-center justify-center text-white">
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

            <!-- Features Section (Public Documents) -->
            <section id="features" class="py-24 bg-white dark:bg-[#0c1a11]">
                <div class="container mx-auto px-8 md:px-16">
                    @if(isset($searchQuery) && $searchQuery)
                        <div class="mb-8">
                            <h2 class="text-3xl font-bold mb-2">Hasil Pencarian untuk "{{ $searchQuery }}"</h2>
                            <p class="text-slate-600 dark:text-slate-400">Ditemukan {{ $documents->total() }} dokumen</p>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                        @php
                            $featureImages = [
                                'https://lh3.googleusercontent.com/aida-public/AB6AXuAS1NXSsjgl_7QT7lITiEjHcxtc65yt3ufcMFpUqzHaVLROXXviAPsqjcBEAJN0uhtyagvcaOgvbddv4FEAdci0ikMjQR-Uj84M_tLrbaSCK2cfdI-3Ay1qr26Oi8nFav6jSHjMR7XzcDj8GNQDZAqVF_gvqzp4vmHAb6dTxJ50MuJvfkiwqARqwdADrQnR3zfiFRF7p5Kfyfhsk5-GmptMWDIkh_vROxgkd_5S1w5xc7at7MuXLKk_1DDYWfUEpF-wHrkqozEg5Eo',
                                'https://lh3.googleusercontent.com/aida-public/AB6AXuCrlor8QaTdzJ3WnrITLkmAl3Efn5FQhvxXMjxVIEBovhvnfuSU5VeuVGMW5mhl46D62JQZjWl7t41rhILUy8KRE5ypsPVE8wfcTftkFKAEXrt-6FW94AA6BgGdBgPIZd87vAwzqG6h7ERjinVU1pU6B8-92e8Mvg57Hi1ild6pbMVqOFR3JgikITSkDIBXkhut_1eKE-Qaro-rHSI76Tc346UXT2NbTgRcEuh9D9nKmRxxvY_99IOe9kcvlm8_JUF6tLphm2WKiI0',
                                'https://lh3.googleusercontent.com/aida-public/AB6AXuCiK2z9Ryq-F99RcBBqu0pRzefJccDVmhytmySGjrrULRs2Gp5LyxFz0qG61dRu6EcDEYYjPB2QYB7k45ZCbTcra5qFb6byAINN1G0dgZp1DC-gMljdqO2PA7KLiE4u3absNNCIAwbJsdBE6VMBy4FJlvHZbV38d1gV_Ep1ICrkkmxFC5rtiCNLoJURw-JRk3-Vqz1GdMNVJbCKm4wrxgvB3r7dW7zaaw-TtjZlzyo2M9KVenqD6mZc_n4KqB7EiVFjeUQVIjyrpaU'
                            ];
                            $features = [
                                ['title' => 'Penelitian Terpadu', 'subtitle' => 'Hub Pengetahuan', 'desc' => 'Temukan dan analisis jurnal medis dengan mesin pencarian semantik bertenaga AI kami.', 'badge' => 'Dikurasi khusus untuk staf RS PKU'],
                                ['title' => 'Referensi Cepat', 'subtitle' => 'Panduan Klinis', 'desc' => 'Akses panduan farmasi dan prosedur bedah dalam hitungan detik saat ronde.', 'badge' => 'Data farmasi tingkat tinggi'],
                                ['title' => 'Siap Mobile', 'subtitle' => 'Tetap Sinkron', 'desc' => 'Simpan makalah di desktop Anda dan lanjutkan membaca di mobile saat perjalanan.', 'badge' => 'Kolaborasi lintas perangkat']
                            ];
                            $featureCount = 0;
                        @endphp

                        @forelse($documents->take(3) as $doc)
                            @if($doc->isPublic())
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
                                    <div class="relative overflow-hidden rounded-3xl mb-8 aspect-[4/5] bg-slate-100">
                                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style='background-image: url("{{ $bgImage }}");'></div>
                                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="absolute bottom-6 left-6 right-6">
                                            <div class="glass-card p-6 rounded-2xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500">
                                                <h4 class="font-bold text-lg mb-1">{{ $doc->category->name ?? $feature['subtitle'] }}</h4>
                                                <p class="text-sm text-slate-600 dark:text-slate-300">{{ Str::limit($doc->description, 50) ?: $feature['badge'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-bold mb-4 group-hover:text-primary transition-colors">{{ $doc->title }}</h3>
                                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                                        {{ Str::limit($doc->description, 120) ?: $feature['desc'] }}
                                    </p>
                                </a>
                            @endif
                        @empty
                            @foreach($features as $index => $feature)
                                <div class="group cursor-pointer">
                                    <div class="relative overflow-hidden rounded-3xl mb-8 aspect-[4/5] bg-slate-100">
                                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style='background-image: url("{{ $featureImages[$index] }}");'></div>
                                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="absolute bottom-6 left-6 right-6">
                                            <div class="glass-card p-6 rounded-2xl opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500">
                                                <h4 class="font-bold text-lg mb-1">{{ $feature['subtitle'] }}</h4>
                                                <p class="text-sm text-slate-600 dark:text-slate-300">{{ $feature['badge'] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="text-2xl font-bold mb-4 group-hover:text-primary transition-colors">{{ $feature['title'] }}</h3>
                                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed hover:text-slate-800 dark:hover:text-slate-200 transition-colors">
                                        {{ $feature['desc'] }}
                                    </p>
                                </div>
                            @endforeach
                        @endforelse
                    </div>
                    
                    <!-- Pagination -->
                    @if($documents->hasPages())
                        <div class="mt-12 flex justify-center">
                            {{ $documents->links() }}
                        </div>
                    @endif
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer id="footer" class="bg-background-light dark:bg-background-dark border-t border-slate-200 dark:border-white/5 py-12">
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
                        <a class="text-sm font-medium text-slate-500 hover:text-primary transition-colors" href="#features">Panduan Etika</a>
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
        // Auto scroll to search results if search query exists
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