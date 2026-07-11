<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#0f172a">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'LMS Bimbel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('Logo.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('Logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

<body class="min-h-screen bg-[#F0F4F8] font-sans selection:bg-fuchsia-100 overflow-x-hidden text-slate-900 relative"
    style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">

    <!-- Moving Blobs Background -->
    <div class="fixed inset-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-violet-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-fuchsia-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-amber-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000">
        </div>
    </div>

    <div class="min-h-screen flex overflow-hidden relative z-10" x-data="{ sidebarOpen: false }">

        <!-- SIDEBAR -->
        <aside
            class="-translate-x-full md:translate-x-0 fixed inset-y-0 left-0 z-50 w-72 bg-white/70 backdrop-blur-xl border-r border-white/60 p-6 flex flex-col transition-transform duration-300 shadow-[4px_0_24px_-12px_rgba(0,0,0,0.1)] overflow-hidden"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
            <div class="flex items-center gap-3 mb-10 px-2 flex-shrink-0">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center shadow-lg shadow-violet-500/20 overflow-hidden p-1.5 transform hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('Logo.png') }}" alt="Rumba Athaya" class="w-8 h-8 object-contain"
                        onerror="this.src='/Logo.png'">
                </div>
                <span class="text-xl font-extrabold text-slate-800 tracking-tight">Admin<span
                        class="text-fuchsia-500">.</span></span>
            </div>

            <nav class="space-y-2 flex-1 min-h-0 overflow-y-auto pr-2 -mr-2 custom-scrollbar">
                @include('components.navigation.admin-menu')
            </nav>

            <!-- System Health Card -->
            <div
                class="mt-auto relative overflow-hidden rounded-[1.5rem] bg-gradient-to-br from-violet-500 to-fuchsia-600 p-5 text-white mb-6 flex-shrink-0 shadow-lg shadow-violet-500/20 group hover:scale-[1.02] transition-transform duration-300">
                <div
                    class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full blur-[40px] opacity-50 -mr-10 -mt-10">
                </div>
                <div class="relative z-10">
                    <i
                        class="ph-fill ph-shield-check text-xl text-yellow-300 mb-2 group-hover:rotate-12 transition-transform duration-300 inline-block"></i>
                    <h4 class="font-bold text-sm mb-1">System Health</h4>
                    <p class="text-xs text-violet-100 mb-3">100% Optimal</p>
                    <div class="w-full h-2 bg-white/20 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-300 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <!-- User Profile -->
            <div class="flex items-center gap-3 pt-6 border-t border-slate-200/60 flex-shrink-0">
                <div
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold text-sm shadow-md shadow-orange-500/20">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] font-medium text-slate-500 uppercase tracking-wide">Administrator</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="p-2 hover:bg-rose-50 text-slate-400 hover:text-rose-600 rounded-xl transition-all duration-300 group"
                        title="Logout">
                        <i class="ph-bold ph-sign-out text-lg group-hover:scale-110 transition-transform"></i>
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
        <div class="flex-1 flex flex-col min-w-0 md:pl-72 transition-all duration-300">
            <!-- Mobile Header -->
            <header
                class="md:hidden h-16 bg-white/70 backdrop-blur-md border-b border-white/60 px-4 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true"
                        class="p-2 -ml-2 text-slate-600 hover:text-violet-600 transition-colors">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                    <span class="font-bold text-slate-800">Admin Dashboard</span>
                </div>
                <div
                    class="w-8 h-8 rounded-full overflow-hidden border border-white/50 shadow-sm cursor-pointer bg-fuchsia-100">
                    <div
                        class="w-full h-full bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center text-white font-bold text-xs">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="h-full overflow-y-auto mobile-content-wrapper pb-20">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Mobile Bottom Navigation Bar (Visible on mobile, hidden on desktop) -->
    @php $currentRoute = request()->route()->getName() ?? ''; @endphp
    <nav class="mobile-bottom-nav md:hidden">
        <a href="{{ route('admin.dashboard') }}"
            class="mobile-bottom-nav-item {{ str_starts_with($currentRoute, 'admin.dashboard') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="ph {{ str_starts_with($currentRoute, 'admin.dashboard') ? 'ph-fill' : '' }} ph-chart-bar"></i>
            </div>
            <span class="nav-label">Beranda</span>
        </a>
        <a href="{{ route('admin.students.index') }}"
            class="mobile-bottom-nav-item {{ str_starts_with($currentRoute, 'admin.students') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="ph {{ str_starts_with($currentRoute, 'admin.students') ? 'ph-fill' : '' }} ph-users"></i>
            </div>
            <span class="nav-label">Siswa</span>
        </a>
        <a href="{{ route('admin.attendances.index') }}"
            class="mobile-bottom-nav-item {{ str_starts_with($currentRoute, 'admin.attendances') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="ph {{ str_starts_with($currentRoute, 'admin.attendances') ? 'ph-fill' : '' }} ph-clipboard-text"></i>
            </div>
            <span class="nav-label">Absensi</span>
        </a>
        <a href="{{ route('admin.schedules.index') }}"
            class="mobile-bottom-nav-item {{ str_starts_with($currentRoute, 'admin.schedules') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="ph {{ str_starts_with($currentRoute, 'admin.schedules') ? 'ph-fill' : '' }} ph-calendar"></i>
            </div>
            <span class="nav-label">Jadwal</span>
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