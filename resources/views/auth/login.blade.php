<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login SSO - RS PKU Digital Library</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
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
        body {
            font-family: 'Lexend', sans-serif;
        }
        .bg-medical-pattern {
            background-color: #f6f8f6;
            background-image: radial-gradient(#13ec49 0.5px, transparent 0.5px);
            background-size: 24px 24px;
        }
        .dark .bg-medical-pattern {
            background-color: #102215;
            background-image: radial-gradient(#13ec49 0.2px, transparent 0.2px);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#0d1b11] dark:text-white min-h-screen flex flex-col">
    <!-- Top Navigation Bar -->
    <header class="w-full flex items-center justify-between border-b border-solid border-[#e7f3ea] dark:border-[#22442a] px-6 py-3 bg-white dark:bg-[#152a1b]">
        <div class="flex items-center gap-4">
            <div class="size-8 text-primary">
                {{-- Logo SVG --}}
                <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z" fill="currentColor" fill-rule="evenodd"></path>
                </svg>
            </div>
            <h2 class="text-lg font-bold leading-tight tracking-tight">PKU Digital Library</h2>
        </div>
        <button class="flex min-w-[84px] cursor-pointer items-center justify-center rounded-lg h-10 px-4 bg-primary text-[#0d1b11] text-sm font-bold leading-normal">
            <span>IT Support</span>
        </button>
    </header>

    <main class="flex-grow flex items-center justify-center p-6 bg-medical-pattern">
        <div class="max-w-[1000px] w-full grid grid-cols-1 md:grid-cols-2 bg-white dark:bg-[#152a1b] rounded-xl shadow-2xl overflow-hidden border border-[#e7f3ea] dark:border-[#22442a]">
            
            <!-- Left Side: Branding & Image -->
            <div class="hidden md:flex flex-col justify-between p-10 bg-[#f0f9f2] dark:bg-[#1c3524]">
                <div>
                    <div class="flex items-center gap-2 mb-6">
                        <span class="material-symbols-outlined text-primary text-4xl">local_library</span>
                        <h1 class="text-2xl font-black text-[#0d1b11] dark:text-white">PKU Digital Library</h1>
                    </div>
                    <div class="space-y-4">
                        <p class="text-3xl font-black leading-tight text-[#0d1b11] dark:text-white">Knowledge at your fingertips.</p>
                        <p class="text-[#4c9a5f] text-lg">Access medical journals, latest research papers, and hospital internal documents instantly.</p>
                    </div>
                </div>
                <div class="rounded-lg overflow-hidden border-2 border-primary/20">
                    <div class="w-full h-48 bg-center bg-cover" data-alt="Modern medical library interior with clean white shelves" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAMQa1bEje3HAM7R4YxDxeBplPs1D37AFBh3en0vaTep21M-V7_tZY4GfKAaHLjSXrEm5jJ9qzeohRowm6_OK31ZI9U9tvcFd217z6VXxm9hp2IZjbXkhtenN-WSkslaw4LGMeGXwnFDsr66AfvJH-KB73Csrre9j9ikmGDBD4d3uPthAvSir1wuCDA3QsS9FrppnBCOd_R23WeazF7juHDe9sed08mLejawT-qN9cF07pnB-cptRQOVI7Q-0KdxQrVgVJlqxUI434");'></div>
                </div>
                <p class="text-xs text-[#4c9a5f]/80 italic">Supporting excellence in healthcare education since 2026.</p>
            </div>

            <!-- Right Side: Login Form -->
            <div class="p-8 md:p-12 flex flex-col justify-center">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-2">Welcome Back</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Please authenticate to access the digital archives.</p>
                </div>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                    </div>
            
                </div>

                <!-- Manual Login Form -->
                <form class="space-y-4" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email / NIP -->
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-[#0d1b11] dark:text-gray-300" for="email">Email / Username</label>
                        <input 
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-[#0d1b11] focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all @error('email') border-red-500 @enderror" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="Enter your Email / username" 
                            type="text" 
                            required 
                            autofocus
                        />
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-[#0d1b11] dark:text-gray-300" for="password">Password</label>
                        <input 
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-[#0d1b11] focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all" 
                            id="password" 
                            name="password"
                            placeholder="••••••••" 
                            type="password" 
                            required 
                            autocomplete="current-password"
                        />
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input class="rounded border-gray-300 text-primary focus:ring-primary" type="checkbox" name="remember" />
                            <span>Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-primary font-semibold hover:underline" href="{{ route('password.request') }}">Forgot password?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-[#0d1b11] dark:bg-primary dark:text-[#0d1b11] text-white font-bold py-4 rounded-lg hover:opacity-90 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Login to Portal
                    </button>
                    
                    <div class="text-center mt-4">
                        <a href="{{ url('/') }}" class="text-xs text-gray-500 hover:text-gray-800 underline">Back to Landing Page</a>
                    </div>
                </form>

                <!-- Disclaimer Footer -->
                <div class="mt-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg flex gap-3">
                    <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-500 flex-shrink-0">gpp_maybe</span>
                    <p class="text-[11px] leading-relaxed text-yellow-800 dark:text-yellow-400">
                        <strong>ATTENTION:</strong> This system is for authorized RS PKU Aisyiyah Boyolali personnel only. Unauthorized access is strictly prohibited.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <footer class="w-full py-6 text-center text-sm text-gray-500 dark:text-gray-400 border-t border-[#e7f3ea] dark:border-[#22442a]">
        <div class="flex justify-center gap-6 mb-2">
            <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
            <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
            <a class="hover:text-primary transition-colors" href="#">Help Center</a>
        </div>
        <p>&copy; {{ date('Y') }} RS PKU Hospital. All rights reserved.</p>
    </footer>
</body>
</html>