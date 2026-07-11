@extends('layouts.landing')

@section('title', 'Unduh Aplikasi Mobile')

@section('content')
<div class="relative min-h-[calc(100vh-3.5rem)] bg-gradient-to-b from-slate-50 via-orange-50/20 to-indigo-50/20 text-slate-900 py-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Ambient background soft glows -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-gradient-to-br from-orange-400/10 to-amber-300/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-[500px] h-[500px] bg-gradient-to-br from-indigo-400/10 to-purple-400/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <!-- Fine grid pattern overlay -->
    <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, #0f172a 1px, transparent 0); background-size: 32px 32px"></div>

    <div class="max-w-4xl mx-auto text-center space-y-12 relative z-10">
        
        <!-- Hero Header -->
        <div class="space-y-6" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
            <!-- Mobile Badge -->
            <div x-show="show" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                 class="inline-flex items-center gap-2 px-4 py-2 bg-orange-50 border border-orange-100 rounded-full text-xs font-bold text-orange-600 shadow-sm shadow-orange-100/50">
                <i class="ph ph-android-logo text-base"></i>
                <span>APLIKASI ANDROID RESMI</span>
            </div>

            <!-- Headline -->
            <h1 x-show="show" x-transition:enter="transition ease-out duration-700 delay-100" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-tight text-slate-900">
                Belajar Lebih Mudah <br class="hidden sm:inline"/>
                Dalam <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-600 to-amber-500">Satu Genggaman</span>
            </h1>

            <!-- Subtitle -->
            <p x-show="show" x-transition:enter="transition ease-out duration-700 delay-200" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
               class="text-slate-600 text-base sm:text-lg md:text-xl leading-relaxed max-w-2xl mx-auto font-medium">
                Pantau jadwal belajar, unduh materi, absensi kelas, dan terima notifikasi langsung di handphone Android Anda kapan saja dan di mana saja.
            </p>
        </div>

        <!-- Download Action Card (Centered) -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 max-w-2xl mx-auto">
            <div class="flex flex-col sm:flex-row items-center gap-6">
                
                <!-- Left: Download Button -->
                <div class="flex-1 w-full text-center sm:text-left">
                    <a href="/apps/rumba-athaya.apk" download
                       class="group flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-orange-500 via-orange-600 to-amber-500 text-white rounded-2xl font-bold hover:shadow-lg hover:shadow-orange-500/20 hover:-translate-y-0.5 transition-all duration-300 w-full">
                        <i class="ph ph-download-simple text-xl group-hover:animate-bounce"></i>
                        <div class="text-left">
                            <span class="block text-[10px] font-semibold text-orange-200 uppercase tracking-wider">Unduh Sekarang</span>
                            <span class="block text-base font-extrabold leading-none mt-0.5">File APK Android</span>
                        </div>
                    </a>
                    <div class="flex justify-between text-[11px] text-slate-400 mt-3 px-1">
                        <span>Ukuran: ~103 MB</span>
                        <span>Versi: 1.0.0</span>
                        <span>OS: Android 8.0+</span>
                    </div>
                </div>

                <!-- Divider -->
                <div class="w-full h-px bg-slate-150 sm:w-px sm:h-16 flex-shrink-0"></div>

                <!-- Right: QR Code -->
                <div class="flex items-center gap-4 flex-shrink-0 w-full sm:w-auto justify-center sm:justify-start">
                    <div class="w-16 h-16 bg-slate-50 p-1.5 rounded-xl border border-slate-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-full h-full text-slate-850" viewBox="0 0 100 100" fill="currentColor">
                            <path d="M0,0h40v40H0V0z M10,10v20h20V10H10z M60,0h40v40H60V0z M70,10v20h20V10H70z M0,60h40v40H0V60z M10,70v20h20V70H10z M50,50h10v10H50V50z M60,60h10v10H60V60z M70,50h10v10H70V50z M80,60h10v10H80V60z M50,70h10v10H50V70z M80,80h20v20H80V80z M60,90h20v10H60V90z" />
                            <rect x="15" y="15" width="10" height="10" />
                            <rect x="75" y="15" width="10" height="10" />
                            <rect x="15" y="75" width="10" height="10" />
                        </svg>
                    </div>
                    <div class="text-left text-xs text-slate-500 max-w-[140px] leading-tight">
                        <span class="font-bold text-slate-800 block mb-0.5">Pindai Kode QR</span>
                        Arahkan kamera HP Anda untuk mengunduh secara instan
                    </div>
                </div>

            </div>
        </div>

        <!-- Centered High-Fidelity Phone Showcase -->
        <div class="relative py-8 flex justify-center items-center">
            
            <!-- Floating Feature Tag Left -->
            <div class="absolute left-4 md:left-20 top-1/4 bg-white p-3 rounded-2xl shadow-lg border border-slate-100 flex items-center gap-3 animate-float hidden sm:flex z-20">
                <div class="w-8 h-8 rounded-xl bg-orange-100 flex items-center justify-center text-orange-600">
                    <i class="ph ph-bell text-lg"></i>
                </div>
                <div class="text-left">
                    <span class="font-extrabold text-xs text-slate-800 block">Push Notification</span>
                    <span class="text-slate-405 text-[9px]">Jadwal & Pengumuman</span>
                </div>
            </div>

            <!-- Floating Feature Tag Right -->
            <div class="absolute right-4 md:right-20 bottom-1/4 bg-white p-3 rounded-2xl shadow-lg border border-slate-100 flex items-center gap-3 animate-float animation-delay-2000 hidden sm:flex z-20">
                <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                    <i class="ph ph-circle-wavy-check text-lg"></i>
                </div>
                <div class="text-left">
                    <span class="font-extrabold text-xs text-slate-800 block">Akses Ringan</span>
                    <span class="text-slate-405 text-[9px]">Hemat Kuota & Cepat</span>
                </div>
            </div>

            <!-- Centered Phone Showcase Container -->
            <div class="shadow-2xl border-[10px] border-slate-900 bg-slate-950 overflow-hidden" 
                 style="width: 290px; height: 580px; border-radius: 3rem; position: relative;">
                
                <!-- Speaker notch -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-28 h-5 bg-slate-900 rounded-b-xl z-50 flex items-center justify-center gap-1">
                    <div class="w-10 h-0.5 bg-slate-700 rounded-full"></div>
                    <div class="w-1.5 h-1.5 bg-slate-950 rounded-full"></div>
                </div>

                <!-- Screen Contents -->
                <div class="w-full h-full bg-slate-900 text-white flex flex-col justify-between overflow-hidden relative">
                    <!-- Simulate App Header -->
                    <div class="bg-gradient-to-r from-orange-500 to-amber-500 p-4 pt-8 pb-4 text-left rounded-b-2xl shadow-lg">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-7 h-7 object-contain rounded-lg" onerror="this.style.display='none'">
                            <div>
                                <h4 class="text-xs font-bold leading-none">Rumba Athaya</h4>
                                <span class="text-[8px] text-orange-100 font-medium">Learning Management App</span>
                            </div>
                        </div>
                    </div>

                    <!-- Screen Mockup Image / Illustration area -->
                    <div class="flex-1 p-4 flex flex-col justify-center items-center space-y-4">
                        <div class="w-20 h-20 rounded-2xl bg-white/10 flex items-center justify-center text-4xl shadow-inner animate-pulse">
                            🎓
                        </div>
                        <div class="text-center space-y-1 px-4">
                            <h5 class="text-xs font-bold">Portal Siswa & Tutor</h5>
                            <p class="text-[9px] text-slate-400">Masuk untuk melihat jadwal kelas, absensi harian, jurnal, dan modul belajar secara praktis.</p>
                        </div>
                        <!-- Mini form inputs simulation -->
                        <div class="w-full space-y-2 px-2">
                            <div class="w-full h-8 rounded-lg bg-white/5 border border-white/10 flex items-center px-3 text-[10px] text-slate-500 text-left">Email Pengguna</div>
                            <div class="w-full h-8 rounded-lg bg-white/5 border border-white/10 flex items-center px-3 text-[10px] text-slate-500 text-left">Kata Sandi</div>
                        </div>
                    </div>

                    <!-- Simulate App Footer/Action -->
                    <div class="p-3 bg-slate-950 border-t border-white/5 flex justify-center items-center">
                        <div class="w-full py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-lg text-[10px] font-bold">
                            Login Aplikasi
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Installation Instructions Section -->
        <div class="pt-16 border-t border-slate-200 max-w-4xl mx-auto">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center mb-12">Panduan Pemasangan Aplikasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <!-- Step 1 -->
                <div class="bg-white border border-slate-100 p-8 rounded-3xl text-center space-y-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto text-lg font-extrabold shadow-sm">
                        1
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Unduh APK</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Ketuk tombol <span class="font-bold text-orange-600">"File APK Android"</span> di atas untuk memulai pengunduhan ke handphone.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white border border-slate-100 p-8 rounded-3xl text-center space-y-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto text-lg font-extrabold shadow-sm">
                        2
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Izinkan Pemasangan</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Buka menu Pengaturan Keamanan HP Anda, lalu aktifkan pilihan <span class="font-bold text-slate-800">"Izinkan Pemasangan dari Sumber Tidak Dikenal"</span>.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white border border-slate-100 p-8 rounded-3xl text-center space-y-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto text-lg font-extrabold shadow-sm">
                        3
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Install & Gunakan</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Buka folder Unduhan, ketuk file <span class="font-bold text-slate-800">rumba-athaya.apk</span>, pilih <span class="font-bold text-indigo-600">Pasang</span>, lalu masuk menggunakan akun Anda.
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
