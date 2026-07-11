<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="LMS Rumba">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#F59E0B">

    <title>@yield('title', 'Student Dashboard') - {{ config('app.name', 'LMS Bimbel') }}</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('Logo.png') }}">
    <link rel="manifest" href="/manifest.json">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased text-slate-900 bg-[#F8FAFC]">
    <!-- Splash Screen (shown while page loads on mobile) -->
    <div id="app-splash" class="md:hidden">
        <img src="{{ asset('Logo.png') }}" alt="Logo" class="splash-logo" onerror="this.style.display='none'">
        <div class="splash-title">Rumba Athaya</div>
        <div class="splash-subtitle">Learning Management System</div>
        <div class="splash-spinner"></div>
    </div>

    <div class="min-h-screen flex overflow-hidden relative" x-data="{ sidebarOpen: false }">

        <!-- Ambient Background (Consolidated from views) -->
        <x-ambient-background />

        <!-- SIDEBAR -->
        <aside
            class="-translate-x-full md:translate-x-0 fixed inset-y-0 left-0 z-50 w-72 bg-white/80 backdrop-blur-xl border-r border-white/50 p-6 flex flex-col transition-transform duration-300 shadow-2xl md:shadow-none overflow-hidden"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            <!-- Logo Area -->
            <div class="flex items-center gap-3 mb-10 px-2 flex-shrink-0">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 overflow-hidden p-1.5">
                    <img src="{{ asset('Logo.png') }}" alt="Rumba Athaya" class="w-8 h-8 object-contain"
                        onerror="this.style.display='none'">
                </div>
                <span class="text-xl font-extrabold text-slate-800 tracking-tight">Rumba<span
                        class="text-orange-500">.</span></span>
            </div>

            <!-- Navigation -->
            <nav class="space-y-2 flex-1 min-h-0 overflow-y-auto pr-2 -mr-2 custom-scrollbar">
                @include('components.navigation.student-menu')
            </nav>

            <!-- Motivational Card -->
            <div
                class="mt-auto relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 p-5 text-white mb-6 flex-shrink-0">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full blur-[40px] opacity-50 -mr-10 -mt-10">
                </div>
                <div class="relative z-10">
                    <i class="ph ph-sparkle text-xl text-yellow-300 mb-2"></i>
                    <p class="text-sm font-bold mb-1 leading-relaxed">
                        "Setiap langkah kecil menuju kesuksesan dimulai dari hari ini."
                    </p>
                    <p class="text-xs text-indigo-100 mt-2">Tetap semangat belajar! 💪</p>
                </div>
            </div>

            <!-- User Profile -->
            <div class="flex items-center gap-3 pt-4 border-t border-slate-200 flex-shrink-0">
                <div
                    class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-sm border border-slate-200">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">Siswa Aktif</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="p-2 hover:bg-rose-50 text-slate-400 hover:text-rose-500 rounded-lg transition-colors">
                        <i class="ph ph-sign-out text-lg"></i>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Overlay for mobile sidebar -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/20 z-40 md:hidden backdrop-blur-sm" style="display: none;"></div>

        <!-- MAIN CONTENT WRAPPER -->
        <div class="flex-1 flex flex-col min-w-0 md:pl-72 transition-all duration-300 relative z-10">
            <!-- Mobile Header -->
            <header class="md:hidden bg-white/90 backdrop-blur-xl border-b border-slate-200/60 px-4 flex items-center justify-between sticky top-0 z-30 shadow-sm"
                style="height: calc(60px + env(safe-area-inset-top)); padding-top: env(safe-area-inset-top);">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true"
                        class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 text-slate-600 transition-colors">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-7 h-7 object-contain rounded-lg" onerror="this.style.display='none'">
                        <span class="font-extrabold text-slate-800 text-base tracking-tight">Rumba<span class="text-orange-500">.</span></span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-indigo-500/30">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="h-full overflow-y-auto w-full mobile-content-wrapper">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation Bar -->
    @php
        $currentRoute = request()->route()->getName() ?? '';
    @endphp
    <nav class="mobile-bottom-nav md:hidden">
        <a href="{{ route('student.dashboard') }}"
            class="mobile-bottom-nav-item {{ str_starts_with($currentRoute, 'student.dashboard') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="ph ph-squares-four {{ str_starts_with($currentRoute, 'student.dashboard') ? 'ph-fill' : '' }}"></i>
            </div>
            <span class="nav-label">Beranda</span>
        </a>
        <a href="{{ route('student.schedules.index') }}"
            class="mobile-bottom-nav-item {{ str_starts_with($currentRoute, 'student.schedules') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="ph ph-calendar-check {{ str_starts_with($currentRoute, 'student.schedules') ? 'ph-fill' : '' }}"></i>
            </div>
            <span class="nav-label">Jadwal</span>
        </a>
        <a href="{{ route('student.materials.index') }}"
            class="mobile-bottom-nav-item {{ str_starts_with($currentRoute, 'student.materials') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="ph ph-book-open-text {{ str_starts_with($currentRoute, 'student.materials') ? 'ph-fill' : '' }}"></i>
            </div>
            <span class="nav-label">Materi</span>
        </a>
        <a href="{{ route('student.achievements.index') }}"
            class="mobile-bottom-nav-item {{ str_starts_with($currentRoute, 'student.achievements') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="ph ph-trophy {{ str_starts_with($currentRoute, 'student.achievements') ? 'ph-fill' : '' }}"></i>
            </div>
            <span class="nav-label">Prestasi</span>
        </a>
        <a href="{{ route('student.settings.index') }}"
            class="mobile-bottom-nav-item {{ str_starts_with($currentRoute, 'student.settings') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="ph ph-gear {{ str_starts_with($currentRoute, 'student.settings') ? 'ph-fill' : '' }}"></i>
            </div>
            <span class="nav-label">Profil</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="mobile-bottom-nav-item p-0 min-h-0 flex flex-col items-center justify-center">
            @csrf
            <button type="submit" class="flex flex-col items-center justify-center gap-1 text-[#94a3b8] w-full h-full border-none bg-transparent outline-none cursor-pointer">
                <div class="nav-icon">
                    <i class="ph ph-sign-out"></i>
                </div>
                <span class="nav-label">Keluar</span>
            </button>
        </form>
    </nav>

    @stack('modals')
    @livewireScripts
    @stack('scripts')
</body>

</html>