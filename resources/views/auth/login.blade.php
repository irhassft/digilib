<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Masuk - Digital Library RS PKU Aisyiyah Boyolali</title>
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
        body {
            font-family: 'Inter', sans-serif;
        }
        .white-gradient {
            background: linear-gradient(to right, rgba(255, 255, 255, 0.85) 35%, rgba(255, 255, 255, 0) 100%);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-100 antialiased overflow-x-hidden">
    <div class="relative flex min-h-screen w-full flex-col lg:flex-row">
        
        <div class="hidden lg:flex lg:w-3/5 relative bg-gradient-to-br from-primary/5 to-transparent dark:from-primary/10 dark:to-transparent overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center" style='background-image: url("{{ asset("img/background_1.jpg") }}");'></div>
            
            <div class="absolute inset-0 white-gradient"></div>
            
            <div class="relative z-10 flex flex-col justify-between p-12 w-full">
                <a href="{{ route('welcome') }}" aria-label="Kembali ke landing page" class="flex items-center gap-4">
                    <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="h-12 w-auto">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-tight">Digital Library</h3>
                        <p class="text-xs font-medium text-primary uppercase tracking-wider">RS PKU Aisyiyah Boyolali</p>
                    </div>
                </a>

                <div class="space-y-6">
                    <h1 class="text-5xl font-bold text-slate-900 leading-tight">
                        Akses Pengetahuan <br/>
                        <span class="text-primary">Medis Terdepan</span>
                    </h1>
                    <p class="text-slate-600 text-lg max-w-lg leading-relaxed font-medium">
                        Platform perpustakaan digital modern yang dirancang khusus untuk profesional kesehatan. Akses ribuan jurnal medis, panduan klinis, dan literatur penelitian terkini.
                    </p>
                </div>

                <div class="flex gap-8 pt-6 border-t border-slate-300">
                    <div>
                        <p class="text-2xl font-bold text-primary">200+</p>
                        <p class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Tenaga Medis Aktif</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-primary">15K+</p>
                        <p class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Dokumen Diakses</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-primary">98%</p>
                        <p class="text-xs text-slate-500 uppercase tracking-wide font-semibold">Kepuasan Pengguna</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-2/5 flex items-center justify-center px-6 sm:px-8 py-8 lg:py-0 bg-background-light dark:bg-background-dark lg:overflow-y-auto">
            <div class="w-full max-w-sm">
                <a href="{{ route('welcome') }}" aria-label="Kembali ke landing page" class="lg:hidden mb-8 flex items-center gap-3">
                    <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="h-8 w-auto">
                    <div class="flex flex-col">
                        <p class="text-sm font-bold text-slate-900 leading-tight">Digital Library</p>
                        <p class="text-xs font-medium text-primary uppercase tracking-wider">RS PKU Aisyiyah</p>
                    </div>
                </a>

                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">Selamat Datang</h2>
                    <p class="text-sm text-slate-500">Masuk ke akun Anda untuk mengakses perpustakaan digital</p>
                </div>

                <form class="space-y-5" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-700" for="email">Username</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">person</span>
                            <input 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm text-slate-800 @error('email') border-red-500 @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="Masukkan Username Anda" 
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

                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-700" for="password">Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">lock</span>
                            <input 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm text-slate-800" 
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

                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary cursor-pointer" type="checkbox" name="remember" />
                            <span class="text-slate-600 font-medium group-hover:text-primary transition-colors">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-primary hover:text-primary-hover hover:underline font-semibold" href="{{ route('password.request') }}">Lupa password?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 rounded-lg shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all active:scale-[0.98] text-sm mt-6">
                        Masuk ke Akun
                    </button>
                </form>

                <div class="mt-8 text-center text-xs text-slate-400">
                    © {{ date('Y') }} RS PKU Aisyiyah Boyolali. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>