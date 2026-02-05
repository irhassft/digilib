<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ $title ?? 'RS PKU Digital Library' }}</title>
    
    {{-- PLUGINS --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    {{-- LARAVEL VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    {{-- ALPINE JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

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
                        "display": ["Lexend", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Lexend', sans-serif;
            /* Hide scrollbar for Chrome, Safari and Opera */
            ::-webkit-scrollbar {
                display: none;
            }
            /* Hide scrollbar for IE, Edge and Firefox */
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
    
    {{ $head ?? '' }}
</head>
<body class="bg-background-light dark:bg-background-dark text-[#0d1b11] dark:text-white min-h-screen">
    <x-sidebar>
        <!-- Main Content -->
        <main class="flex-1 min-h-screen relative flex flex-col overflow-hidden">
            
            <!-- Header (Optional Slot) - Visible on all screen sizes -->
            @if(isset($header))
                <header class="sticky top-0 z-30 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-4 sm:px-6 lg:px-8 py-4 border-b border-gray-200 dark:border-gray-800">
                    {{ $header }}
                </header>
            @endif

            <!-- Main Page Content - Scrollable -->
            <div class="flex-1 overflow-y-auto {{ $padding ?? 'px-4 sm:px-6 lg:px-8 py-8' }}">
                {{ $slot }}
            </div>
            
        </main>
    </x-sidebar>
    
    {{ $scripts ?? '' }}
</body>
</html>
