<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="@yield('description', 'Bimbel Rumba Athaya - Belajar Asyik, Prestasi Terbaik. Program bimbingan belajar untuk TK, SD, dan SMP dengan metode pembelajaran yang menyenangkan.')">
    <meta name="keywords"
        content="bimbel, les privat, bimbingan belajar, rumba athaya, calistung, tahfidz, SD, SMP, TK">
    <meta name="author" content="Rumba Athaya">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Beranda') - {{ config('app.name', 'Rumba Athaya') }}">
    <meta property="og:description"
        content="@yield('description', 'Bimbel Rumba Athaya - Belajar Asyik, Prestasi Terbaik. Program bimbingan belajar untuk TK, SD, dan SMP.')">
    <meta property="og:image" content="@yield('og_image', asset('Logo.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="{{ config('app.name', 'Rumba Athaya') }}">
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('title', 'Beranda') - {{ config('app.name', 'Rumba Athaya') }}">
    <meta name="twitter:description"
        content="@yield('description', 'Bimbel Rumba Athaya - Belajar Asyik, Prestasi Terbaik')">
    <meta name="twitter:image" content="@yield('og_image', asset('Logo.png'))">

    <!-- Additional Meta Tags -->
    @yield('meta')

    <title>@yield('title', 'Beranda') - {{ config('app.name', 'Rumba Athaya') }}</title>

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
</head>

<body class="min-h-screen bg-[#F8FAFC] font-sans selection:bg-orange-100 overflow-x-hidden text-slate-900"
    style="font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;">
    <!-- Ambient Background -->
    <x-ambient-background />

    <!-- Content Wrapper (Navbar + Main Content + Footer) -->
    <div class="relative z-10">
        <!-- Navbar -->
        <x-navbar />

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 text-white pt-12 sm:pt-16 pb-6 sm:pb-8 border-t-4 border-brand-orange">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10 md:gap-12 mb-8 sm:mb-10 md:mb-12">
                    <div class="col-span-1 md:col-span-2">
                        <h2 class="text-2xl font-bold mb-4">Rumba Athaya</h2>
                        <p class="text-gray-400 leading-relaxed max-w-sm">
                            Bimbingan belajar dengan konsep "Belajar Asyik, Prestasi Terbaik". Membantu siswa meraih
                            potensi akademik maksimal dengan suasana kekeluargaan.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-bold text-lg mb-4 text-brand-orange">Program</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li>
                                <a href="{{ route('home') }}#calistung-tk" class="hover:text-white transition">
                                    Calistung TK
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}#calistung-sd" class="hover:text-white transition">
                                    SD Juara
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}#kelas-7-9-smp" class="hover:text-white transition">
                                    SMP Favorit
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}#tahfidz" class="hover:text-white transition">
                                    Kelas Tahfidz
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-bold text-lg mb-4 text-brand-orange">Kontak</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li class="flex items-center gap-2">
                                <i class="ph ph-whatsapp-logo"></i>
                                <a href="https://wa.me/6282313509532" target="_blank" rel="noopener noreferrer"
                                    class="hover:text-white transition">
                                    +6282-3135-09532
                                </a>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="ph ph-instagram-logo"></i>
                                <a href="https://linktr.ee/RumbaAthaya" target="_blank" rel="noopener noreferrer"
                                    class="hover:text-white transition">
                                    @hidayah.irfan
                                </a>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="ph ph-map-pin"></i>
                                <a href="/kontak" class="hover:text-white transition">
                                    Lihat Alamat
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} Rumba Athaya. Developed by TEPE.GRAFI
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts

    <!-- Mobile Browser App Promo Pop-up -->
    <div id="mobile-app-popup" class="fixed bottom-4 left-4 right-4 z-[9999] bg-slate-900 border border-slate-800 text-white p-4 rounded-2xl shadow-2xl flex items-center justify-between gap-4 transition-all duration-300 translate-y-32 opacity-0 md:hidden">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center p-2 shadow-lg shadow-orange-500/20 flex-shrink-0">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-8 h-8 object-contain" onerror="this.style.display='none'">
            </div>
            <div>
                <h4 class="font-extrabold text-sm leading-tight text-white">Gunakan Aplikasi HP</h4>
                <p class="text-[10px] text-slate-400 mt-0.5 leading-none">Belajar lebih cepat & asyik di Android</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="dismissMobileAppPopup()" class="px-2.5 py-2 text-slate-500 hover:text-white text-xs font-bold transition-colors">Nanti</button>
            <a href="{{ route('download') }}" class="px-3.5 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-xs font-bold rounded-xl shadow-md shadow-orange-500/20 flex items-center gap-1">
                Unduh
            </a>
        </div>
    </div>

    <script>
        function dismissMobileAppPopup() {
            const popup = document.getElementById('mobile-app-popup');
            if (popup) {
                popup.style.transform = 'translateY(150px)';
                popup.style.opacity = '0';
                localStorage.setItem('mobile_app_promo_dismissed', 'true');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const isMobileDevice = /Android|iPhone|iPad|iPod/i.test(navigator.userAgent) || window.innerWidth < 768;
            const isDismissed = localStorage.getItem('mobile_app_promo_dismissed') === 'true';
            
            // Check if not running inside Capacitor (native webview) already
            const isNativeApp = typeof window.Capacitor !== 'undefined' || window.location.search.includes('platform=android');

            if (isMobileDevice && !isDismissed && !isNativeApp) {
                setTimeout(() => {
                    const popup = document.getElementById('mobile-app-popup');
                    if (popup) {
                        popup.classList.remove('translate-y-32', 'opacity-0');
                        popup.classList.add('translate-y-0', 'opacity-100');
                    }
                }, 3000);
            }
        });
    </script>

    <!-- Chatbot Widget -->
    <x-chatbot-widget />

    @stack('scripts')
</body>

</html>