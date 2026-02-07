<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Lupa Kata Sandi - Digital Library RS PKU Aisyiyah Boyolali</title>
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

        <div class="w-full lg:w-2/5 flex items-center justify-center bg-background-light dark:bg-background-dark">
            <div class="w-full max-w-sm p-8 md:p-12 bg-white dark:bg-slate-800 rounded-xl shadow-lg flex flex-col items-center justify-center">
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
                        <span class="material-symbols-outlined text-primary text-3xl">lock_reset</span>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Atur Ulang Kata Sandi</h2>
                    <p class="text-xl font-extrabold text-primary leading-relaxed">Hubungi Tim IT</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg flex items-start gap-3">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-lg flex-shrink-0 mt-0.5">check_circle</span>
                        <div>
                            <p class="text-sm font-semibold text-green-700 dark:text-green-300">{{ session('status') }}</p>
                            <p class="text-xs text-green-600 dark:text-green-400 mt-1">Silakan periksa email Anda untuk link reset kata sandi.</p>
                        </div>
                    </div>
                @endif



                <div class="mt-8 text-center text-sm">
                    <a href="{{ route('login') }}" class="text-primary hover:text-primary-dark font-semibold text-base flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        Kembali ke halaman masuk
                    </a>
                </div>

            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 p-4 text-center text-xs text-slate-400">
        © {{ date('Y') }} RS PKU Aisyiyah Boyolali. All rights reserved.
    </div>
</body>
</html>
