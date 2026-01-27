<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Masuk - DIGILIB RS PKU</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
                },
            },
        }
    </script>
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
        .pku-shadow {
            box-shadow: 0 10px 30px -10px var(--pku-glow);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased overflow-x-hidden">
    <div class="relative flex min-h-screen w-full flex-col lg:flex-row">
        <!-- Left Side: Hero Section -->
        <div class="hidden lg:flex lg:w-3/5 relative bg-background-dark overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center opacity-40" style='background-image: url("{{ asset("img/background_1.jpg") }}");'></div>
            <div class="absolute inset-0 bg-gradient-to-br from-background-dark/95 via-background-dark/80 to-primary/20"></div>
            
            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="bg-primary/20 p-2 rounded-lg">
                        <span class="material-symbols-outlined text-primary text-2xl">menu_book</span>
                    </div>
                    <span class="text-white font-bold tracking-wider text-lg pku-glow-text">Digilib PKU</span>
                </div>

                <!-- Hero Content -->
                <div class="space-y-6">
                    <h1 class="text-5xl font-bold text-white leading-tight">
                        Akses Pengetahuan <span class="text-primary">Medis Terdepan</span>
                    </h1>
                    <p class="text-white/70 text-base max-w-lg leading-relaxed">
                        Platform perpustakaan digital modern yang dirancang khusus untuk profesional kesehatan. Akses ribuan jurnal medis, panduan klinis, dan literatur penelitian terkini.
                    </p>
                    
                </div>

                <!-- Footer Stats -->
                <div class="flex gap-8 pt-6 border-t border-white/10">
                    <div>
                        <p class="text-2xl font-bold text-primary">200+</p>
                        <p class="text-xs text-white/60 uppercase tracking-wide">Tenaga Medis Aktif</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-primary">15K+</p>
                        <p class="text-xs text-white/60 uppercase tracking-wide">Dokumen Diakses</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-primary">98%</p>
                        <p class="text-xs text-white/60 uppercase tracking-wide">Kepuasan Pengguna</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="w-full lg:w-2/5 flex items-center justify-center px-6 sm:px-8 py-8 lg:py-0 bg-background-light dark:bg-background-dark lg:overflow-y-auto">
            <div class="w-full max-w-sm">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 flex items-center gap-2">
                    <div class="bg-primary/10 p-2 rounded-lg">
                        <span class="material-symbols-outlined text-primary">menu_book</span>
                    </div>
                    <span class="font-bold tracking-tight">Digilib RS PKU</span>
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Selamat Datang</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Masuk ke akun Anda untuk mengakses perpustakaan digital</p>
                </div>

                <!-- Login Form -->
                <form class="space-y-5" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email / NIP -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-white" for="email">Username / NIP</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">person</span>
                            <input 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all text-sm @error('email') border-red-500 @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="Masukkan NIP Anda" 
                                type="text" 
                                required 
                                autofocus
                            />
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-900 dark:text-white" for="password">Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">lock</span>
                            <input 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all text-sm" 
                                id="password" 
                                name="password"
                                placeholder="••••••••" 
                                type="password" 
                                required 
                                autocomplete="current-password"
                            />
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot Password -->
                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary cursor-pointer" type="checkbox" name="remember" />
                            <span class="text-slate-600 dark:text-slate-400 font-medium group-hover:text-slate-900 dark:group-hover:text-white transition-colors">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-primary hover:underline font-semibold" href="{{ route('password.request') }}">Lupa password?</a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-primary hover:bg-[#00773b] text-white font-bold py-3 rounded-lg shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all active:scale-[0.98] text-sm mt-6">
                        Masuk ke Akun
                    </button>
                </form>

                <!-- Footer -->
                <div class="mt-8 text-center text-xs text-slate-500 dark:text-slate-400">
                    <p>© 2026 RS PKU Aisyiyah Boyolali</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>