@extends('layouts.landing')

@section('title', 'Unduh Aplikasi Mobile')

@section('content')
<div class="relative min-h-screen bg-slate-50 text-slate-800 pt-28 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Ambient background soft glows -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-gradient-to-br from-orange-400/10 to-amber-300/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-[500px] h-[500px] bg-gradient-to-br from-indigo-400/10 to-purple-400/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <!-- Fine grid pattern overlay -->
    <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, #0f172a 1px, transparent 0); background-size: 32px 32px"></div>

    <div class="max-w-6xl mx-auto relative z-10">
        <!-- Main Layout: Split Column using Flexbox (Robust & Responsive) -->
        <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-12 lg:gap-16">
            
            <!-- Left Side: App Pitch & Action Cards (Takes 60% on desktop) -->
            <div class="w-full lg:w-[58%] space-y-8 text-center lg:text-left">
                
                <!-- Badge -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-orange-50 border border-orange-100 rounded-full text-xs font-bold text-orange-600 shadow-sm">
                    <i class="ph ph-android-logo text-base"></i>
                    <span>APLIKASI MOBILE ANDROID</span>
                </div>

                <!-- Main Heading -->
                <div class="space-y-4">
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight leading-tight text-slate-900">
                        Belajar Lebih Mudah <br class="hidden sm:inline"/>
                        Dalam <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-600 to-amber-500 font-extrabold">Satu Genggaman</span>
                    </h1>
                    <p class="text-slate-650 text-base sm:text-lg leading-relaxed max-w-xl mx-auto lg:mx-0 font-medium">
                        Pantau jadwal les, materi belajar, presensi harian, dan terima notifikasi kegiatan realtime langsung dari handphone Anda.
                    </p>
                </div>

                <!-- Download Card Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4">
                    <!-- Download Card -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-lg shadow-slate-200/30 flex flex-col justify-between space-y-6">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                                <i class="ph ph-download-simple text-xl"></i>
                            </div>
                            <h3 class="font-bold text-base text-slate-800">Unduh Langsung APK</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Unduh file instalasi mentah aplikasi Rumba Athaya langsung ke HP Anda.</p>
                        </div>
                        
                        <div class="space-y-3">
                            <a href="{{ route('download') }}/../../apps/rumba-athaya.apk" download
                               class="group flex items-center justify-center gap-2 py-3 bg-gradient-to-r from-orange-500 to-amber-550 text-white rounded-xl font-bold text-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 w-full">
                                <i class="ph ph-download-simple text-base group-hover:animate-bounce"></i>
                                <span>Unduh APK</span>
                            </a>
                            <div class="flex justify-between text-[10px] text-slate-400 px-1">
                                <span>Ukuran: ~103 MB</span>
                                <span>OS: Android 8.0+</span>
                            </div>
                        </div>
                    </div>

                    <!-- QR Code Card -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-lg shadow-slate-200/30 flex flex-col justify-between space-y-6">
                        <div class="space-y-2">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-650">
                                <i class="ph ph-qr-code text-xl"></i>
                            </div>
                            <h3 class="font-bold text-base text-slate-800">Pindai Kode QR</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Arahkan kamera HP Anda ke kode QR untuk mengunduh instan.</p>
                        </div>

                        <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            <div class="w-14 h-14 bg-white p-1.5 rounded-lg border border-slate-200 flex items-center justify-center flex-shrink-0">
                                <svg class="w-full h-full text-slate-800" viewBox="0 0 100 100" fill="currentColor">
                                    <path d="M0,0h40v40H0V0z M10,10v20h20V10H10z M60,0h40v40H60V0z M70,10v20h20V10H70z M0,60h40v40H0V60z M10,70v20h20V70H10z M50,50h10v10H50V50z M60,60h10v10H60V60z M70,50h10v10H70V50z M80,60h10v10H80V60z M50,70h10v10H50V70z M80,80h20v20H80V80z M60,90h20v10H60V90z" />
                                    <rect x="15" y="15" width="10" height="10" />
                                    <rect x="75" y="15" width="10" height="10" />
                                    <rect x="15" y="75" width="10" height="10" />
                                </svg>
                            </div>
                            <div class="text-left text-[10px] text-slate-500 leading-tight">
                                <span class="font-bold text-slate-700 block mb-0.5">Scan Kamera</span>
                                Pindai QR menggunakan aplikasi kamera HP Anda.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Side: Phone Mockup Showcase (Takes 38% on desktop, hidden on mobile/tablet) -->
            <div class="w-full lg:w-[38%] hidden lg:flex items-center justify-center flex-shrink-0">
                <!-- Phone Wrapper (Absolute boundaries with padding) -->
                <div class="relative py-6 px-4">
                    
                    <!-- Glow background -->
                    <div class="absolute w-72 h-72 rounded-full bg-orange-500/10 blur-3xl opacity-75" style="top: 50%; left: 50%; transform: translate(-50%, -50%);"></div>

                    <!-- CSS Phone Frame -->
                    <div class="shadow-2xl border-[10px] border-slate-900 bg-slate-950" 
                         style="width: 280px; height: 560px; border-radius: 3rem; position: relative;">
                        
                        <!-- Notch -->
                        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-28 h-5 bg-slate-900 rounded-b-xl z-50 flex items-center justify-center gap-1">
                            <div class="w-10 h-0.5 bg-slate-700 rounded-full"></div>
                            <div class="w-1.5 h-1.5 bg-slate-950 rounded-full"></div>
                        </div>

                        <!-- Screen Contents -->
                        <div class="w-full h-full bg-slate-900 text-white flex flex-col justify-between overflow-hidden relative" style="border-radius: 2.1rem;">
                            <!-- App Header -->
                            <div class="bg-gradient-to-r from-orange-500 to-amber-500 p-4 pt-8 pb-4 text-left rounded-b-2xl shadow-lg">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-7 h-7 object-contain rounded-lg" onerror="this.style.display='none'">
                                    <div>
                                        <h4 class="text-xs font-bold leading-none">Rumba Athaya</h4>
                                        <span class="text-[8px] text-orange-100 font-medium">Learning Management App</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Screen Mockup Inside -->
                            <div class="flex-1 p-4 flex flex-col justify-center items-center space-y-4">
                                <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center text-3xl shadow-inner animate-pulse">
                                    🎓
                                </div>
                                <div class="text-center space-y-1 px-2">
                                    <h5 class="text-xs font-bold">Portal Siswa & Tutor</h5>
                                    <p class="text-[9px] text-slate-400">Masuk untuk melihat jadwal kelas, absensi harian, jurnal, dan modul belajar secara praktis.</p>
                                </div>
                                <div class="w-full space-y-2 px-2">
                                    <div class="w-full h-8 rounded-lg bg-white/5 border border-white/10 flex items-center px-3 text-[9px] text-slate-500 text-left">Email Pengguna</div>
                                    <div class="w-full h-8 rounded-lg bg-white/5 border border-white/10 flex items-center px-3 text-[9px] text-slate-500 text-left">Kata Sandi</div>
                                </div>
                            </div>

                            <!-- App Button -->
                            <div class="p-3 bg-slate-950 border-t border-white/5 flex justify-center items-center">
                                <div class="w-full py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-lg text-[9px] font-bold text-center">
                                    Login Aplikasi
                        </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Badge 1 (Top-Left) -->
                    <div class="absolute bg-white text-slate-800 p-2.5 rounded-2xl shadow-xl flex items-center gap-2 border border-slate-100 animate-float z-20" style="top: 60px; left: -30px;">
                        <div class="w-7 h-7 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500">
                            <i class="ph ph-bell text-base"></i>
                        </div>
                        <div class="text-left text-[10px] leading-tight">
                            <span class="font-extrabold block text-slate-800">Push Notif</span>
                            <span class="text-slate-400 text-[8px]">Realtime & Cepat</span>
                        </div>
                    </div>

                    <!-- Floating Badge 2 (Bottom-Right) -->
                    <div class="absolute bg-white text-slate-800 p-2.5 rounded-2xl shadow-xl flex items-center gap-2 border border-slate-100 animate-float animation-delay-2000 z-20" style="bottom: 60px; right: -30px;">
                        <div class="w-7 h-7 rounded-xl bg-green-50 flex items-center justify-center text-green-500">
                            <i class="ph ph-circle-wavy-check text-base"></i>
                        </div>
                        <div class="text-left text-[10px] leading-tight">
                            <span class="font-extrabold block text-slate-800">Akses Ringan</span>
                            <span class="text-slate-400 text-[8px]">Hemat Kuota HP</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Section 3: Installation Steps (Clean & Properly Spaced) -->
        <div class="pt-16 border-t border-slate-200 max-w-4xl mx-auto space-y-12">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 text-center">Panduan Pemasangan Aplikasi</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="bg-white border border-slate-100 p-8 rounded-3xl text-center space-y-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto text-lg font-extrabold shadow-sm">
                        1
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Unduh APK</h3>
                    <p class="text-sm text-slate-550 leading-relaxed">
                        Ketuk tombol <span class="font-bold text-orange-600">"Unduh File APK"</span> di atas untuk menyimpan file instalasi ke memori handphone Anda.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white border border-slate-100 p-8 rounded-3xl text-center space-y-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto text-lg font-extrabold shadow-sm">
                        2
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Izinkan Sumber</h3>
                    <p class="text-sm text-slate-550 leading-relaxed">
                        Buka Pengaturan HP → Keamanan, lalu aktifkan opsi <span class="font-bold text-slate-800">"Izinkan Pemasangan dari Sumber Tidak Dikenal"</span> jika diminta.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white border border-slate-100 p-8 rounded-3xl text-center space-y-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mx-auto text-lg font-extrabold shadow-sm">
                        3
                    </div>
                    <h3 class="font-bold text-lg text-slate-800">Install & Jalankan</h3>
                    <p class="text-sm text-slate-550 leading-relaxed">
                        Buka File Manager, ketuk file <span class="font-bold text-slate-800">rumba-athaya.apk</span>, pilih <span class="font-bold text-indigo-600">Install / Pasang</span>, lalu buka aplikasinya.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
