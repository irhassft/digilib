<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Onboarding &amp; Welcome - Digilib RS PKU</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec49",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102215",
                    },
                    fontFamily: {
                        "display": ["Lexend"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            font-family: 'Lexend', sans-serif;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#0d1b11] dark:text-white antialiased">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <!-- TopNavBar Component -->
            <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e7f3ea] dark:border-b-[#1a2e1e] px-10 py-3 bg-white dark:bg-background-dark">
                <div class="flex items-center gap-4 text-[#0d1b11] dark:text-white">
                    <div class="size-8 text-primary">
                        <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" d="M24 18.4228L42 11.475V34.3663C42 34.7796 41.7457 35.1504 41.3601 35.2992L24 42V18.4228Z" fill="currentColor" fill-rule="evenodd"></path>
                            <path clip-rule="evenodd" d="M24 8.18819L33.4123 11.574L24 15.2071L14.5877 11.574L24 8.18819ZM9 15.8487L21 20.4805V37.6263L9 32.9945V15.8487ZM27 37.6263V20.4805L39 15.8487V32.9945L27 37.6263ZM25.354 2.29885C24.4788 1.98402 23.5212 1.98402 22.646 2.29885L4.98454 8.65208C3.7939 9.08038 3 10.2097 3 11.475V34.3663C3 36.0196 4.01719 37.5026 5.55962 38.098L22.9197 44.7987C23.6149 45.0671 24.3851 45.0671 25.0803 44.7987L42.4404 38.098C43.9828 37.5026 45 36.0196 45 34.3663V11.475C45 10.2097 44.2061 9.08038 43.0155 8.65208L25.354 2.29885Z" fill="currentColor" fill-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold leading-tight tracking-[-0.015em]">Digilib RS PKU</h2>
                </div>
                <div class="flex flex-1 justify-end gap-8">
                    <div class="flex items-center gap-9">
                        <a class="text-[#0d1b11] dark:text-white text-sm font-medium leading-normal" href="#">About</a>
                        <a class="text-[#0d1b11] dark:text-white text-sm font-medium leading-normal" href="#">Help</a>
                    </div>
                    <a href="{{ route('login') }}" class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-[#0d1b11] text-sm font-bold leading-normal tracking-[0.015em]">
                        <span class="truncate">Login</span>
                    </a>
                </div>
            </header>
            
            <main class="flex-1 flex flex-col items-center py-12 px-4 md:px-20 lg:px-40">
                <!-- Hero Section -->
                <div class="max-w-[1200px] w-full bg-white dark:bg-[#152a1a] rounded-xl shadow-xl overflow-hidden mb-10 flex flex-col md:flex-row">
                    <!-- Hero Image -->
                    <div class="md:w-1/2 p-1 bg-gradient-to-br from-primary/10 to-transparent">
                        <div class="w-full h-[300px] md:h-full bg-center bg-no-repeat bg-cover rounded-lg" data-alt="Modern hospital library interior" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBQ_MAa1tWen910LOcv60KucuwMOwhIU5pdZD21jBTg6M2_af9o7tdW6Uc_E-mm6QFbz4biETefX72YJIzC9xwhzNx1Uqkm5FaRXtkUAYknDSEpq16BHnETGSziN-oxQfuA53cMU06soIoNHaU-xYX4aywWvnO3rg3P2wwY590mafDNd6CHBvFPG13sAxu0q4kDk7FYQthdZrsc89bG-6iNcA6_61OTeQ1PAadq30ILRcRJTXmYBRHfOC3y0hgZXpaBMpFHEV8aLxU");'></div>
                    </div>
                    
                    <!-- Hero Content with Search -->
                    <div class="md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
                        <span class="text-primary font-bold tracking-widest text-xs uppercase mb-4">Official Archives</span>
                        <h1 class="text-4xl font-bold leading-tight text-[#0d1b11] dark:text-white mb-4">Welcome to Digilib RS PKU</h1>
                        <p class="text-[#4c9a5f] dark:text-primary/70 text-lg leading-relaxed mb-6">
                            The central knowledge hub for medical personnel at RS PKU Aisyiyah Boyolali.
                        </p>

                        <!-- SEARCH FORM (INTEGRATED) -->
                        <form action="{{ route('login') }}" method="GET" class="w-full relative">
                             <div class="relative flex items-center">
                                <span class="absolute left-4 text-[#4c9a5f]">
                                    <span class="material-symbols-outlined">search</span>
                                </span>
                                <input type="text" name="search_trigger"
                                    class="w-full h-14 pl-12 pr-32 rounded-lg border-2 border-[#e7f3ea] dark:border-[#1a2e1e] bg-white dark:bg-[#0d1b11] text-[#0d1b11] dark:text-white focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-all shadow-sm"
                                    placeholder="Search documents...">
                                <button type="submit" class="absolute right-2 h-10 px-6 bg-primary hover:bg-opacity-90 text-[#0d1b11] font-bold rounded-md transition-colors">
                                    Search
                                </button>
                             </div>
                        </form>
                    </div>
                </div>

                <!-- Latest Documents Grid -->
                <div class="w-full max-w-[1200px] mb-6">
                     <h3 class="text-xl font-bold text-[#0d1b11] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">history</span>
                        Recent Uploads
                     </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-[1200px]">
                    @forelse($documents as $doc)
                    <div class="flex flex-col gap-4 rounded-xl bg-white dark:bg-[#152a1a] p-5 shadow-sm hover:shadow-md transition-shadow border border-[#e7f3ea] dark:border-[#22442a] group">
                        <!-- Placeholder or Gradient for File -->
                        <div class="w-full aspect-[2/1] bg-gradient-to-br from-[#e7f3ea] to-white dark:from-[#1a2e1e] dark:to-[#0d1b11] rounded-lg flex items-center justify-center relative overflow-hidden">
                             <span class="material-symbols-outlined text-6xl text-primary/40 group-hover:scale-110 transition-transform">description</span>
                             
                             <!-- Category Badge -->
                             <span class="absolute top-2 right-2 px-2 py-1 text-[10px] uppercase font-bold text-[#0d1b11] bg-primary rounded-md">
                                {{ $doc->category->name ?? 'DOC' }}
                             </span>
                        </div>

                        <div class="flex flex-col flex-1 justify-between gap-2">
                            <div>
                                <h4 class="text-[#0d1b11] dark:text-white text-lg font-bold leading-tight line-clamp-2" title="{{ $doc->title }}">
                                    {{ $doc->title }}
                                </h4>
                                <div class="flex items-center gap-2 mt-2">
                                     <div class="size-6 rounded-full bg-primary/20 flex items-center justify-center text-xs font-bold text-primary">
                                        {{ substr($doc->uploader->name ?? 'A', 0, 1) }}
                                     </div>
                                     <p class="text-[#4c9a5f] dark:text-primary/70 text-sm font-normal">{{ $doc->uploader->name ?? 'Admin' }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">{{ $doc->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-12 text-gray-500">
                        No documents found.
                    </div>
                    @endforelse
                </div>

                <!-- Get Started Final Button (Bottom) -->
                <div class="flex justify-center w-full max-w-[480px] mt-12">
                    <a href="{{ route('login') }}" class="flex min-w-[200px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-8 bg-primary text-[#0d1b11] text-lg font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        <span class="truncate">Login to Portal</span>
                    </a>
                </div>
            </main>

            <!-- Footer Component -->
            <footer class="flex flex-col gap-6 px-40 py-10 text-center @container border-t border-[#e7f3ea] dark:border-t-[#1a2e1e] mt-auto">
                <div class="flex flex-wrap items-center justify-center gap-6 @[480px]:flex-row @[480px]:justify-around">
                    <a class="text-[#4c9a5f] dark:text-primary/60 text-base font-normal leading-normal min-w-40 hover:text-primary" href="#">Privacy Policy</a>
                    <a class="text-[#4c9a5f] dark:text-primary/60 text-base font-normal leading-normal min-w-40 hover:text-primary" href="#">Terms of Service</a>
                    <a class="text-[#4c9a5f] dark:text-primary/60 text-base font-normal leading-normal min-w-40 hover:text-primary" href="#">Hospital Directory</a>
                </div>
                <div class="flex justify-center gap-4 mb-2">
                    <span class="material-symbols-outlined text-primary">local_hospital</span>
                    <p class="text-[#4c9a5f] dark:text-primary/60 text-base font-normal leading-normal">© {{ date('Y') }} RS PKU Hospital Digital Library. All medical content verified.</p>
                </div>
            </footer>
        </div>
    </div>
</body>
</html>