<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Welcome') - {{ config('app.name', 'Rumba Athaya') }}</title>
    <link rel="icon" href="{{ asset('Logo.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- Phosphor Icons (Local) -->
    <script src="{{ asset('phosphor-icons/loader.js') }}" defer></script>
</head>

<body class="min-h-screen font-sans antialiased text-slate-900 bg-white"
    style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
    <!-- Splash Screen (shown while page loads on mobile) -->
    <div id="app-splash" class="md:hidden">
        <img src="{{ asset('Logo.png') }}" alt="Logo" class="splash-logo" onerror="this.style.display='none'">
        <div class="splash-title">Rumba Athaya</div>
        <div class="splash-subtitle">Learning Management System</div>
        <div class="splash-spinner"></div>
    </div>

    <!-- Ambient Background with Animated Blobs & Noise -->
    <x-ambient-background />

    <!-- Noise Overlay -->
    <div class="fixed inset-0 z-0 pointer-events-none opacity-[0.015]"
        style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 400 400\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E'); background-size: 200px 200px;">
    </div>

    <!-- Content Wrapper (Navbar + Main Content) -->
    <div class="relative z-10">
        <!-- Sticky Glass Navbar -->
        <x-navbar />

        <!-- Main Content -->
        <main>
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>