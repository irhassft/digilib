<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Atur Ulang Kata Sandi - Digital Library RS PKU Aisyiyah Boyolali</title>
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
                <div class="flex items-center gap-4">
                    <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="h-12 w-auto">
                    <div class="flex flex-col">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-tight">Digital Library</h3>
                        <p class="text-xs font-medium text-primary uppercase tracking-wider">RS PKU Aisyiyah Boyolali</p>
                    </div>
                </div>

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
                <div class="lg:hidden mb-8 flex items-center gap-3">
                    <img src="{{ asset('img/logo-rspku.png') }}" alt="Logo RS PKU" class="h-8 w-auto">
                    <div class="flex flex-col">
                        <p class="text-sm font-bold text-slate-900 leading-tight">Digital Library</p>
                        <p class="text-xs font-medium text-primary uppercase tracking-wider">RS PKU Aisyiyah</p>
                    </div>
                </div>

                <!-- Icon & Header -->
                <div class="mb-8 text-center">
                    <div class="inline-flex p-3 bg-primary/10 rounded-full mb-4">
                        <span class="material-symbols-outlined text-primary text-3xl">lock</span>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">Buat Kata Sandi Baru</h2>
                    <p class="text-sm text-slate-600 leading-relaxed">Masukkan kata sandi baru Anda untuk mengamankan akun.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-700" for="email">Alamat Email</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">mail</span>
                            <input 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 bg-gray-50 cursor-not-allowed text-sm text-slate-800 @error('email') border-red-500 @enderror" 
                                id="email" 
                                type="email" 
                                name="email" 
                                value="{{ old('email', $request->email) }}"
                                required 
                                autofocus 
                                autocomplete="username"
                                disabled
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
                        <label class="block text-sm font-semibold mb-2 text-slate-700" for="password">Kata Sandi Baru</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">lock</span>
                            <input 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm text-slate-800 @error('password') border-red-500 @enderror" 
                                id="password" 
                                type="password" 
                                name="password" 
                                placeholder="Minimal 8 karakter"
                                required 
                                autocomplete="new-password"
                            />
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-semibold mb-2 text-slate-700" for="password_confirmation">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">lock_check</span>
                            <input 
                                class="w-full pl-10 pr-4 py-3 rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm text-slate-800 @error('password_confirmation') border-red-500 @enderror" 
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation" 
                                placeholder="Ulangi kata sandi baru"
                                required 
                                autocomplete="new-password"
                            />
                        </div>
                        @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">error</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Requirements -->
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <p class="text-xs font-semibold text-blue-700 dark:text-blue-300 mb-2">Persyaratan Kata Sandi:</p>
                        <ul class="space-y-1 text-xs text-blue-600 dark:text-blue-400">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">check</span>
                                Minimal 8 karakter
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">check</span>
                                Kombinasi huruf besar dan kecil
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">check</span>
                                Setidaknya satu angka
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 rounded-lg shadow-lg shadow-primary/20 hover:shadow-primary/30 transition-all active:scale-[0.98] text-sm mt-6 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">done</span>
                        Atur Ulang Kata Sandi
                    </button>
                </form>

                <!-- Back to Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-slate-600">
                        Kembali ke halaman 
                        <a href="{{ route('login') }}" class="text-primary hover:underline font-semibold">masuk</a>
                    </p>
                </div>

                <div class="mt-8 text-center text-xs text-slate-400">
                    © {{ date('Y') }} RS PKU Aisyiyah Boyolali. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
