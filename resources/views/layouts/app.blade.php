<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LMS Bimbel') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('Logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('Logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Phosphor Icons (Local) -->
    <script src="{{ asset('phosphor-icons/loader.js') }}" defer></script>

    @livewireScripts
</head>

<body class="min-h-screen bg-[#F8FAFC] font-sans antialiased text-slate-900"
    style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
    <!-- Ambient Background with Animated Blobs & Noise -->
    <x-ambient-background />

    <!-- Noise Overlay -->
    <div class="fixed inset-0 z-0 pointer-events-none opacity-[0.015]"
        style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 400 400\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E'); background-size: 200px 200px;">
    </div>

    <div class="min-h-screen flex relative z-10">
        <!-- Sidebar -->
        <aside class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64">
                <div class="flex flex-col flex-grow glass-card m-4 p-6 relative z-10">
                    <!-- Logo -->
                    <div class="flex items-center gap-3 mb-8">
                        <div
                            class="w-10 h-10 rounded-lg bg-brand-orange flex items-center justify-center flex-shrink-0 overflow-hidden">
                            <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-8 h-8 object-contain"
                                onerror="this.onerror=null; this.src='{{ asset('LogoNavbar.png') }}';">
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-slate-800">Rumba Athaya</h1>
                            <p class="text-xs text-slate-500">Learning Management</p>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 space-y-2">
                        @if(auth()->check())
                            @if(auth()->user()->isAdmin())
                                @include('components.navigation.admin-menu')
                            @elseif(auth()->user()->isTutor())
                                @include('components.navigation.tutor-menu')
                            @elseif(auth()->user()->isStudent())
                                @include('components.navigation.student-menu')
                            @endif
                        @endif
                    </nav>

                    <!-- User Profile -->
                    @auth
                        <div class="mt-auto pt-6 border-t border-slate-200/50">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative z-10">
            <!-- Top Navbar -->
            <header class="glass-card mx-4 mt-4 mb-6 px-6 py-4 relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-sm text-slate-500 mt-1">@yield('page-description', 'Selamat datang kembali')</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <!-- Notifications -->
                        <button class="relative p-2 rounded-xl hover:bg-slate-100 transition-colors">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Mobile Menu Toggle -->
                        <button id="mobile-menu-toggle"
                            class="lg:hidden p-2 rounded-xl hover:bg-slate-100 transition-colors">
                            <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto px-4 pb-8 relative z-10">
                <!-- Toast Notifications -->
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-4 glass-card p-4 flex items-center gap-3 text-emerald-700 bg-emerald-50/50 border-emerald-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-4 glass-card p-4 flex items-center gap-3 text-red-700 bg-red-50/50 border-red-200">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="lg:hidden fixed inset-0 z-50 hidden" x-data="{ open: false }">
        <div class="fixed inset-0 bg-black/50"
            onclick="document.getElementById('mobile-sidebar').classList.add('hidden')"></div>
        <div class="fixed left-0 top-0 bottom-0 w-64 glass-card m-4 p-6 overflow-y-auto">
            <!-- Mobile menu content same as desktop -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-lg bg-brand-orange flex items-center justify-center flex-shrink-0 overflow-hidden">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-8 h-8 object-contain"
                            onerror="this.onerror=null; this.src='{{ asset('LogoNavbar.png') }}';">
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-slate-800">Rumba Athaya</h1>
                    </div>
                </div>
                <button onclick="document.getElementById('mobile-sidebar').classList.add('hidden')"
                    class="p-2 rounded-xl hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <nav class="space-y-2">
                @if(auth()->check())
                    @if(auth()->user()->isAdmin())
                        @include('components.navigation.admin-menu')
                    @elseif(auth()->user()->isTutor())
                        @include('components.navigation.tutor-menu')
                    @elseif(auth()->user()->isStudent())
                        @include('components.navigation.student-menu')
                    @endif
                @endif
            </nav>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-toggle')?.addEventListener('click', function () {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>

</html>