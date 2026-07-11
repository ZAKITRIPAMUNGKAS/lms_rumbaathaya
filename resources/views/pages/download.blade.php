@extends('layouts.landing')

@section('title', 'Unduh Aplikasi Mobile')

@section('content')
<div class="relative min-h-[calc(100vh-3.5rem)] bg-slate-50 text-slate-800 py-16 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Ambient background soft glows -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-gradient-to-br from-orange-400/10 to-amber-300/10 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-[500px] h-[500px] bg-gradient-to-br from-indigo-400/10 to-purple-400/10 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
    </div>

    <!-- Fine grid pattern overlay -->
    <div class="absolute inset-0 opacity-[0.015] pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, #0f172a 1px, transparent 0); background-size: 32px 32px"></div>

    <div class="max-w-5xl mx-auto space-y-16 relative z-10">
        
        <!-- Section 1: Hero Header -->
        <div class="text-center space-y-6">
            <!-- Mobile Badge -->
            <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-orange-50 border border-orange-100 rounded-full text-xs font-bold text-orange-600 shadow-sm">
                <i class="ph ph-android-logo text-base"></i>
                <span>APLIKASI MOBILE ANDROID</span>
            </div>

            <!-- Headline -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-tight text-slate-900">
                Belajar Lebih Mudah <br class="hidden sm:inline"/>
                Dalam <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-600 to-amber-500">Satu Genggaman</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-slate-600 text-base sm:text-lg md:text-xl leading-relaxed max-w-2xl mx-auto font-medium">
                Akses jadwal belajar, unduh modul materi, pencatatan absensi, dan notifikasi kegiatan realtime langsung dari handphone Anda.
            </p>
        </div>

        <!-- Section 2: Clean Download Actions (Grid of 2 Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <!-- Card 1: Direct Download -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col justify-between space-y-6">
                <div class="space-y-3 text-center md:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 mx-auto md:mx-0">
                        <i class="ph ph-download-simple text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Unduh Langsung APK</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Dapatkan file instalasi mentah aplikasi Rumba Athaya langsung ke memori handphone Anda.</p>
                </div>
                
                <div class="space-y-4">
                    <a href="{{ route('download') }}/../../apps/rumba-athaya.apk" download
                       class="group flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-orange-500 to-amber-550 text-white rounded-2xl font-bold hover:shadow-lg hover:shadow-orange-500/20 hover:-translate-y-0.5 transition-all duration-300 w-full">
                        <i class="ph ph-download-simple text-xl group-hover:animate-bounce"></i>
                        <span>Unduh File APK</span>
                    </a>
                    
                    <div class="flex justify-between text-xs text-slate-400 border-t border-slate-100 pt-3 px-1">
                        <span>Ukuran: ~103 MB</span>
                        <span>Versi: 1.0.0</span>
                        <span>OS: Android 8.0+</span>
                    </div>
                </div>
            </div>

            <!-- Card 2: Scan QR Code -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40 flex flex-col justify-between space-y-6">
                <div class="space-y-3 text-center md:text-left">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-650 mx-auto md:mx-0">
                        <i class="ph ph-qr-code text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-extrabold text-slate-800">Pindai Kode QR</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">Scan QR code di bawah ini menggunakan kamera handphone Anda untuk mengunduh secara otomatis.</p>
                </div>

                <div class="flex items-center gap-6 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <div class="w-20 h-20 bg-white p-2 rounded-xl border border-slate-200 flex items-center justify-center flex-shrink-0">
                        <svg class="w-full h-full text-slate-800" viewBox="0 0 100 100" fill="currentColor">
                            <path d="M0,0h40v40H0V0z M10,10v20h20V10H10z M60,0h40v40H60V0z M70,10v20h20V10H70z M0,60h40v40H0V60z M10,70v20h20V70H10z M50,50h10v10H50V50z M60,60h10v10H60V60z M70,50h10v10H70V50z M80,60h10v10H80V60z M50,70h10v10H50V70z M80,80h20v20H80V80z M60,90h20v10H60V90z" />
                            <rect x="15" y="15" width="10" height="10" />
                            <rect x="75" y="15" width="10" height="10" />
                            <rect x="15" y="75" width="10" height="10" />
                        </svg>
                    </div>
                    <div class="text-left text-xs text-slate-500 leading-snug">
                        <span class="font-extrabold text-slate-800 block mb-1">Cara Cepat</span>
                        Buka aplikasi kamera di handphone, arahkan ke QR code, lalu ketuk tautan yang muncul.
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Clean Phone Preview Showcase -->
        <div class="relative py-12 flex justify-center items-center">
            <!-- Floating Feature Left (Desktop Only) -->
            <div class="absolute left-10 md:left-24 top-1/3 bg-white p-3 rounded-2xl shadow-lg border border-slate-100 flex items-center gap-3 animate-float hidden md:flex z-20">
                <div class="w-8 h-8 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                    <i class="ph ph-bell text-lg"></i>
                </div>
                <div class="text-left leading-tight">
                    <span class="font-extrabold text-xs text-slate-800 block">Push Notification</span>
                    <span class="text-slate-400 text-[10px]">Realtime & Cepat</span>
                </div>
            </div>

            <!-- Floating Feature Right (Desktop Only) -->
            <div class="absolute right-10 md:right-24 bottom-1/3 bg-white p-3 rounded-2xl shadow-lg border border-slate-100 flex items-center gap-3 animate-float animation-delay-2000 hidden md:flex z-20">
                <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                    <i class="ph ph-circle-wavy-check text-lg"></i>
                </div>
                <div class="text-left leading-tight">
                    <span class="font-extrabold text-xs text-slate-800 block">Akses Ringan</span>
                    <span class="text-slate-400 text-[10px]">Hemat Kuota HP</span>
                </div>
            </div>

            <!-- Mock Phone Frame (Strict Height/Width to prevent collapse) -->
            <div class="shadow-2xl border-[10px] border-slate-900 bg-slate-950" 
                 style="width: 290px; height: 580px; border-radius: 3rem; position: relative;">
                
                <!-- Notch -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-28 h-5 bg-slate-900 rounded-b-xl z-50 flex items-center justify-center gap-1">
                    <div class="w-10 h-0.5 bg-slate-700 rounded-full"></div>
                    <div class="w-1.5 h-1.5 bg-slate-950 rounded-full"></div>
                </div>

                <!-- Screen Contents -->
                <div class="w-full h-full bg-slate-900 text-white flex flex-col justify-between overflow-hidden relative">
                    <!-- App Header -->
                    <div class="bg-gradient-to-r from-orange-500 to-amber-500 p-4 pt-8 pb-4 text-left rounded-b-2xl shadow-md">
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
        </div>

        <!-- Section 4: Installation Steps -->
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
