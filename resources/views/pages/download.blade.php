@extends('layouts.landing')

@section('title', 'Unduh Aplikasi Mobile')

@section('content')
<div class="relative min-h-[calc(100vh-3.5rem)] flex items-center justify-center py-16 overflow-hidden bg-gradient-to-br from-slate-50 via-orange-50/40 to-indigo-50/40 text-slate-900">
    <!-- Ambient animated background blobs (soft colors) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -left-32 w-96 h-96 bg-gradient-to-br from-orange-400/10 to-amber-400/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-1/4 -right-32 w-[500px] h-[500px] bg-gradient-to-br from-indigo-400/10 to-purple-400/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <!-- Fine grid pattern overlay -->
    <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, #0f172a 1px, transparent 0); background-size: 32px 32px"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <!-- Left Column: Marketing & Download Action -->
            <div class="text-center lg:text-left space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
                <!-- Badge -->
                <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                     class="inline-flex items-center gap-2.5 px-4 py-2 bg-orange-50 border border-orange-200/80 rounded-full text-xs font-bold text-orange-600 shadow-sm shadow-orange-100">
                    <i class="ph ph-android-logo text-base"></i>
                    <span>KINI TERSEDIA UNTUK ANDROID</span>
                </div>

                <!-- Main Heading -->
                <h1 x-show="show" x-transition:enter="transition ease-out duration-700 delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight text-slate-905">
                    Belajar Lebih Mudah <br class="hidden sm:inline" />
                    Dalam <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-600 via-amber-550 to-orange-500">Satu Genggaman</span>
                </h1>

                <!-- Description -->
                <p x-show="show" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                   class="text-slate-600 text-base sm:text-lg leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium">
                    Pantau jadwal belajar, unduh materi, absensi kelas, dan terima notifikasi langsung di handphone Android Anda kapan saja dan di mana saja.
                </p>

                <!-- Download Buttons & QR -->
                <div x-show="show" x-transition:enter="transition ease-out duration-700 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                     class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-6 pt-4">
                    
                    <!-- Direct APK Download Link -->
                    <a href="/apps/rumba-athaya.apk" download
                       class="group relative flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-orange-500 via-orange-600 to-amber-500 text-white rounded-2xl font-bold text-lg shadow-lg shadow-orange-500/20 hover:shadow-xl hover:shadow-orange-500/40 hover:-translate-y-1 hover:scale-105 transition-all duration-300 w-full sm:w-auto">
                        <i class="ph ph-download-simple text-2xl group-hover:animate-bounce"></i>
                        <div class="text-left">
                            <span class="block text-xs font-semibold text-orange-200 leading-none">Unduh Langsung</span>
                            <span class="block text-base font-extrabold leading-none mt-1">File APK Android</span>
                        </div>
                    </a>

                    <!-- QR Code (for scanning on desktop) -->
                    <div class="hidden sm:flex items-center gap-4 p-4 bg-white rounded-2xl border border-slate-200/60 shadow-sm">
                        <!-- QR Simulation (using SVG) -->
                        <div class="w-16 h-16 bg-white p-0.5 flex items-center justify-center">
                            <svg class="w-full h-full text-slate-800" viewBox="0 0 100 100" fill="currentColor">
                                <path d="M0,0h40v40H0V0z M10,10v20h20V10H10z M60,0h40v40H60V0z M70,10v20h20V10H70z M0,60h40v40H0V60z M10,70v20h20V70H10z M50,50h10v10H50V50z M60,60h10v10H60V60z M70,50h10v10H70V50z M80,60h10v10H80V60z M50,70h10v10H50V70z M80,80h20v20H80V80z M60,90h20v10H60V90z" />
                                <rect x="15" y="15" width="10" height="10" />
                                <rect x="75" y="15" width="10" height="10" />
                                <rect x="15" y="75" width="10" height="10" />
                            </svg>
                        </div>
                        <div class="text-left text-xs text-slate-550 max-w-[120px]">
                            <span class="font-bold text-slate-800 block">Scan QR Code</span>
                            untuk mendownload langsung di HP Anda
                        </div>
                    </div>
                </div>

                <!-- Specs -->
                <div x-show="show" x-transition:enter="transition ease-out duration-700 delay-400" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     class="flex items-center justify-center lg:justify-start gap-6 text-xs text-slate-500 pt-2 flex-wrap">
                    <span>Versi: 1.0.0 (Terbaru)</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Ukuran: ~103 MB</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Android 8.0+ ke atas</span>
                </div>
            </div>

            <!-- Right Column: Interactive Phone Mockup -->
            <div class="relative flex items-center justify-center"
                 x-data="{ activeScreen: 'login' }"
                 x-init="setInterval(() => { activeScreen = activeScreen === 'login' ? 'dashboard' : 'login' }, 5000)">
                <!-- Decorative glow ring behind the phone -->
                <div class="absolute w-80 h-80 rounded-full bg-orange-500/10 blur-3xl opacity-70 -z-10 animate-pulse"></div>

                <!-- Phone Body Container -->
                <div class="w-[300px] h-[610px] rounded-[3.2rem] border-[12px] border-slate-900 bg-slate-950 shadow-2xl relative overflow-hidden flex-shrink-0">
                    <!-- Notch / Speaker grill -->
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-6 bg-slate-900 rounded-b-2xl z-50 flex items-center justify-center gap-1.5">
                        <div class="w-12 h-1 bg-slate-800 rounded-full"></div>
                        <div class="w-2.5 h-2.5 bg-slate-950 rounded-full"></div>
                    </div>

                    <!-- Screen Content -->
                    <div class="w-full h-full relative bg-slate-50 font-sans text-slate-800 overflow-hidden flex flex-col justify-between">
                        
                        <!-- APP LOGIN SCREEN -->
                        <div x-show="activeScreen === 'login'" x-transition:enter="transition opacity duration-500" class="absolute inset-0 flex flex-col justify-between p-6 bg-slate-900 text-white">
                            <div class="flex flex-col items-center pt-16">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center p-2 shadow-lg shadow-orange-500/20">
                                    <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-12 h-12 object-contain" onerror="this.style.display='none'">
                                </div>
                                <h3 class="text-xl font-extrabold text-white mt-4 tracking-tight">Rumba Athaya</h3>
                                <p class="text-[10px] text-slate-400 font-bold tracking-wider uppercase mt-1">Learning Management</p>
                            </div>

                            <div class="space-y-3.5 mb-8">
                                <div class="space-y-1">
                                    <div class="w-full h-10 rounded-xl bg-slate-800 border border-slate-700/60 flex items-center px-3.5 text-xs text-slate-400">
                                        Email Anda
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <div class="w-full h-10 rounded-xl bg-slate-800 border border-slate-700/60 flex items-center px-3.5 text-xs text-slate-400">
                                        Password
                                    </div>
                                </div>
                                <button class="w-full h-10 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold text-xs shadow-md shadow-orange-500/20">
                                    Masuk Ke Aplikasi
                                </button>
                            </div>
                        </div>

                        <!-- APP DASHBOARD SCREEN -->
                        <div x-show="activeScreen === 'dashboard'" x-transition:enter="transition opacity duration-500" class="absolute inset-0 flex flex-col justify-between bg-slate-50">
                            <!-- App Header -->
                            <div class="bg-gradient-to-br from-indigo-600 to-violet-700 p-4 pt-12 pb-6 text-white rounded-b-[2rem] shadow-lg shadow-indigo-600/10">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-[10px] text-indigo-100 font-medium">Selamat Belajar,</p>
                                        <h4 class="text-base font-extrabold tracking-tight mt-0.5">Ahmad Rizki 🎓</h4>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center font-bold text-xs border border-white/20">
                                        A
                                    </div>
                                </div>
                            </div>

                            <!-- App Body Content -->
                            <div class="flex-1 p-4 space-y-3.5 overflow-y-auto">
                                <!-- Stat card -->
                                <div class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm flex justify-between items-center">
                                    <div>
                                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Materi Belajar</span>
                                        <p class="text-sm font-extrabold text-slate-800 mt-0.5">12 Modul Aktif</p>
                                    </div>
                                    <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                        <i class="ph ph-book-open text-lg"></i>
                                    </div>
                                </div>

                                <!-- Schedule card -->
                                <div class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm space-y-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[9px] font-bold text-orange-500 uppercase tracking-wider">Jadwal Les Hari Ini</span>
                                        <span class="text-[9px] px-2 py-0.5 bg-orange-50 to-orange-100 text-orange-600 font-bold rounded-full">15:00</span>
                                    </div>
                                    <h5 class="text-xs font-bold text-slate-800">Matematika Dasar</h5>
                                    <p class="text-[10px] text-slate-450">Tutor: Kak Ilham, S.Pd</p>
                                </div>
                            </div>

                            <!-- App Bottom Nav Bar -->
                            <div class="bg-white border-t border-slate-100 py-2.5 flex justify-around items-center px-2 flex-shrink-0 shadow-lg">
                                <div class="flex flex-col items-center gap-0.5 text-indigo-600">
                                    <i class="ph ph-squares-four-fill text-lg"></i>
                                    <span class="text-[8px] font-bold">Beranda</span>
                                </div>
                                <div class="flex flex-col items-center gap-0.5 text-slate-400">
                                    <i class="ph ph-calendar text-lg"></i>
                                    <span class="text-[8px] font-bold">Jadwal</span>
                                </div>
                                <div class="flex flex-col items-center gap-0.5 text-slate-400">
                                    <i class="ph ph-book-open text-lg"></i>
                                    <span class="text-[8px] font-bold">Materi</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Small Floating Badges -->
                <div class="absolute -top-4 -right-4 bg-white text-slate-900 p-3 rounded-2xl shadow-xl flex items-center gap-3 border border-slate-100 animate-float z-20">
                    <div class="w-8 h-8 rounded-xl bg-orange-100 flex items-center justify-center text-orange-500">
                        <i class="ph ph-bell text-lg"></i>
                    </div>
                    <div class="text-left text-xs">
                        <span class="font-bold block text-slate-850">Push Notif</span>
                        <span class="text-slate-400 text-[10px]">Info Realtime</span>
                    </div>
                </div>

                <div class="absolute -bottom-4 -left-4 bg-white text-slate-900 p-3 rounded-2xl shadow-xl flex items-center gap-3 border border-slate-100 animate-float animation-delay-2000 z-20">
                    <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-green-500">
                        <i class="ph ph-circle-wavy-check text-lg"></i>
                    </div>
                    <div class="text-left text-xs">
                        <span class="font-bold block text-slate-850">Instan</span>
                        <span class="text-slate-400 text-[10px]">Ukuran Ringan</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Installation Instructions Section -->
        <div class="mt-24 pt-16 border-t border-slate-200 max-w-4xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center mb-12">Panduan Mudah Menginstall APK</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="bg-white border border-slate-100 p-6 rounded-2xl text-center space-y-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mx-auto text-xl font-bold">
                        1
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Unduh APK</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Klik tombol **"Unduh File APK"** di atas untuk mengunduh aplikasi langsung ke perangkat handphone Anda.
                    </p>
                </div>

                <div class="bg-white border border-slate-100 p-6 rounded-2xl text-center space-y-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mx-auto text-xl font-bold">
                        2
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Izinkan Sumber</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Buka Pengaturan HP → Keamanan, dan aktifkan **"Izinkan menginstal aplikasi dari Sumber Tidak Dikenal"** jika diminta.
                    </p>
                </div>

                <div class="bg-white border border-slate-100 p-6 rounded-2xl text-center space-y-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mx-auto text-xl font-bold">
                        3
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Install & Jalankan</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Buka file Manager HP, klik file `rumba-athaya.apk` yang sudah diunduh, klik **Install**, lalu login!
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
