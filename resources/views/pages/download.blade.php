@extends('layouts.landing')

@section('title', 'Unduh Aplikasi Mobile')

@section('content')
<div class="relative min-h-[calc(100vh-3.5rem)] flex items-center justify-center py-16 overflow-hidden bg-gradient-to-br from-slate-50 via-orange-50/30 to-indigo-50/30 text-slate-900">
    <!-- Ambient background glows -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-32 w-96 h-96 bg-gradient-to-br from-orange-400/15 to-amber-400/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-1/4 -right-32 w-[500px] h-[500px] bg-gradient-to-br from-indigo-400/15 to-purple-400/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <!-- Fine grid pattern overlay -->
    <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, #0f172a 1px, transparent 0); background-size: 32px 32px"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <!-- Left Column: Content & Download Options (Spans 7 columns on desktop) -->
            <div class="lg:col-span-7 text-center lg:text-left space-y-8" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <!-- Badge -->
                <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                     class="inline-flex items-center gap-2.5 px-4 py-2 bg-orange-50 border border-orange-100 rounded-full text-xs font-bold text-orange-600 shadow-sm shadow-orange-100/50">
                    <i class="ph ph-android-logo text-base"></i>
                    <span>KINI TERSEDIA UNTUK ANDROID</span>
                </div>

                <!-- Main Heading -->
                <div class="space-y-4">
                    <h1 x-show="show" x-transition:enter="transition ease-out duration-700 delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                        class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight text-slate-900">
                        Belajar Lebih Mudah <br/>
                        Dalam <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-600 to-amber-500">Satu Genggaman</span>
                    </h1>
                    <!-- Description -->
                    <p x-show="show" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                       class="text-slate-650 text-base sm:text-lg leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium">
                        Pantau jadwal belajar, unduh materi, absensi kelas, dan terima notifikasi langsung di handphone Android Anda kapan saja dan di mana saja.
                    </p>
                </div>

                <!-- Download Card Widget -->
                <div x-show="show" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-6 bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 max-w-2xl mx-auto lg:mx-0">
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <!-- Direct APK Link -->
                        <div class="flex-1 w-full">
                            <a href="/apps/rumba-athaya.apk" download
                               class="group flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-orange-500 via-orange-600 to-amber-500 text-white rounded-2xl font-bold hover:shadow-lg hover:shadow-orange-500/20 hover:-translate-y-0.5 transition-all duration-300 w-full">
                                <i class="ph ph-download-simple text-xl group-hover:animate-bounce"></i>
                                <div class="text-left">
                                    <span class="block text-[10px] font-semibold text-orange-200 uppercase tracking-wider">Unduh Langsung</span>
                                    <span class="block text-base font-extrabold leading-none mt-0.5">File APK Android</span>
                                </div>
                            </a>
                            <div class="flex justify-between text-[11px] text-slate-400 mt-3 px-1">
                                <span>Ukuran: ~103 MB</span>
                                <span>Versi: 1.0.0</span>
                                <span>Min Android: 8.0+</span>
                            </div>
                        </div>

                        <!-- Divider line on mobile, vertical line on desktop -->
                        <div class="w-full h-px bg-slate-100 sm:w-px sm:h-12 flex-shrink-0"></div>

                        <!-- QR Code Scanning -->
                        <div class="flex items-center gap-4 flex-shrink-0">
                            <div class="w-16 h-16 bg-slate-50 p-1.5 rounded-xl border border-slate-100 flex items-center justify-center">
                                <svg class="w-full h-full text-slate-800" viewBox="0 0 100 100" fill="currentColor">
                                    <path d="M0,0h40v40H0V0z M10,10v20h20V10H10z M60,0h40v40H60V0z M70,10v20h20V10H70z M0,60h40v40H0V60z M10,70v20h20V70H10z M50,50h10v10H50V50z M60,60h10v10H60V60z M70,50h10v10H70V50z M80,60h10v10H80V60z M50,70h10v10H50V70z M80,80h20v20H80V80z M60,90h20v10H60V90z" />
                                    <rect x="15" y="15" width="10" height="10" />
                                    <rect x="75" y="15" width="10" height="10" />
                                    <rect x="15" y="75" width="10" height="10" />
                                </svg>
                            </div>
                            <div class="text-left text-xs text-slate-500 max-w-[130px] leading-tight">
                                <span class="font-bold text-slate-800 block mb-0.5">Pindai Kode QR</span>
                                Arahkan kamera HP Anda untuk mengunduh instan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Phone Mockup (Spans 5 columns on desktop) -->
            <div class="lg:col-span-5 flex items-center justify-center"
                 x-data="{ activeScreen: 'login' }"
                 x-init="setInterval(() => { activeScreen = activeScreen === 'login' ? 'dashboard' : 'login' }, 5000)">
                
                <!-- Phone Mockup Container Wrapper with hardcoded dimensions to prevent collapse -->
                <div class="relative" style="width: 310px; height: 620px;">
                    <!-- Decorative glow ring behind the phone -->
                    <div class="absolute w-80 h-80 rounded-full bg-orange-500/10 blur-3xl opacity-70 -z-10 animate-pulse" style="top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>

                    <!-- Hardcoded CSS Phone Body Container -->
                    <div class="shadow-2xl" style="width: 300px; height: 610px; border: 12px solid #0f172a; border-radius: 3.2rem; background-color: #0f172a; position: relative; overflow: hidden; margin: 0 auto; box-sizing: border-box;">
                        
                        <!-- Notch / Speaker grill -->
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-slate-900 rounded-b-2xl z-50 flex items-center justify-center gap-1.5">
                            <div class="w-12 h-1 bg-slate-700 rounded-full"></div>
                            <div class="w-2 h-2 bg-slate-950 rounded-full"></div>
                        </div>

                        <!-- Screen Content Area -->
                        <div class="w-full h-full relative bg-slate-50 font-sans text-slate-800 overflow-hidden flex flex-col justify-between" style="border-radius: 2.2rem;">
                            
                            <!-- APP LOGIN SCREEN -->
                            <div x-show="activeScreen === 'login'" x-transition:enter="transition opacity duration-500" class="absolute inset-0 flex flex-col justify-between p-6 bg-slate-900 text-white">
                                <div class="flex flex-col items-center pt-16">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center p-2 shadow-lg shadow-orange-500/20">
                                        <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-10 h-10 object-contain" onerror="this.style.display='none'">
                                    </div>
                                    <h3 class="text-lg font-extrabold text-white mt-4 tracking-tight">Rumba Athaya</h3>
                                    <p class="text-[9px] text-slate-400 font-bold tracking-wider uppercase mt-1">Learning Management</p>
                                </div>

                                <div class="space-y-3 mb-8">
                                    <div class="w-full h-9 rounded-xl bg-slate-800 border border-slate-700/60 flex items-center px-3.5 text-[11px] text-slate-400">
                                        Email Anda
                                    </div>
                                    <div class="w-full h-9 rounded-xl bg-slate-800 border border-slate-700/60 flex items-center px-3.5 text-[11px] text-slate-400">
                                        Password
                                    </div>
                                    <button class="w-full h-9 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold text-xs shadow-md shadow-orange-500/20">
                                        Masuk Ke Aplikasi
                                    </button>
                                </div>
                            </div>

                            <!-- APP DASHBOARD SCREEN -->
                            <div x-show="activeScreen === 'dashboard'" x-transition:enter="transition opacity duration-500" class="absolute inset-0 flex flex-col justify-between bg-slate-50">
                                <!-- App Header -->
                                <div class="bg-gradient-to-br from-indigo-650 to-violet-700 p-4 pt-12 pb-5 text-white rounded-b-[2rem] shadow-lg shadow-indigo-650/10">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-[9px] text-indigo-100 font-medium">Selamat Belajar,</p>
                                            <h4 class="text-sm font-extrabold tracking-tight mt-0.5">Ahmad Rizki 🎓</h4>
                                        </div>
                                        <div class="w-7 h-7 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs border border-white/20">
                                            A
                                        </div>
                                    </div>
                                </div>

                                <!-- App Body Content -->
                                <div class="flex-1 p-4 space-y-3 overflow-y-auto">
                                    <!-- Stat card -->
                                    <div class="bg-white p-3 rounded-2xl border border-slate-100 shadow-sm flex justify-between items-center">
                                        <div>
                                            <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">Materi Belajar</span>
                                            <p class="text-xs font-extrabold text-slate-800 mt-0.5">12 Modul Aktif</p>
                                        </div>
                                        <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                            <i class="ph ph-book-open text-base"></i>
                                        </div>
                                    </div>

                                    <!-- Schedule card -->
                                    <div class="bg-white p-3 rounded-2xl border border-slate-100 shadow-sm space-y-1.5">
                                        <div class="flex justify-between items-center">
                                            <span class="text-[8px] font-bold text-orange-500 uppercase tracking-wider font-extrabold">Jadwal Hari Ini</span>
                                            <span class="text-[8px] px-2 py-0.5 bg-orange-50 text-orange-600 font-bold rounded-full">15:00</span>
                                        </div>
                                        <h5 class="text-xs font-bold text-slate-800">Matematika Dasar</h5>
                                        <p class="text-[9px] text-slate-400">Tutor: Kak Ilham, S.Pd</p>
                                    </div>
                                </div>

                                <!-- App Bottom Nav Bar -->
                                <div class="bg-white border-t border-slate-100 py-2 flex justify-around items-center px-2 flex-shrink-0 shadow-lg">
                                    <div class="flex flex-col items-center gap-0.5 text-indigo-650">
                                        <i class="ph ph-squares-four-fill text-base"></i>
                                        <span class="text-[7px] font-bold">Beranda</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-0.5 text-slate-400">
                                        <i class="ph ph-calendar text-base"></i>
                                        <span class="text-[7px] font-bold">Jadwal</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-0.5 text-slate-400">
                                        <i class="ph ph-book-open text-base"></i>
                                        <span class="text-[7px] font-bold">Materi</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Floating Badge 1 (Top-Left) -->
                    <div class="absolute bg-white text-slate-800 p-2.5 rounded-2xl shadow-xl flex items-center gap-2 border border-slate-100 animate-float z-20" style="top: 80px; left: -40px;">
                        <div class="w-7 h-7 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500">
                            <i class="ph ph-bell text-base"></i>
                        </div>
                        <div class="text-left text-[11px] leading-tight">
                            <span class="font-extrabold block text-slate-800">Push Notif</span>
                            <span class="text-slate-450 text-[9px]">Info Realtime</span>
                        </div>
                    </div>

                    <!-- Floating Badge 2 (Bottom-Right) -->
                    <div class="absolute bg-white text-slate-800 p-2.5 rounded-2xl shadow-xl flex items-center gap-2 border border-slate-100 animate-float animation-delay-2000 z-20" style="bottom: 80px; right: -40px;">
                        <div class="w-7 h-7 rounded-xl bg-green-50 flex items-center justify-center text-green-500">
                            <i class="ph ph-circle-wavy-check text-base"></i>
                        </div>
                        <div class="text-left text-[11px] leading-tight">
                            <span class="font-extrabold block text-slate-800">Instan</span>
                            <span class="text-slate-450 text-[9px]">Ukuran Ringan</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Installation Instructions Section -->
        <div class="mt-24 pt-16 border-t border-slate-200 max-w-4xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center mb-12">Panduan Mudah Menginstall APK</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Card 1 -->
                <div class="bg-white border border-slate-100 p-8 rounded-3xl text-center space-y-4 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto text-lg font-extrabold shadow-sm">
                        1
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Unduh File APK</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Ketuk tombol <span class="font-bold text-orange-600">"File APK Android"</span> di atas untuk mengunduh aplikasi ke handphone Anda.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white border border-slate-100 p-8 rounded-3xl text-center space-y-4 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto text-lg font-extrabold shadow-sm">
                        2
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Izinkan Pemasangan</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Buka Pengaturan HP → Keamanan, lalu aktifkan opsi <span class="font-bold text-slate-800">"Izinkan dari Sumber Tidak Dikenal"</span> jika diminta.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white border border-slate-100 p-8 rounded-3xl text-center space-y-4 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto text-lg font-extrabold shadow-sm">
                        3
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Install & Jalankan</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Buka File Manager HP, klik file <span class="font-bold text-slate-800">rumba-athaya.apk</span>, pilih <span class="font-bold text-indigo-650">Install</span>, lalu jalankan aplikasinya.
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
