@extends('layouts.landing')

@section('title', 'Unduh Aplikasi Mobile')

@section('content')
{{-- ============================================================
     DOWNLOAD PAGE — Rumba Athaya
     Layout: Split Column (Left: Copy + Cards | Right: Mockup)
     Responsive: Stack on mobile, Side-by-side on desktop
     ============================================================ --}}
<div class="relative min-h-screen bg-slate-50 overflow-hidden" style="padding-top: 5.5rem; padding-bottom: 5rem;">

    {{-- Background decoration --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -left-40 w-[32rem] h-[32rem] bg-orange-100/50 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-[40rem] h-[40rem] bg-indigo-100/40 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-6 sm:px-8 lg:px-12">

        {{-- ── HERO SECTION ─────────────────────────────────────── --}}
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-8">

            {{-- LEFT: Copy + Action Cards --}}
            <div class="w-full lg:w-[54%] flex flex-col gap-8">

                {{-- Badge --}}
                <div class="flex justify-center lg:justify-start">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-orange-50 border border-orange-200 rounded-full text-[11px] font-bold uppercase tracking-widest text-orange-600">
                        <i class="ph ph-android-logo"></i>
                        Aplikasi Mobile Android
                    </span>
                </div>

                {{-- Headline --}}
                <div class="text-center lg:text-left space-y-3">
                    <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight tracking-tight text-slate-900">
                        Belajar Lebih Mudah<br>
                        Dalam <span class="text-orange-500">Satu Genggaman</span>
                    </h1>
                    <p class="text-slate-500 text-base sm:text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                        Pantau jadwal les, materi belajar, presensi harian, dan notifikasi kegiatan — langsung dari handphone Anda.
                    </p>
                </div>

                {{-- ── ACTION CARDS ─────────────────────────────── --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- Card 1: Direct Download --}}
                    <div class="flex flex-col bg-white rounded-2xl border border-slate-100 shadow-md shadow-slate-200/50 p-6 gap-5">
                        {{-- Icon + Title --}}
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500 flex-shrink-0">
                                <i class="ph ph-device-mobile-camera text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-slate-800">Unduh Langsung</h3>
                                <p class="text-xs text-slate-400 mt-0.5">File APK Android</p>
                            </div>
                        </div>

                        {{-- Description --}}
                        <p class="text-xs text-slate-500 leading-relaxed flex-1">
                            Unduh file instalasi aplikasi Rumba Athaya dan pasang langsung di handphone Android Anda.
                        </p>

                        {{-- CTA Button --}}
                        <div class="space-y-3">
                            <a href="/apps/rumba-athaya.apk" download
                               class="flex items-center justify-center gap-2.5 w-full py-3 rounded-xl font-bold text-sm text-white transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-orange-500/25"
                               style="background: linear-gradient(135deg, #f97316 0%, #f59e0b 100%)">
                                <i class="ph ph-download-simple text-base"></i>
                                Unduh File APK
                            </a>

                            {{-- Specs --}}
                            <div class="grid grid-cols-3 gap-2">
                                <div class="bg-slate-50 rounded-lg p-2 text-center">
                                    <p class="text-[9px] text-slate-400 leading-none">Ukuran</p>
                                    <p class="text-[10px] font-bold text-slate-700 mt-0.5">~103 MB</p>
                                </div>
                                <div class="bg-slate-50 rounded-lg p-2 text-center">
                                    <p class="text-[9px] text-slate-400 leading-none">Versi</p>
                                    <p class="text-[10px] font-bold text-slate-700 mt-0.5">1.0.0</p>
                                </div>
                                <div class="bg-slate-50 rounded-lg p-2 text-center">
                                    <p class="text-[9px] text-slate-400 leading-none">Minimum</p>
                                    <p class="text-[10px] font-bold text-slate-700 mt-0.5">Android 8</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: QR Code --}}
                    <div class="flex flex-col bg-white rounded-2xl border border-slate-100 shadow-md shadow-slate-200/50 p-6 gap-5">
                        {{-- Icon + Title --}}
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500 flex-shrink-0">
                                <i class="ph ph-qr-code text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-slate-800">Pindai Kode QR</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Dengan kamera HP</p>
                            </div>
                        </div>

                        {{-- Description --}}
                        <p class="text-xs text-slate-500 leading-relaxed flex-1">
                            Arahkan kamera handphone Anda ke kode QR di bawah untuk mengunduh aplikasi secara instan.
                        </p>

                        {{-- QR Widget --}}
                        <div class="flex items-center gap-4 bg-slate-50 border border-slate-100 rounded-xl p-3">
                            <div class="w-16 h-16 bg-white rounded-lg border border-slate-200 p-2 flex-shrink-0 flex items-center justify-center">
                                <svg viewBox="0 0 100 100" fill="#0f172a" class="w-full h-full">
                                    <path d="M0,0h40v40H0V0z M10,10v20h20V10H10z M60,0h40v40H60V0z M70,10v20h20V10H70z M0,60h40v40H0V60z M10,70v20h20V70H10z M50,50h10v10H50V50z M60,60h10v10H60V60z M70,50h10v10H70V50z M80,60h10v10H80V60z M50,70h10v10H50V70z M80,80h20v20H80V80z M60,90h20v10H60V90z"/>
                                    <rect x="15" y="15" width="10" height="10"/>
                                    <rect x="75" y="15" width="10" height="10"/>
                                    <rect x="15" y="75" width="10" height="10"/>
                                </svg>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-bold text-slate-800">Cara Pakai</p>
                                <p class="text-[10px] text-slate-500 mt-1 leading-relaxed">Buka kamera → arahkan ke kode → ketuk tautan yang muncul</p>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- ── END ACTION CARDS ─────────────────────────── --}}

            </div>
            {{-- END LEFT --}}

            {{-- RIGHT: Phone Mockup (desktop only) --}}
            <div class="hidden lg:flex w-full lg:w-[46%] justify-center items-center">
                {{-- Outer Glow + Wrapper --}}
                <div class="relative" style="width:320px; height:640px;">
                    {{-- Background glow --}}
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-400/20 to-indigo-400/20 rounded-full blur-3xl scale-110 -z-10"></div>

                    {{-- Phone Body --}}
                    <div style="
                        width: 300px;
                        height: 620px;
                        margin: 10px auto 0;
                        border: 10px solid #1e293b;
                        border-radius: 44px;
                        background: #0f172a;
                        position: relative;
                        overflow: hidden;
                        box-shadow: 0 40px 80px rgba(0,0,0,0.35), 0 0 0 1px rgba(255,255,255,0.06);
                    ">
                        {{-- Dynamic Island / Notch --}}
                        <div style="position:absolute; top:10px; left:50%; transform:translateX(-50%); width:90px; height:20px; background:#0f172a; border-radius:12px; z-index:100;"></div>

                        {{-- Screen --}}
                        <div style="position:absolute; inset:0; background:#0f172a; border-radius:34px; overflow:hidden; display:flex; flex-direction:column;">

                            {{-- Status Bar --}}
                            <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 18px 0; font-size:9px; color:rgba(255,255,255,0.75); font-weight:600; flex-shrink:0; margin-top:14px;">
                                <span>9:41</span>
                                <div style="display:flex; align-items:center; gap:4px;">
                                    <i class="ph ph-wifi-high" style="font-size:10px;"></i>
                                    <i class="ph ph-battery-full" style="font-size:11px;"></i>
                                </div>
                            </div>

                            {{-- App Header Bar --}}
                            <div style="background:linear-gradient(135deg,#f97316,#f59e0b); padding:10px 16px 12px; margin-top:8px; display:flex; align-items:center; gap:8px; flex-shrink:0;">
                                <img src="{{ asset('Logo.png') }}" alt="Logo"
                                     style="width:24px;height:24px;border-radius:8px;background:rgba(255,255,255,0.2);object-fit:contain;padding:2px;"
                                     onerror="this.style.display='none'">
                                <div>
                                    <p style="font-size:11px;font-weight:800;color:#fff;line-height:1;">Rumba Athaya</p>
                                    <p style="font-size:7.5px;color:rgba(255,255,255,0.8);margin-top:1px;">Learning Management</p>
                                </div>
                            </div>

                            {{-- App Body --}}
                            <div style="flex:1; display:flex; flex-direction:column; justify-content:center; align-items:center; padding:20px 16px; gap:14px; text-align:center;">
                                {{-- App Icon --}}
                                <div style="width:54px;height:54px;border-radius:16px;background:rgba(249,115,22,0.15);display:flex;align-items:center;justify-content:center;font-size:26px;">
                                    🎓
                                </div>

                                {{-- Greeting --}}
                                <div>
                                    <p style="font-size:12px;font-weight:800;color:#f1f5f9;line-height:1.3;">Portal Siswa & Tutor</p>
                                    <p style="font-size:8.5px;color:#94a3b8;margin-top:4px;line-height:1.5;max-width:200px;">Masuk untuk melihat jadwal, absensi harian, jurnal, dan modul belajar.</p>
                                </div>

                                {{-- Fake Input Fields --}}
                                <div style="width:100%;display:flex;flex-direction:column;gap:8px;">
                                    <div style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;height:34px;display:flex;align-items:center;padding:0 12px;font-size:9.5px;color:#64748b;text-align:left;">
                                        <i class="ph ph-envelope" style="font-size:11px;margin-right:6px;opacity:0.6;"></i>
                                        Email Pengguna
                                    </div>
                                    <div style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.1);border-radius:10px;height:34px;display:flex;align-items:center;padding:0 12px;font-size:9.5px;color:#64748b;text-align:left;">
                                        <i class="ph ph-lock" style="font-size:11px;margin-right:6px;opacity:0.6;"></i>
                                        Kata Sandi
                                    </div>
                                </div>
                            </div>

                            {{-- Login Button + Android Nav --}}
                            <div style="flex-shrink:0;padding:0 16px 0;">
                                <div style="background:linear-gradient(135deg,#f97316,#f59e0b);border-radius:12px;height:36px;display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:#fff;">
                                    <i class="ph ph-sign-in" style="margin-right:5px;font-size:12px;"></i>
                                    Login ke Aplikasi
                                </div>
                            </div>

                            {{-- Android Bottom Nav --}}
                            <div style="height:32px;display:flex;align-items:center;justify-content:space-around;padding:0 40px;margin-top:10px;border-top:1px solid rgba(255,255,255,0.05);">
                                <i class="ph ph-caret-left" style="font-size:12px;color:rgba(255,255,255,0.4);"></i>
                                <div style="width:14px;height:14px;border-radius:50%;border:1.5px solid rgba(255,255,255,0.4);"></div>
                                <div style="width:12px;height:12px;border-radius:3px;border:1.5px solid rgba(255,255,255,0.4);"></div>
                            </div>

                        </div>
                        {{-- END Screen --}}

                    </div>
                    {{-- END Phone Body --}}

                    {{-- Floating Badge: Push Notif (left side, below notch) --}}
                    <div class="absolute animate-float z-20" style="left:-70px; top:100px;">
                        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 flex items-center gap-2.5 px-3 py-2.5">
                            <div class="w-8 h-8 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500 flex-shrink-0">
                                <i class="ph ph-bell text-base"></i>
                            </div>
                            <div class="text-left leading-tight">
                                <p class="text-[10px] font-extrabold text-slate-800">Push Notif</p>
                                <p class="text-[8px] text-slate-400">Realtime & Cepat</p>
                            </div>
                        </div>
                    </div>

                    {{-- Floating Badge: Akses Ringan (right side, above nav bar) --}}
                    <div class="absolute animate-float animation-delay-2000 z-20" style="right:-70px; bottom:130px;">
                        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 flex items-center gap-2.5 px-3 py-2.5">
                            <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center text-green-500 flex-shrink-0">
                                <i class="ph ph-circle-wavy-check text-base"></i>
                            </div>
                            <div class="text-left leading-tight">
                                <p class="text-[10px] font-extrabold text-slate-800">Akses Ringan</p>
                                <p class="text-[8px] text-slate-400">Hemat Kuota HP</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- END RIGHT --}}

        </div>
        {{-- END HERO SECTION --}}


        {{-- ── INSTALLATION STEPS ───────────────────────────────── --}}
        <div class="mt-24 pt-16 border-t border-slate-200">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Panduan Pemasangan Aplikasi</h2>
                <p class="text-slate-500 text-sm mt-2">Ikuti 3 langkah mudah berikut untuk menggunakan aplikasi Rumba Athaya</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Step 1 --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-7 text-center shadow-sm hover:shadow-md transition-shadow flex flex-col items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-lg font-extrabold text-orange-500">1</div>
                    <div>
                        <h3 class="font-bold text-base text-slate-800 mb-2">Unduh APK</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Ketuk tombol <span class="font-bold text-orange-500">"Unduh File APK"</span> di atas untuk menyimpan file instalasi ke handphone Anda.</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-7 text-center shadow-sm hover:shadow-md transition-shadow flex flex-col items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-lg font-extrabold text-orange-500">2</div>
                    <div>
                        <h3 class="font-bold text-base text-slate-800 mb-2">Izinkan Sumber</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Buka Pengaturan → Keamanan HP Anda, lalu aktifkan <span class="font-bold text-slate-700">"Izinkan dari Sumber Tidak Dikenal"</span> jika diminta.</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-7 text-center shadow-sm hover:shadow-md transition-shadow flex flex-col items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-lg font-extrabold text-orange-500">3</div>
                    <div>
                        <h3 class="font-bold text-base text-slate-800 mb-2">Install & Jalankan</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">Buka File Manager, pilih file <span class="font-bold text-slate-700">rumba-athaya.apk</span>, klik Pasang, lalu masuk ke akun Anda.</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- ── END INSTALLATION STEPS ───────────────────────────── --}}

    </div>
</div>
@endsection
