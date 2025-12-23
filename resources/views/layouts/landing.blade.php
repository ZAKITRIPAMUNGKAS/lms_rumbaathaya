<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - {{ config('app.name', 'Rumba Athaya') }}</title>
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
                                <a href="https://wa.me/62812345678" target="_blank" rel="noopener noreferrer"
                                    class="hover:text-white transition">
                                    +62 812-3456-7890
                                </a>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="ph ph-instagram-logo"></i>
                                <a href="https://linktr.ee/RumbaAthaya" target="_blank" rel="noopener noreferrer"
                                    class="hover:text-white transition">
                                    @rumba.athaya
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

    <!-- Chatbot Widget -->
    <x-chatbot-widget />

    @stack('scripts')
</body>

</html>