@extends('layouts.landing')

@section('title', 'Beranda')

@section('content')
@php
    // Fetch data for landing page
    $posts = \App\Models\Post::where('is_published', true)
        ->orderBy('published_at', 'desc')
        ->limit(6)
        ->get();
    
    $tutors = \App\Models\User::where('role', 'tutor')
        ->limit(6)
        ->get();
    
    $testimonials = \App\Models\Testimonial::where('is_published', true)
        ->limit(6)
        ->get();

    // Fetch student data
    $studentCount = \App\Models\Student::count();
    $latestStudents = \App\Models\Student::with('user')->latest()->take(3)->get();
@endphp

<div class="web-only-layout min-h-screen">
    <!-- Hero Section - Enhanced & Vibrant -->
    <section id="home" class="relative pt-20 sm:pt-24 md:pt-28 pb-20 sm:pb-24 md:pb-28 overflow-hidden bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50">
        <!-- Animated Background Blobs -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-orange-300/30 to-amber-300/30 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-br from-blue-300/30 to-indigo-300/30 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-gradient-to-br from-purple-300/30 to-pink-300/30 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <!-- Floating Decorative Elements (Clean Geometric Patterns instead of Emojis) -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-8 h-8 rounded-full border-2 border-indigo-200/40 animate-float"></div>
            <div class="absolute top-40 right-20 w-6 h-6 rounded-lg bg-orange-200/20 rotate-45 animate-float animation-delay-1000"></div>
            <div class="absolute bottom-40 left-20 w-10 h-10 border border-amber-200/30 rounded-lg animate-float animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-10 lg:gap-12 items-center" x-data="{ showed: false }" x-init="setTimeout(() => showed = true, 100)">
            <div class="relative z-10 text-center lg:text-left">
                <div>
                    
                    <!-- Badge: Bimbel Terbaik - Minimalist & Premium -->
                    <div x-show="showed" 
                          x-transition:enter="transition ease-out duration-700"
                          x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                          x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                          class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-orange-50 border border-orange-200 text-brand-orange rounded-full mb-4 sm:mb-5 shadow-sm">
                        <i class="ph ph-trophy text-sm"></i>
                        <span class="text-[10px] sm:text-xs font-bold tracking-wider uppercase">Bimbel Terbaik Sejak 2023</span>
                    </div>
                    
                    <!-- Main Heading - Clean Typographical Contrast -->
                    <h1 x-show="showed" 
                        x-transition:enter="transition ease-out duration-700 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 leading-tight mb-3 sm:mb-4 tracking-tight">
                        Belajar Lebih <span class="text-indigo-600">Seru</span>, <br/>
                        Prestasi Lebih <span class="text-brand-orange">Cemerlang</span>!
                    </h1>
                    
                    <!-- Description - Clean & Human-Crafted -->
                    <p x-show="showed" 
                       x-transition:enter="transition ease-out duration-700 delay-200"
                       x-transition:enter-start="opacity-0 translate-y-10"
                       x-transition:enter-end="opacity-100 translate-y-0"
                       class="text-base sm:text-lg md:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-medium mb-5 sm:mb-8">
                        Platform bimbingan belajar premium yang berfokus membangun suasana belajar aktif, menyenangkan, dan efektif untuk meraih potensi akademik terbaik.
                    </p>
                    
                    <!-- CTA Buttons - Professional & Human -->
                    <div x-show="showed" 
                          x-transition:enter="transition ease-out duration-700 delay-300"
                          x-transition:enter-start="opacity-0 translate-y-10"
                          x-transition:enter-end="opacity-100 translate-y-0"
                          class="flex flex-wrap gap-3 sm:gap-4 pt-2 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="group relative px-6 sm:px-8 py-3.5 sm:py-4 bg-gradient-to-r from-orange-500 to-amber-600 text-white rounded-xl font-bold text-sm sm:text-base hover:shadow-xl hover:shadow-orange-500/30 transition-all duration-300 flex items-center gap-2 overflow-hidden transform hover:scale-[1.02]">
                            <span class="absolute inset-0 bg-gradient-to-r from-orange-600 to-amber-700 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            <span class="relative z-10 flex items-center gap-1.5">
                                <span>Daftar Sekarang</span>
                                <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </span>
                        </a>
                        <a href="#program" class="group px-6 sm:px-8 py-3.5 sm:py-4 bg-white text-slate-700 border-2 border-slate-200 rounded-xl font-bold hover:border-brand-orange hover:text-brand-orange hover:bg-orange-50/50 transition-all duration-300 text-sm sm:text-base flex items-center gap-1.5 shadow-sm transform hover:scale-[1.02]">
                            <i class="ph ph-book-open text-base sm:text-lg"></i>
                            <span>Lihat Program</span>
                        </a>
                    </div>
                    
                    <!-- Social Proof - Redesigned -->
                    <div x-show="showed" 
                         x-transition:enter="transition ease-out duration-700 delay-500"
                         x-transition:enter-start="opacity-0 translate-y-10"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="inline-flex items-center gap-4 pt-4 sm:pt-6 justify-center lg:justify-start">
                        <div class="flex -space-x-3">
                            @foreach($latestStudents->take(3) as $index => $student)
                                @php
                                    $colors = [
                                        ['bg' => 'bg-orange-500', 'border' => 'border-orange-300'],
                                        ['bg' => 'bg-blue-500', 'border' => 'border-blue-300'],
                                        ['bg' => 'bg-purple-500', 'border' => 'border-purple-300']
                                    ];
                                    $color = $colors[$index % count($colors)];
                                    // Get first letter only for cleaner look
                                    $initial = strtoupper(substr($student->name, 0, 1));
                                @endphp
                                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full border-3 border-white {{ $color['bg'] }} flex items-center justify-center text-white text-base sm:text-lg font-extrabold overflow-hidden shadow-lg ring-2 {{ $color['border'] }}" title="{{ $student->name }}">
                                    @if($student->user && $student->user->avatar_url)
                                        <img src="{{ $student->user->avatar_url }}" alt="{{ $student->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ $initial }}
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="text-left">
                            <p class="font-extrabold text-slate-900 text-base sm:text-lg leading-tight">{{ $studentCount }}+ Siswa Aktif</p>
                            <p class="text-sm text-orange-600 font-semibold flex items-center gap-1">
                                <span class="text-yellow-500">⭐⭐⭐⭐⭐</span>
                                <span>4.9/5</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Image - More Dynamic -->
            <div x-show="showed" 
                 x-transition:enter="transition ease-out duration-1000 delay-300"
                 x-transition:enter-start="opacity-0 translate-x-10 scale-95"
                 x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                 class="relative lg:ml-10 mt-8 lg:mt-0">
                <div class="relative z-10 rounded-2xl sm:rounded-[2rem] lg:rounded-[2.5rem] overflow-hidden shadow-2xl border-4 sm:border-8 border-white transform hover:rotate-0 rotate-2 transition-transform duration-500">
                    <div class="relative w-full h-[300px] sm:h-[400px] md:h-[450px] lg:h-[500px] bg-gradient-to-br from-orange-400/30 to-amber-300/30 overflow-hidden rounded-2xl">
                        <img src="{{ asset('gambar herosection.png') }}" alt="Kegiatan Belajar" class="w-full h-full object-cover hover:scale-110 transition-transform duration-700" onerror="this.src='https://via.placeholder.com/500x500/f97316/ffffff?text=Rumba+Athaya'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-6 sm:bottom-8 left-6 sm:left-8 text-white">
                            <p class="font-extrabold text-base sm:text-xl lg:text-2xl mb-2">Program Rumba Athaya 🎯</p>
                            <div class="flex items-center gap-2">
                                <div class="flex text-yellow-400 text-lg">★★★★★</div>
                                <p class="text-yellow-300 text-sm sm:text-base font-bold">4.9/5 Rating</p>
                            </div>
                        </div>
                <!-- Floating Mascot -->
                <div class="absolute -bottom-10 -left-10 w-28 h-28 z-20 hidden lg:block transform hover:scale-110 transition-transform duration-300">
                    <img src="{{ asset('maskot.png') }}" alt="Mascot Rumba" class="w-full h-full object-contain filter drop-shadow-xl animate-float">
                </div>
            </div>

                <!-- Floating Achievement Cards - More Vibrant -->
                <div class="absolute -top-6 -left-6 sm:-top-8 sm:-left-8 bg-gradient-to-br from-blue-500 to-indigo-600 p-4 sm:p-5 rounded-2xl shadow-2xl z-20 hidden sm:block transform hover:scale-110 transition-transform animate-bounce-slow">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white text-2xl">
                            ✅
                        </div>
                        <div class="text-white">
                            <p class="text-xs font-medium opacity-90">Prestasi</p>
                            <p class="font-extrabold text-2xl">Terbaik</p>
                        </div>
                    </div>
                </div>

                <div class="absolute -bottom-8 -right-6 sm:-bottom-10 sm:-right-8 bg-gradient-to-br from-orange-500 to-amber-600 p-4 sm:p-5 rounded-2xl shadow-2xl z-20 hidden sm:block transform hover:scale-110 transition-transform animate-bounce-slow animation-delay-1000">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white text-2xl">
                            👨‍🏫
                        </div>
                        <div class="text-white">
                            <p class="text-xs font-medium opacity-90">Tutor</p>
                            <p class="font-extrabold text-xl">Berpengalaman</p>
                        </div>
                    </div>
                </div>

                <!-- New Floating Card - Success Stories -->
                <div class="absolute top-1/2 -right-4 sm:-right-6 bg-gradient-to-br from-purple-500 to-pink-600 p-3 sm:p-4 rounded-xl shadow-2xl z-20 hidden lg:block transform hover:scale-110 transition-transform animate-pulse-slow">
                    <div class="text-white text-center">
                        <p class="font-extrabold text-3xl">500+</p>
                        <p class="text-xs font-medium">Siswa Sukses</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <!-- Integrasi LMS Section -->
    <section class="py-12 sm:py-16 md:py-20 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-indigo-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 font-bold text-xs uppercase tracking-wider mb-4 animate-bounce-slow">
                    <i class="ph-fill ph-circles-three-plus"></i>
                    <span>Ekosistem Digital 4.0</span>
                </div>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight">
                    Sistem Belajar <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Modern & Terintegrasi</span>
                </h2>
                <p class="text-slate-600 text-lg leading-relaxed">
                    Kami tidak hanya sekedar bimbel, tapi ekosistem belajar digital yang lengkap untuk mendukung kesuksesan siswa.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
                <!-- Feature 1 -->
                <div class="group p-4 sm:p-8 rounded-3xl bg-white border border-slate-100/80 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-orange-400 to-amber-500 text-white flex items-center justify-center text-xl sm:text-3xl mb-4 sm:mb-6 shadow-lg shadow-orange-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="ph-duotone ph-book-open-text"></i>
                    </div>
                    <h3 class="text-sm sm:text-xl font-extrabold text-slate-900 mb-2 sm:mb-3">Akses Materi 24/7</h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                        Modul belajar, video pembahasan, dan bank soal yang bisa diakses kapanpun siswa mau belajar.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group p-4 sm:p-8 rounded-3xl bg-white border border-slate-100/80 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white flex items-center justify-center text-xl sm:text-3xl mb-4 sm:mb-6 shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="ph-duotone ph-monitor-play"></i>
                    </div>
                    <h3 class="text-sm sm:text-xl font-extrabold text-slate-900 mb-2 sm:mb-3">Ujian Berbasis CBT</h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                        Simulasi ujian mirip UNBK/ANBK untuk melatih kesiapan mental dan skill manajemen waktu.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group p-4 sm:p-8 rounded-3xl bg-white border border-slate-100/80 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 text-white flex items-center justify-center text-xl sm:text-3xl mb-4 sm:mb-6 shadow-lg shadow-purple-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="ph-duotone ph-chart-line-up"></i>
                    </div>
                    <h3 class="text-sm sm:text-xl font-extrabold text-slate-900 mb-2 sm:mb-3">Rapor Progress</h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                        Pantau grafik perkembangan nilai dan absensi siswa secara real-time melalui dashboard.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group p-4 sm:p-8 rounded-3xl bg-white border border-slate-100/80 shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex items-center justify-center text-xl sm:text-3xl mb-4 sm:mb-6 shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="ph-duotone ph-images"></i>
                    </div>
                    <h3 class="text-sm sm:text-xl font-extrabold text-slate-900 mb-2 sm:mb-3">Galeri Kegiatan</h3>
                    <p class="text-slate-500 text-xs sm:text-sm leading-relaxed">
                        Dokumentasi lengkap kegiatan belajar seru, outbond, dan momen prestasi siswa.
                    </p>
                </div>
            </div>

            <!-- Mobile App Promotion Banner -->
            <div id="app-promo-banner" class="mt-16 relative overflow-hidden rounded-3xl bg-gradient-to-br from-amber-50/60 via-orange-50/30 to-white p-8 md:p-10 shadow-md border border-orange-100/70">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-orange-100/40 rounded-full blur-2xl pointer-events-none"></div>
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                    <div class="lg:col-span-8 space-y-4 text-center lg:text-left">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-100/60 rounded-full text-xs font-bold text-orange-700">
                            <i class="ph ph-android-logo text-sm"></i>
                            <span>Aplikasi Android Resmi</span>
                        </div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight">
                            Belajar Lebih Praktis Lewat Aplikasi Mobile
                        </h3>
                        <p class="text-slate-600 text-sm sm:text-base max-w-2xl leading-relaxed">
                            Unduh aplikasi <strong>Rumba Athaya</strong> untuk memantau modul belajar, jadwal kelas terbaru, serta laporan perkembangan presensi dan nilai siswa secara langsung dan mudah.
                        </p>
                    </div>
                    <div class="lg:col-span-4 flex flex-col items-center lg:items-end justify-center gap-3">
                        <a href="{{ route('download') }}" 
                           class="w-full sm:w-auto px-8 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl text-center shadow-sm transition duration-150">
                            <i class="ph ph-download-simple text-base mr-1"></i> Unduh Sekarang
                        </a>
                        <span class="text-xs text-slate-400">Ukuran file hanya ~5.2 MB</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formula 3B Section -->
    <section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-12 md:mb-16">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900">
                        Kunci Sukses: <span class="text-brand-orange">Formula 3B</span>
                    </h2>
                    <p class="mt-3 sm:mt-4 text-gray-500 text-base sm:text-lg">
                        Metode khusus kami untuk memastikan kesuksesan Sahabat Rumba.
                    </p>
                </div>
            </div>
            
            <div class="grid grid-cols-3 lg:grid-cols-3 gap-3 sm:gap-8 md:gap-10">
                @php
                    $formulas = [
                        [
                            'number' => '1', 
                            'title' => 'Belajar', 
                            'description' => 'Suasana belajar yang interaktif, mudah dipahami, dan jauh dari kesan membosankan.', 
                            'icon' => 'ph-book-open-text',
                            'iconBg' => 'bg-blue-600',
                            'bgColor' => 'bg-blue-50',
                            'shadowColor' => 'shadow-blue-500/30'
                        ],
                        [
                            'number' => '2', 
                            'title' => 'Berlatih', 
                            'description' => 'Latihan soal terstruktur & terukur untuk mengasah kemampuan secara konsisten.', 
                            'icon' => 'ph-pencil-circle',
                            'iconBg' => 'bg-brand-orange',
                            'bgColor' => 'bg-orange-50',
                            'shadowColor' => 'shadow-orange-500/30'
                        ],
                        [
                            'number' => '3', 
                            'title' => 'Berprestasi', 
                            'description' => 'Peningkatan nilai rapor dan pencapaian prestasi akademik terbaik.', 
                            'icon' => 'ph-trophy',
                            'iconBg' => 'bg-green-500',
                            'bgColor' => 'bg-green-50',
                            'shadowColor' => 'shadow-green-500/30'
                        ],
                    ];
                @endphp
                @foreach($formulas as $index => $formula)
                    <div x-data="{ loaded: false }"
                         x-intersect.once="loaded = true"
                         :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         class="group p-3 sm:p-8 rounded-2xl sm:rounded-[2rem] bg-white/60 backdrop-blur-xl border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] transition-all duration-700 transform relative overflow-hidden cursor-pointer hover:-translate-y-2 hover:scale-[1.02]"
                         style="transition-delay: {{ $index * 100 }}ms">
                        <div class="absolute top-0 right-0 w-16 h-16 sm:w-32 sm:h-32 {{ $formula['bgColor'] }} rounded-bl-[2rem] sm:rounded-bl-[4rem] -mr-4 -mt-4 sm:-mr-8 sm:-mt-8 transition-transform group-hover:scale-110"></div>
                        <div class="w-10 h-10 sm:w-16 sm:h-16 {{ $formula['iconBg'] }} text-white rounded-xl sm:rounded-2xl flex items-center justify-center text-xl sm:text-3xl mb-4 sm:mb-6 shadow-lg {{ $formula['shadowColor'] }} relative z-10"
                             x-data="{ hovered: false }"
                             @mouseenter="hovered = true"
                             @mouseleave="hovered = false"
                             :style="hovered ? 'transform: scale(1.1) rotate(5deg)' : ''"
                             style="transition: transform 0.2s;">
                            <i class="ph {{ $formula['icon'] }}"></i>
                        </div>
                        <h3 class="text-xs sm:text-2xl font-extrabold text-slate-900 mb-2 sm:mb-3 relative z-10">
                            {{ $formula['number'] }}. {{ $formula['title'] }}
                        </h3>
                        <p class="text-[10px] sm:text-base text-gray-500 leading-relaxed font-medium relative z-10">
                            {{ $formula['description'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="scroll-mt-20 py-24 px-6 relative bg-slate-50">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-sm font-bold text-indigo-600 uppercase tracking-widest mb-3">Keunggulan Kami</h2>
                <h3 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Kenapa Memilih <span class="text-indigo-600">Rumba?</span></h3>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg font-medium leading-relaxed">
                    Metode pembelajaran yang dirancang khusus untuk memaksimalkan potensi setiap siswa dengan cara yang menyenangkan dan terukur. Kami memahami bahwa setiap Sahabat Rumba memiliki keunikan dan potensi yang berbeda, oleh karena itu kami menyediakan pendekatan pembelajaran yang personal dan efektif.
                </p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @php
                    $features = [
                        ['icon' => 'target', 'title' => 'Kurikulum Terstruktur', 'description' => 'Materi disusun sistematis sesuai kurikulum nasional terbaru untuk memastikan pemahaman menyeluruh.', 'color' => 'bg-indigo-500'],
                        ['icon' => 'users', 'title' => 'Tutor Berpengalaman', 'description' => 'Belajar langsung dari pengajar terbaik lulusan universitas ternama yang sabar dan kompeten.', 'color' => 'bg-rose-500'],
                        ['icon' => 'rocket', 'title' => 'Metode Interaktif', 'description' => 'Tidak membosankan! Belajar dengan video, kuis, dan diskusi langsung yang menarik.', 'color' => 'bg-amber-500'],
                        ['icon' => 'book', 'title' => 'Bank Soal Lengkap', 'description' => 'Ribuan latihan soal dan pembahasan untuk persiapan ujian sekolah maupun nasional.', 'color' => 'bg-emerald-500'],
                        ['icon' => 'graduation', 'title' => 'Konsultasi Jurusan', 'description' => 'Bimbingan karir dan pemilihan jurusan kuliah sesuai minat dan bakat siswa.', 'color' => 'bg-blue-500'],
                        ['icon' => 'star', 'title' => 'Laporan Berkala', 'description' => 'Pantau perkembangan belajar melalui laporan hasil belajar yang dikirim setiap bulan.', 'color' => 'bg-violet-500'],
                    ];
                @endphp
                @foreach($features as $index => $feature)
                    <div x-data="{ loaded: false }"
                         x-intersect.once="loaded = true"
                         :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         class="p-4 sm:p-8 rounded-[2rem] bg-white/60 backdrop-blur-xl border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] transition-all duration-700 transform group cursor-pointer hover:-translate-y-2 hover:scale-[1.02]"
                         style="transition-delay: {{ ($index + 1) * 100 }}ms">
                        <div class="w-10 h-10 sm:w-14 sm:h-14 {{ $feature['color'] }} text-white rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            @if($feature['icon'] == 'target')
                                <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            @elseif($feature['icon'] == 'users')
                                <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            @elseif($feature['icon'] == 'rocket')
                                <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            @elseif($feature['icon'] == 'book')
                                <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            @elseif($feature['icon'] == 'graduation')
                                <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            @else
                                <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                        </div>
                        <h3 class="text-xs sm:text-xl font-extrabold text-slate-800 mb-2 sm:mb-3 tracking-tight">{{ $feature['title'] }}</h3>
                        <p class="text-slate-500 leading-relaxed font-medium text-[10px] sm:text-sm">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="program" class="scroll-mt-20 py-12 sm:py-16 md:py-20 lg:py-24 bg-slate-50 relative">
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-[0]">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-[calc(100%+1.3px)] h-[50px] fill-white">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 sm:mb-10 md:mb-12 gap-4">
                <div>
                    <span class="text-brand-blue font-bold tracking-wider uppercase text-xs sm:text-sm bg-blue-100 px-3 py-1 rounded-full">
                        Program Kami
                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 sm:mt-3">
                        Pilihan Program Rumba Athaya
                    </h2>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @php
                    $programs = [
                        [
                            'id' => 'calistung-tk',
                            'title' => 'Calistung TK',
                            'description' => 'Program ini dibuat khusus untuk Sahabat Rumba Athaya yang masih duduk di Taman Kanak-kanak agar bisa lebih cepat membaca, menulis serta menghitung.',
                            'badge' => 'TK',
                            'badgeColor' => 'bg-white/90 backdrop-blur text-pink-600',
                            'buttonColor' => 'border-pink-100 text-pink-500 hover:bg-pink-500 hover:text-white',
                            'features' => null,
                            'featured' => false
                        ],
                        [
                            'id' => 'sd-kelas-1-3',
                            'title' => 'SD Kelas 1-3',
                            'description' => 'Sahabat Rumba yang masih duduk di sekolah dasar pasti mau kan jadi juara di sekolah. Rumba Athaya bisa banget bantu kamu agar nilai rapormu meningkat.',
                            'badge' => 'SD Awal',
                            'badgeColor' => 'bg-white/90 backdrop-blur text-brand-orange',
                            'buttonColor' => 'border-orange-100 text-brand-orange hover:bg-brand-orange hover:text-white',
                            'features' => ['Calistung Lancar', 'Bantuan PR Harian'],
                            'featured' => false
                        ],
                        [
                            'id' => 'sd-kelas-4-6',
                            'title' => 'SD Kelas 4-6',
                            'description' => 'Sahabat Rumba yang masih duduk di sekolah dasar pasti mau kan jadi juara di sekolah dan masuk ke SMP favorit? Rumba Athaya bisa banget bantu kamu.',
                            'badge' => 'Siap SMP',
                            'badgeColor' => 'bg-white/90 backdrop-blur text-red-600',
                            'buttonColor' => 'border-red-100 text-red-500 hover:bg-red-500 hover:text-white',
                            'features' => ['Persiapan Ujian', 'Latihan Soal Terstruktur'],
                            'featured' => false
                        ],
                        [
                            'id' => 'smp-kelas-7-9',
                            'title' => 'SMP Kelas 7-9',
                            'description' => 'Sahabat Rumba Athaya yang masih duduk di bangku SMP pasti mau kan jadi juara di sekolah dan masuk ke SMA favorit? Melalui aplikasi Rumba Athaya akan BERTANDING dengan mengikuti Try Out yang bisa diakses di mana saja.',
                            'badge' => 'Siap SMA',
                            'badgeColor' => 'bg-white/90 backdrop-blur text-brand-blue',
                            'buttonColor' => 'border-blue-100 text-brand-blue hover:bg-brand-blue hover:text-white',
                            'features' => ['Try Out Apps', 'Tutor PTN'],
                            'featured' => false
                        ],
                        [
                            'id' => 'kelas-tahfidz',
                            'title' => 'Kelas Tahfidz',
                            'description' => 'Sahabat Rumba Athaya yang ingin mendalami ilmu agama terutama hafalan serta tahsin kami di Bimbel Rumba Athaya juga mengakomodir kebutuhan Sahabat Rumba Athaya. Yuk pokoknya lengkap banget!',
                            'badge' => 'Agama',
                            'badgeColor' => 'bg-white/90 backdrop-blur text-green-600',
                            'buttonColor' => 'border-green-100 text-green-600 hover:bg-green-500 hover:text-white',
                            'features' => ['Hafalan Al-Qur\'an', 'Tahsin & Tajwid'],
                            'featured' => true
                        ],
                    ];
                @endphp
                @foreach($programs as $index => $program)
                    <div x-data="{ loaded: false }"
                         x-intersect.once="loaded = true"
                         :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         style="transition-delay: {{ $index * 100 }}ms"
                         class="bg-white rounded-2xl sm:rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 overflow-hidden group hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:-translate-y-2 hover:scale-[1.02] transition-all duration-700 transform flex flex-col relative">
                        @if($program['featured'])
                            <div class="absolute top-0 right-0 bg-emerald-500 text-white text-[9px] sm:text-xs font-bold px-2 sm:px-3 py-0.5 sm:py-1 rounded-bl-lg z-20">
                                Unggulan
                            </div>
                        @endif
                        <div class="h-24 sm:h-32 relative p-4 sm:p-6 flex flex-col justify-between overflow-hidden">
                            <img src="{{ asset('gambar herosection.png') }}" alt="{{ $program['title'] }}" class="absolute inset-0 w-full h-full object-cover" onerror="this.style.display='none'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent"></div>
                            <span class="{{ $program['badgeColor'] }} px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-[9px] sm:text-xs font-black w-fit shadow-sm relative z-10">
                                {{ $program['badge'] }}
                            </span>
                        </div>
                        <div class="p-4 sm:p-8 flex flex-col flex-1">
                            <h3 class="text-sm sm:text-xl font-extrabold text-slate-900 mb-1 sm:mb-2">{{ $program['title'] }}</h3>
                            <p class="text-slate-500 text-[10px] sm:text-sm mb-3 sm:mb-4 line-clamp-2 sm:line-clamp-none leading-relaxed flex-1">
                                {{ $program['description'] }}
                            </p>
                            @if($program['features'])
                                <ul class="space-y-1.5 mb-4 hidden sm:block">
                                    @foreach($program['features'] as $feature)
                                        <li class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class="ph ph-check-circle text-green-500"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <a href="{{ route('program.show', $program['id']) }}" class="flex items-center justify-center gap-1 w-full py-2 sm:py-3 rounded-lg sm:rounded-xl border-2 text-[10px] sm:text-base font-bold transition mt-auto {{ $program['buttonColor'] }}">
                                <i class="ph ph-eye text-xs sm:text-base"></i>
                                <span>Lihat Program</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sahabat RA (Posts) Section — REDESIGNED -->
    <section id="sahabatra" class="scroll-mt-20 py-16 sm:py-20 md:py-28 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute inset-0 bg-gradient-to-br from-slate-50 via-orange-50/40 to-amber-50/60 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-gradient-to-bl from-orange-200/20 to-transparent rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-gradient-to-tr from-amber-200/20 to-transparent rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <!-- Section Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-10 sm:mb-14 gap-6"
                 x-data="{ loaded: false }" x-intersect.once="loaded = true"
                 :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                 style="transition: all 0.6s cubic-bezier(0.4,0,0.2,1);">
                <div>
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2.5 px-4 py-2 bg-white border border-orange-200/80 rounded-full shadow-sm shadow-orange-100 mb-5">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-orange-500"></span>
                        </span>
                        <span class="text-xs font-bold text-orange-600 tracking-widest uppercase">📰 Mading Online</span>
                    </div>

                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight leading-tight">
                        Kabar dari <span class="relative">
                            <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-500 via-amber-500 to-rose-500">Sahabat RA</span>
                            <svg class="absolute -bottom-1 left-0 w-full" viewBox="0 0 200 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1 5.5C50 1.5 100 7 150 3.5C175 1.5 190 4 199 3.5" stroke="url(#underlineGrad)" stroke-width="3" stroke-linecap="round"/>
                                <defs><linearGradient id="underlineGrad" x1="0" y1="0" x2="200" y2="0" gradientUnits="userSpaceOnUse"><stop stop-color="#F97316"/><stop offset="0.5" stop-color="#F59E0B"/><stop offset="1" stop-color="#EF4444"/></linearGradient></defs>
                            </svg>
                        </span>
                    </h2>
                    <p class="text-slate-500 mt-3 text-base sm:text-lg font-medium max-w-xl">
                        Kabar terbaru, karya siswa, dan inspirasi belajar dari keluarga besar Rumba Athaya.
                    </p>
                </div>

                <a href="{{ route('posts.index') }}"
                   class="group hidden lg:flex items-center gap-2.5 px-7 py-3.5 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-2xl font-bold text-sm shadow-lg shadow-orange-400/30 hover:shadow-xl hover:shadow-orange-400/40 hover:-translate-y-1 hover:scale-105 transition-all duration-300">
                    <i class="ph ph-newspaper text-lg"></i>
                    <span>Lihat Semua Artikel</span>
                    <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform duration-200"></i>
                </a>
            </div>

            @if($posts->count() > 0)
                @php
                    $postsForMading = $posts->take(6);
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8">

                    <!-- ===== FEATURED POST - Mobile: post #1 only, Desktop: post #1 & #2 ===== -->
                    <div class="lg:col-span-3 flex flex-col gap-6">
                        @foreach($postsForMading->take(2) as $index => $featuredPost)
                            @php
                                $catColors = ['Kabar Rumba' => 'from-blue-500 to-indigo-500', 'Karya Siswa' => 'from-orange-500 to-rose-500', 'Info' => 'from-emerald-500 to-teal-500'];
                                $catGrad = $catColors[$featuredPost->category] ?? 'from-slate-500 to-slate-600';
                            @endphp
                            {{-- Post #2 hidden on mobile, visible on desktop --}}
                            <div style="{{ $index === 1 ? 'display:none;' : '' }}"
                                 class="{{ $index === 1 ? 'lg:!block' : '' }}">
                                <a href="{{ route('posts.show', $featuredPost->slug) }}"
                                   class="group block relative rounded-[2rem] overflow-hidden shadow-xl shadow-slate-200/60 hover:shadow-2xl hover:shadow-orange-200/40 hover:-translate-y-2 transition-all duration-500">
                                    <div class="relative h-72 sm:h-80 lg:h-[328px] overflow-hidden">
                                        @if($featuredPost->thumbnail)
                                            <img src="{{ $featuredPost->thumbnail_url }}"
                                                 alt="{{ $featuredPost->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-orange-400 via-amber-400 to-rose-400 text-white/30" style="display: none;">
                                                <i class="ph ph-newspaper text-8xl"></i>
                                            </div>
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-orange-400 via-amber-400 to-rose-400 flex items-center justify-center">
                                                <i class="ph ph-newspaper text-8xl text-white/30"></i>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                                        <div class="absolute top-5 left-5">
                                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-gradient-to-r {{ $catGrad }} text-white text-xs font-bold rounded-full shadow-lg backdrop-blur-sm">
                                                <i class="ph ph-tag-simple"></i>
                                                {{ $featuredPost->category ?? 'Artikel' }}
                                            </span>
                                        </div>
                                        @if($loop->first)
                                            <div class="absolute top-5 right-5">
                                                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-white/20 backdrop-blur-md text-white text-xs font-bold rounded-full border border-white/30">
                                                    ⭐ Pilihan Editor
                                                </span>
                                            </div>
                                        @endif
                                        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                                            <h3 class="text-xl lg:text-2xl font-extrabold text-white mb-2 leading-tight group-hover:text-amber-300 transition-colors duration-300 line-clamp-2">
                                                {{ $featuredPost->title }}
                                            </h3>
                                            <div class="flex items-center justify-between gap-4">
                                                <div class="flex items-center gap-2 text-white/70 text-sm">
                                                    @if($featuredPost->published_at)
                                                        <i class="ph ph-calendar text-orange-300"></i>
                                                        <span>{{ $featuredPost->published_at->format('d M Y') }}</span>
                                                    @endif
                                                </div>
                                                <span class="flex items-center gap-2 text-amber-300 font-bold text-sm group-hover:gap-3 transition-all duration-300">
                                                    Baca Artikel <i class="ph ph-arrow-right"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- ===== SIDE CARDS ===== -->
                    {{--
                        Mobile : grid-cols-2, shows posts #2–#5 (skip 1, take 4)
                        Desktop: grid-cols-1, shows posts #3–#6 (skip 2, take 4)
                        Completely separate loops — no index confusion, no duplicates.
                    --}}

                    {{-- MOBILE side cards: posts #2–#5, 2-column grid --}}
                    <div class="grid grid-cols-2 gap-4 lg:hidden">
                        @foreach($postsForMading->skip(1)->take(4) as $post)
                            @php
                                $catColorsSmall = ['Kabar Rumba' => 'bg-blue-100 text-blue-700 border-blue-200', 'Karya Siswa' => 'bg-orange-100 text-orange-700 border-orange-200', 'Info' => 'bg-emerald-100 text-emerald-700 border-emerald-200'];
                                $catClass = $catColorsSmall[$post->category] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                            @endphp
                            <a href="{{ route('posts.show', $post->slug) }}"
                               class="group flex flex-col gap-2 p-3 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:shadow-orange-100/50 transition-all duration-300">
                                <div class="w-full h-24 rounded-xl overflow-hidden flex-shrink-0 bg-gradient-to-br from-orange-100 to-amber-100 relative">
                                    @if($post->thumbnail)
                                        <img src="{{ $post->thumbnail_url }}"
                                             alt="{{ $post->title }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-orange-100 to-amber-100 text-orange-300" style="display: none;">
                                            <i class="ph ph-image text-3xl"></i>
                                        </div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="ph ph-image text-3xl text-orange-300"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-bold border {{ $catClass }} mb-1">
                                        {{ $post->category ?? 'Artikel' }}
                                    </span>
                                    <h3 class="font-bold text-slate-800 text-xs leading-snug line-clamp-2 group-hover:text-orange-500 transition-colors duration-200">
                                        {{ $post->title }}
                                    </h3>
                                    @if($post->published_at)
                                        <span class="text-[9px] text-slate-400 flex items-center gap-1 mt-1">
                                            <i class="ph ph-calendar"></i>
                                            {{ $post->published_at->format('d M Y') }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- DESKTOP side cards: posts #3–#6, single-column list --}}
                    <div class="hidden lg:flex lg:col-span-2 flex-col gap-6">
                        @foreach($postsForMading->skip(2)->take(4) as $index => $post)
                            @php
                                $catColorsSmall = ['Kabar Rumba' => 'bg-blue-100 text-blue-700 border-blue-200', 'Karya Siswa' => 'bg-orange-100 text-orange-700 border-orange-200', 'Info' => 'bg-emerald-100 text-emerald-700 border-emerald-200'];
                                $catClass = $catColorsSmall[$post->category] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                            @endphp
                            <a href="{{ route('posts.show', $post->slug) }}"
                               class="group flex flex-row gap-4 p-4 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg hover:shadow-orange-100/50 hover:-translate-y-1 hover:border-orange-200/60 transition-all duration-300">
                                <div class="w-28 h-28 rounded-xl overflow-hidden flex-shrink-0 bg-gradient-to-br from-orange-100 to-amber-100 relative">
                                    @if($post->thumbnail)
                                        <img src="{{ $post->thumbnail_url }}"
                                             alt="{{ $post->title }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-orange-100 to-amber-100 text-orange-300" style="display: none;">
                                            <i class="ph ph-image text-3xl"></i>
                                        </div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="ph ph-image text-3xl text-orange-300"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0 flex flex-col justify-between py-0.5">
                                    <div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold border {{ $catClass }} mb-2">
                                            {{ $post->category ?? 'Artikel' }}
                                        </span>
                                        <h3 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 group-hover:text-orange-500 transition-colors duration-200">
                                            {{ $post->title }}
                                        </h3>
                                    </div>
                                    <div class="flex items-center justify-between mt-2">
                                        @if($post->published_at)
                                            <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                                <i class="ph ph-calendar"></i>
                                                {{ $post->published_at->format('d M Y') }}
                                            </span>
                                        @endif
                                        <span class="text-[11px] font-bold text-orange-500 flex items-center gap-0.5 group-hover:gap-1.5 transition-all">
                                            Baca <i class="ph ph-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Lihat Semua Artikel — Mobile only, full-width, below grid -->
                <div class="mt-6 lg:hidden">
                    <a href="{{ route('posts.index') }}"
                       class="flex items-center justify-center gap-2 w-full py-3.5 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-xl font-bold text-sm shadow-md shadow-orange-300/30 hover:shadow-lg transition-all duration-300 active:scale-95">
                        <i class="ph ph-newspaper text-lg"></i>
                        <span>Lihat Semua Artikel</span>
                    </a>
                </div>

            @else
                <!-- Empty State -->
                <div class="text-center py-20 bg-white/60 backdrop-blur-sm rounded-3xl border border-slate-100 shadow-sm"
                     x-data="{ loaded: false }" x-intersect.once="loaded = true"
                     :class="loaded ? 'opacity-100 scale-100' : 'opacity-0 scale-95'"
                     style="transition: all 0.6s ease;">
                    <div class="w-20 h-20 bg-orange-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <i class="ph ph-newspaper text-4xl text-orange-400"></i>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2">Mading Segera Hadir!</h3>
                    <p class="text-slate-500 mb-8 max-w-md mx-auto">Kabar terbaru dan karya siswa Rumba Athaya akan segera dipublikasikan di sini.</p>
                    <a href="{{ route('posts.index') }}"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-2xl font-bold shadow-lg shadow-orange-300/30 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <i class="ph ph-newspaper"></i>
                        <span>Kunjungi Sahabat RA</span>
                    </a>
                </div>
            @endif
        </div>
    </section>


    <!-- Tutors Section -->
    @if($tutors->count() > 0)
    <section class="py-16 sm:py-20 bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12 md:mb-16">
                <div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">
                        Tutor <span class="text-indigo-600">Rumba Athaya</span>
                    </h2>
                    <p class="text-slate-500 text-base sm:text-lg font-medium leading-relaxed">
                        Tutor berpengalaman dari berbagai PTN yang memotivasi dan memantau perkembangan Sahabat Rumba dengan pemantauan yang akan disampaikan ke orang tua setiap bulannya.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($tutors->take(6) as $index => $tutor)
                    @php
                        $initials = '';
                        $nameParts = explode(' ', $tutor->name ?? '');
                        if (count($nameParts) >= 2) {
                            $initials = strtoupper($nameParts[0][0] . $nameParts[1][0]);
                        } else {
                            $initials = strtoupper(substr($tutor->name ?? 'T', 0, 2));
                        }
                        $avatarUrl = $tutor->avatar_url; // Accessor already handles asset('storage/...')
                    @endphp
                    <div x-data="{ loaded: false }"
                         x-intersect.once="loaded = true"
                         :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                         style="transition-delay: {{ $index * 100 }}ms"
                         class="bg-white rounded-2xl sm:rounded-[2rem] p-4 sm:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 text-center hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:-translate-y-2 hover:scale-[1.02] transition-all duration-700 transform">
                        <div class="w-14 h-14 sm:w-20 sm:h-20 bg-gradient-to-br from-brand-orange to-yellow-500 rounded-full flex items-center justify-center text-white text-lg sm:text-2xl font-bold mx-auto mb-3 sm:mb-4 overflow-hidden"
                             x-data="{ hovered: false }"
                             @mouseenter="hovered = true"
                             @mouseleave="hovered = false"
                             :style="hovered ? 'transform: scale(1.1) rotate(5deg)' : ''"
                             style="transition: transform 0.3s;">
                            @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $tutor->name }}" class="w-full h-full rounded-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full rounded-full bg-gradient-to-br from-orange-500 to-yellow-500 flex items-center justify-center text-white text-lg sm:text-2xl font-bold" style="display: none;">
                                    {{ $initials }}
                                </div>
                            @else
                                {{ $initials }}
                            @endif
                        </div>
                        <h3 class="font-extrabold text-slate-900 text-sm sm:text-lg mb-1 sm:mb-2 truncate">{{ $tutor->name }}</h3>
                        @if($tutor->bio)
                            <p class="text-xs sm:text-sm text-slate-500 line-clamp-2">{{ $tutor->bio }}</p>
                        @else
                            <p class="text-xs sm:text-sm text-slate-400">Tutor Berpengalaman</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Testimonials Section -->
    @if($testimonials->count() > 0)
    <section class="py-16 sm:py-20 bg-gradient-to-br from-slate-50 via-indigo-50/30 to-slate-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12">
                <div>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">
                        Kata <span class="text-indigo-600">Sahabat RA</span>
                    </h2>
                    <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                        Lihat apa yang dikatakan siswa dan orang tua tentang pengalaman belajar mereka
                    </p>
                </div>
            </div>

            <div class="relative">
                <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-slate-50 via-indigo-50/30 to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-slate-50 via-indigo-50/30 to-transparent z-10 pointer-events-none"></div>

                <div class="flex gap-6 overflow-hidden">
                    @php
                        $testimonialsList = $testimonials->take(6);
                        $duplicatedTestimonials = $testimonialsList->concat($testimonialsList);
                    @endphp
                    <div class="flex gap-6 animate-marquee" style="width: fit-content;">
                    @foreach($duplicatedTestimonials as $index => $testimonial)
                        @php
                            $initials = '';
                            $nameParts = explode(' ', $testimonial->name ?? '');
                            if (count($nameParts) >= 2) {
                                $initials = strtoupper($nameParts[0][0] . $nameParts[1][0]);
                            } else {
                                $initials = strtoupper(substr($testimonial->name ?? 'T', 0, 2));
                            }
                        @endphp
                        <div x-data="{ loaded: false, hovered: false }"
                             x-intersect="loaded = true"
                             :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                             :style="'transition-delay: {{ $index * 100 }}ms' + (hovered ? '; transform: scale(1.02) translateY(-4px); transition: transform 0.2s;' : '; transition: transform 0.7s;')"
                             @mouseenter="hovered = true"
                             @mouseleave="hovered = false"
                             class="flex-shrink-0 w-[280px] sm:w-[350px] md:w-[400px] bg-white/80 backdrop-blur-sm rounded-2xl p-4 sm:p-6 border border-slate-200/50 shadow-lg shadow-indigo-500/5 transition-all duration-700 transform">
                            <div class="flex items-center gap-4 mb-4">
                                @if($testimonial->photo_url)
                                    <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-indigo-100 flex-shrink-0"
                                         x-data="{ hovered: false, imageError: false }"
                                         @mouseenter="hovered = true"
                                         @mouseleave="hovered = false"
                                         :style="hovered && !imageError ? 'transform: scale(1.1) rotate(5deg)' : ''"
                                         style="transition: transform 0.2s;">
                                        <img src="{{ $testimonial->photo_url }}"
                                             alt="{{ $testimonial->name }}"
                                             class="w-full h-full object-cover"
                                             x-show="!imageError"
                                             x-on:error="imageError = true"
                                             style="display: block;">
                                        <div x-show="imageError"
                                             class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm"
                                             style="display: none;">
                                            {{ $initials }}
                                        </div>
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg flex-shrink-0"
                                         x-data="{ hovered: false }"
                                         @mouseenter="hovered = true"
                                         @mouseleave="hovered = false"
                                         :style="hovered ? 'transform: scale(1.1) rotate(360deg)' : ''"
                                         style="transition: transform 0.5s;">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ $testimonial->name }}</h4>
                                    <p class="text-sm text-slate-500">{{ $testimonial->role ?? 'Siswa' }}</p>
                                </div>
                            </div>
                            
                            @if($testimonial->rating)
                                <div class="flex gap-1 mb-3">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-4 h-4 {{ $i < $testimonial->rating ? 'text-orange-500 fill-orange-500' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                            @endif

                            <p class="text-slate-700 leading-relaxed text-sm line-clamp-4">
                                "{{ $testimonial->content }}"
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- CTA Section -->
    <section class="py-12 sm:py-20 md:py-24 px-4 sm:px-6">
        <div class="max-w-6xl mx-auto relative">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-amber-500 rounded-[2rem] sm:rounded-[3rem] rotate-1 opacity-60 blur-2xl transform scale-95 translate-y-4"></div>
            <div class="relative bg-gradient-to-br from-orange-500 via-orange-600 to-amber-500 rounded-[2rem] sm:rounded-[3rem] p-6 sm:p-12 md:p-24 text-center overflow-hidden shadow-2xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px"></div>
                
                <div class="relative z-10">
                    <h2 class="text-2xl sm:text-4xl md:text-6xl font-black text-white mb-4 sm:mb-6 leading-tight tracking-tight">
                        Bergabunglah dengan Sahabat Rumba Lainnya!
                    </h2>
                    <p class="text-xs sm:text-xl text-white/90 mb-6 sm:mb-10 max-w-2xl mx-auto leading-relaxed font-medium">
                        Dapatkan pengalaman belajar yang menyenangkan dan raih prestasi terbaik bersama Rumba Athaya
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-6 justify-center items-center">
                        <a href="{{ route('register') }}" class="group px-6 sm:px-12 py-3.5 sm:py-5 bg-white text-orange-600 rounded-full font-bold text-sm sm:text-xl hover:bg-gray-50 hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center gap-2 w-full sm:w-auto justify-center active:scale-95">
                            <span>Daftar Sekarang</span>
                        </a>
                        
                        <a href="{{ route('contact') }}" class="group px-6 sm:px-12 py-3.5 sm:py-5 bg-white/10 backdrop-blur-md text-white border-2 border-white/30 rounded-full font-bold text-sm sm:text-xl hover:bg-white/20 hover:border-white/50 transition-all duration-300 flex items-center gap-2 w-full sm:w-auto justify-center">
                            <span>Hubungi Kami</span>
                        </a>
                    </div>
                    
                    <div class="mt-6 sm:mt-10 flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-white/80 text-[10px] sm:text-base">
                        @foreach(['Konsultasi Gratis', 'Tanpa Biaya Pendaftaran', 'Fleksibel & Terpercaya'] as $item)
                            <div class="flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-green-300 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="font-semibold">{{ $item }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- ── EXCLUSIVE MOBILE APP WELCOME ONBOARDING ── --}}
<div class="app-only-layout min-h-screen bg-slate-50 relative overflow-hidden" style="display:none">
    {{-- Animated Background Blobs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-orange-100/50 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-100/40 rounded-full blur-3xl"></div>
    </div>

    @auth
        {{-- Loader while redirecting logged-in user --}}
        <div class="relative z-10 flex flex-col items-center justify-center min-h-screen text-center px-6">
            <div class="w-16 h-16 rounded-2xl bg-white shadow-md flex items-center justify-center mb-6 border border-slate-100">
                <i class="ph ph-spinner text-3xl text-orange-500 animate-spin"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Menghubungkan ke Akun...</h3>
            <p class="text-xs text-slate-400 mt-1">Mengalihkan Anda ke Dashboard LMS</p>
        </div>

        <script>
            (function() {
                // Instantly redirect to dashboard inside the Capacitor app
                var checkApp = setInterval(function() {
                    if (window.Capacitor || document.documentElement.classList.contains('capacitor-platform')) {
                        clearInterval(checkApp);
                        window.location.href = "{{ auth()->user()->role == 'admin' ? route('admin.dashboard') : (auth()->user()->role == 'tutor' ? route('tutor.dashboard') : route('student.dashboard')) }}";
                    }
                }, 50);
                // Timeout after 1.5s as fallback
                setTimeout(function() { clearInterval(checkApp); }, 1500);
            })();
        </script>
    @else
        {{-- Welcome & Onboarding View --}}
        <div class="relative z-10 flex flex-col min-h-screen justify-between pt-8 pb-24 px-6">
            
            {{-- Header/Logo --}}
            <div class="flex flex-col items-center text-center mt-2">
                <div class="w-24 h-24 sm:w-32 sm:h-32 mb-1 transform hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('maskot.png') }}" alt="Mascot Rumba" class="w-full h-full object-contain filter drop-shadow-md">
                </div>
                <div class="flex items-center gap-2 mb-1 justify-center">
                    <img src="{{ asset('LogoNavbar.png') }}" alt="Logo" class="h-6 w-auto">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Rumba Athaya</h1>
                </div>
                <p class="text-[10px] text-orange-600 font-bold uppercase tracking-widest leading-none">Learning Management System</p>
            </div>

            {{-- Feature Slide List --}}
            <div class="my-8 max-w-sm mx-auto w-full space-y-4">
                
                {{-- Card 1 --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="ph ph-calendar-blank"></i>
                    </div>
                    <div class="text-left">
                        <h4 class="font-bold text-xs text-slate-800">Pantau Jadwal Belajar</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5 leading-relaxed">Jadwal kelas, jam les, dan tutor ter-update real-time.</p>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="ph ph-book-open"></i>
                    </div>
                    <div class="text-left">
                        <h4 class="font-bold text-xs text-slate-800">Materi & Modul Praktis</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5 leading-relaxed">Unduh modul belajar langsung ke handphone Anda.</p>
                    </div>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center gap-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-10 h-10 rounded-xl bg-green-50 text-green-500 flex items-center justify-center text-xl flex-shrink-0">
                        <i class="ph ph-check-circle"></i>
                    </div>
                    <div class="text-left">
                        <h4 class="font-bold text-xs text-slate-800">Absensi & Progress Nilai</h4>
                        <p class="text-[10px] text-slate-400 mt-0.5 leading-relaxed">Pantau perkembangan belajar harian dengan transparan.</p>
                    </div>
                </div>

            </div>

            {{-- Action Buttons --}}
            <div class="max-w-sm mx-auto w-full space-y-3">
                <a href="{{ route('login') }}" 
                   class="flex items-center justify-center gap-2 w-full py-4 rounded-2xl font-bold text-sm text-white shadow-lg shadow-orange-500/25 active:scale-98 transition-all hover:opacity-95"
                   style="background: linear-gradient(135deg, #f97316 0%, #f59e0b 100%)">
                    <i class="ph ph-sign-in text-base"></i> Masuk Ke Akun
                </a>

                <a href="{{ route('register') }}" 
                   class="flex items-center justify-center gap-2 w-full py-4 rounded-2xl font-bold text-sm text-slate-700 bg-white border border-slate-200 shadow-sm active:scale-98 transition-all hover:bg-slate-50">
                    <i class="ph ph-user-plus text-base"></i> Pendaftaran Siswa Baru
                </a>
                
                <p class="text-[10px] text-slate-400 text-center mt-4">Rumah Belajar Athaya © {{ date('Y') }}</p>
            </div>

        </div>
    @endauth
</div>
@endsection
