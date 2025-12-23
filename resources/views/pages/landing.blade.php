@extends('layouts.landing')

@section('title', 'Beranda')

@section('content')
@php
    // Fetch data for landing page
    $posts = \App\Models\Post::where('is_published', true)
        ->orderBy('published_at', 'desc')
        ->limit(3)
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

<div class="min-h-screen">
    <!-- Hero Section - Enhanced & Vibrant -->
    <section id="home" class="relative pt-32 sm:pt-36 md:pt-40 pb-20 sm:pb-24 md:pb-28 overflow-hidden bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50">
        <!-- Animated Background Blobs -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-orange-300/30 to-amber-300/30 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-br from-blue-300/30 to-indigo-300/30 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 w-96 h-96 bg-gradient-to-br from-purple-300/30 to-pink-300/30 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <!-- Floating Decorative Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 text-6xl opacity-20 animate-float">📚</div>
            <div class="absolute top-40 right-20 text-5xl opacity-20 animate-float animation-delay-1000">✨</div>
            <div class="absolute bottom-40 left-20 text-5xl opacity-20 animate-float animation-delay-2000">🎯</div>
            <div class="absolute bottom-20 right-40 text-6xl opacity-20 animate-float animation-delay-3000">🚀</div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-10 lg:gap-12 items-center" x-data="{ showed: false }" x-init="setTimeout(() => showed = true, 100)">
            <div class="relative z-10 text-center lg:text-left">
                <div>
                    
                    <!-- Badge: Bimbel Terbaik - More Vibrant -->
                    <div x-show="showed" 
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         class="inline-flex items-center gap-2 px-3 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-full shadow-lg shadow-orange-500/30 mb-3 sm:mb-4 animate-pulse-slow">
                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                        <span class="text-xs font-bold tracking-wide uppercase">🏆 Bimbel Terbaik Sejak 2023</span>
                    </div>
                    
                    <!-- Main Heading - Cleaner -->
                    <h1 x-show="showed" 
                        x-transition:enter="transition ease-out duration-700 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-10 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-3 sm:mb-4 tracking-tight">
                        Belajar Lebih <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600">Seru</span>, <br/>
                        Prestasi Lebih <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 via-amber-500 to-yellow-500">Cemerlang</span>! 🌟
                    </h1>
                    
                    <!-- Description -->
                    <p x-show="showed" 
                       x-transition:enter="transition ease-out duration-700 delay-200"
                       x-transition:enter-start="opacity-0 translate-y-10"
                       x-transition:enter-end="opacity-100 translate-y-0"
                       class="text-base sm:text-lg md:text-xl text-slate-700 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-medium mb-4 sm:mb-6">
                        Platform bimbingan belajar <span class="font-bold text-orange-600">premium</span> yang mengubah cara belajar menjadi pengalaman yang <span class="font-bold text-indigo-600">menyenangkan</span> dan <span class="font-bold text-purple-600">efektif</span>! 🎓
                    </p>
                    
                    <!-- CTA Buttons - Cleaner -->
                    <div x-show="showed" 
                         x-transition:enter="transition ease-out duration-700 delay-300"
                         x-transition:enter-start="opacity-0 translate-y-10"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="flex flex-wrap gap-3 sm:gap-4 pt-2 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="group relative px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-orange-500 to-amber-600 text-white rounded-xl font-extrabold text-sm sm:text-base hover:shadow-xl hover:shadow-orange-500/40 transition-all duration-300 flex items-center gap-2 overflow-hidden transform hover:scale-105">
                            <span class="absolute inset-0 bg-gradient-to-r from-orange-600 to-amber-700 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                            <span class="relative z-10 flex items-center gap-2">
                                <span>🚀 Daftar Sekarang GRATIS!</span>
                                <span class="group-hover:translate-x-1 transition-transform">→</span>
                            </span>
                        </a>
                        <a href="#program" class="px-6 sm:px-8 py-3 sm:py-4 bg-white text-slate-700 border-2 border-orange-200 rounded-xl font-bold hover:border-orange-400 hover:text-orange-600 hover:bg-orange-50 transition-all duration-300 text-sm sm:text-base flex items-center gap-2 shadow-lg transform hover:scale-105">
                            <span>📖 Lihat Program</span>
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
                    </div>
                </div>

                <!-- Floating Achievement Cards - More Vibrant -->
                <div class="absolute -top-6 -left-6 sm:-top-8 sm:-left-8 bg-gradient-to-br from-blue-500 to-indigo-600 p-4 sm:p-5 rounded-2xl shadow-2xl z-20 hidden sm:block transform hover:scale-110 transition-transform animate-bounce-slow">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white text-2xl">
                            ✅
                        </div>
                        <div class="text-white">
                            <p class="text-xs font-medium opacity-90">Lulus PTN</p>
                            <p class="font-extrabold text-2xl">100%</p>
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

    <!-- Formula 3B Section -->
    <section class="py-12 sm:py-16 md:py-20 lg:py-24 bg-white relative">
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 md:gap-10">
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
                         class="group p-8 rounded-[2rem] bg-white/60 backdrop-blur-xl border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] transition-all duration-700 transform relative overflow-hidden cursor-pointer hover:-translate-y-2 hover:scale-[1.02]"
                         style="transition-delay: {{ $index * 100 }}ms">
                        <div class="absolute top-0 right-0 w-32 h-32 {{ $formula['bgColor'] }} rounded-bl-[4rem] -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                        <div class="w-16 h-16 {{ $formula['iconBg'] }} text-white rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg {{ $formula['shadowColor'] }} relative z-10"
                             x-data="{ hovered: false }"
                             @mouseenter="hovered = true"
                             @mouseleave="hovered = false"
                             :style="hovered ? 'transform: scale(1.1) rotate(5deg)' : ''"
                             style="transition: transform 0.2s;">
                            <i class="ph {{ $formula['icon'] }}"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-3 relative z-10">
                            {{ $formula['number'] }}. {{ $formula['title'] }}
                        </h3>
                        <p class="text-gray-600 leading-relaxed relative z-10">
                            {{ $formula['description'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="py-24 px-6 relative bg-slate-50">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-sm font-bold text-indigo-600 uppercase tracking-widest mb-3">Keunggulan Kami</h2>
                <h3 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight">Kenapa Memilih <span class="text-indigo-600">Rumba?</span></h3>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg font-medium leading-relaxed">
                    Metode pembelajaran yang dirancang khusus untuk memaksimalkan potensi setiap siswa dengan cara yang menyenangkan dan terukur. Kami memahami bahwa setiap Sahabat Rumba memiliki keunikan dan potensi yang berbeda, oleh karena itu kami menyediakan pendekatan pembelajaran yang personal dan efektif.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
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
                         class="p-8 rounded-[2rem] bg-white/60 backdrop-blur-xl border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] transition-all duration-700 transform group cursor-pointer hover:-translate-y-2 hover:scale-[1.02]"
                         style="transition-delay: {{ ($index + 1) * 100 }}ms">
                        <div class="w-14 h-14 {{ $feature['color'] }} text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            @if($feature['icon'] == 'target')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            @elseif($feature['icon'] == 'users')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            @elseif($feature['icon'] == 'rocket')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            @elseif($feature['icon'] == 'book')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            @elseif($feature['icon'] == 'graduation')
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            @else
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                            @endif
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-800 mb-3 tracking-tight">{{ $feature['title'] }}</h3>
                        <p class="text-slate-600 leading-relaxed font-medium text-sm">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section id="program" class="py-12 sm:py-16 md:py-20 lg:py-24 bg-slate-50 relative">
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

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
                         class="bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 overflow-hidden group hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:-translate-y-2 hover:scale-[1.02] transition-all duration-700 transform flex flex-col relative">
                        @if($program['featured'])
                            <div class="absolute top-0 right-0 bg-emerald-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg z-20">
                                Unggulan
                            </div>
                        @endif
                        <div class="h-32 relative p-6 flex flex-col justify-between overflow-hidden">
                            <img src="{{ asset('gambar herosection.png') }}" alt="{{ $program['title'] }}" class="absolute inset-0 w-full h-full object-cover" onerror="this.style.display='none'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/5 to-transparent"></div>
                            <span class="{{ $program['badgeColor'] }} px-3 py-1 rounded-full text-xs font-bold w-fit shadow-sm relative z-10">
                                {{ $program['badge'] }}
                            </span>
                        </div>
                        <div class="p-8 flex flex-col flex-1">
                            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $program['title'] }}</h3>
                            <p class="text-slate-500 text-sm mb-4 leading-relaxed flex-1">
                                {{ $program['description'] }}
                            </p>
                            @if($program['features'])
                                <ul class="space-y-2 mb-6">
                                    @foreach($program['features'] as $feature)
                                        <li class="flex items-center gap-2 text-sm text-gray-600">
                                            <i class="ph ph-check-circle text-green-500"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <a href="{{ route('program.show', $program['id']) }}" class="block w-full text-center py-3 rounded-xl border-2 font-bold transition mt-auto {{ $program['buttonColor'] }}">
                                <i class="ph ph-eye mr-2"></i>
                                Lihat Program
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Sahabat RA (Posts) Section -->
    <section id="sahabatra" class="py-12 sm:py-16 md:py-20 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 sm:mb-10 md:mb-12 gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-orange-100 rounded-full shadow-sm mb-4">
                        <span class="w-2 h-2 rounded-full bg-brand-orange animate-pulse"></span>
                        <span class="text-sm font-bold text-gray-600 tracking-wide uppercase">Mading Online</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">
                        <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 font-extrabold">Sahabat RA</span> <span class="text-slate-900">Mading</span>
                    </h2>
                    <p class="text-gray-500 mt-2 text-sm sm:text-base">
                        Kabar terbaru, karya siswa, dan informasi pendidikan.
                    </p>
                </div>
                <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-orange text-white rounded-xl font-semibold hover:bg-orange-600 hover:shadow-lg hover:shadow-orange-500/30 transition-all duration-200 hover:-translate-y-1">
                    <span>Lihat Semua Berita</span>
                    <i class="ph ph-arrow-right"></i>
                </a>
            </div>

            @if($posts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($posts as $index => $post)
                        <div class="group cursor-pointer bg-white rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 overflow-hidden hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:-translate-y-2 hover:scale-[1.02] transition-all duration-300 animate-fade-in-up"
                             style="animation-delay: {{ $index * 100 }}ms">
                            <a href="{{ route('posts.show', $post->slug) }}">
                                <div class="relative overflow-hidden">
                                    @if($post->thumbnail)
                                        <div class="relative w-full h-52">
                                            <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        </div>
                                    @else
                                        <div class="w-full h-52 bg-gradient-to-br from-brand-orange/20 to-brand-blue/20 flex items-center justify-center">
                                            <i class="ph ph-image text-5xl text-gray-400"></i>
                                        </div>
                                    @endif
                                    @php
                                        $categoryColors = [
                                            'Kabar Rumba' => 'bg-blue-100 text-blue-700',
                                            'Karya Siswa' => 'bg-brand-orange/90 text-white',
                                            'default' => 'bg-green-100 text-green-700'
                                        ];
                                        $categoryColor = $categoryColors[$post->category ?? 'default'] ?? $categoryColors['default'];
                                    @endphp
                                    <div class="absolute top-4 left-4 backdrop-blur px-3 py-1 rounded-full text-xs font-bold {{ $categoryColor }}">
                                        {{ $post->category ?? 'Artikel' }}
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-brand-orange transition">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-gray-500 line-clamp-2 text-sm mb-4">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 100) }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        @if($post->published_at)
                                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                                <i class="ph ph-calendar"></i>
                                                {{ $post->published_at->format('d M Y') }}
                                            </span>
                                        @endif
                                        <span class="text-brand-orange font-semibold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
                                            Baca Selengkapnya
                                            <i class="ph ph-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 bg-gray-50 rounded-2xl border border-gray-200">
                    <i class="ph ph-newspaper text-6xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Postingan</h3>
                    <p class="text-gray-600 mb-6">Kabar terbaru akan segera hadir!</p>
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-orange text-white rounded-xl font-semibold hover:bg-orange-600 hover:shadow-lg transition-all duration-200">
                        <span>Kunjungi Halaman Sahabat RA</span>
                        <i class="ph ph-arrow-right"></i>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Tutors Section -->
    @if($tutors->count() > 0)
    <section class="py-12 sm:py-16 md:py-20 bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12 md:mb-16">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-3 sm:mb-4">
                        Tutor Rumba Athaya
                    </h2>
                    <p class="text-gray-600 text-sm sm:text-base">
                        Tutor berpengalaman dari berbagai PTN yang memotivasi dan memantau perkembangan Sahabat Rumba dengan pemantauan yang akan disampaikan ke orang tua setiap bulannya.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
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
                         class="bg-white rounded-[2rem] p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-white/50 text-center hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:-translate-y-2 hover:scale-[1.02] transition-all duration-700 transform">
                        <div class="w-20 h-20 bg-gradient-to-br from-brand-orange to-yellow-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 overflow-hidden"
                             x-data="{ hovered: false }"
                             @mouseenter="hovered = true"
                             @mouseleave="hovered = false"
                             :style="hovered ? 'transform: scale(1.1) rotate(5deg)' : ''"
                             style="transition: transform 0.3s;">
                            @if($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $tutor->name }}" class="w-full h-full rounded-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="w-full h-full rounded-full bg-gradient-to-br from-orange-500 to-yellow-500 flex items-center justify-center text-white text-2xl font-bold" style="display: none;">
                                    {{ $initials }}
                                </div>
                            @else
                                {{ $initials }}
                            @endif
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">{{ $tutor->name }}</h3>
                        @if($tutor->bio)
                            <p class="text-sm text-slate-600">{{ Str::limit($tutor->bio, 50) }}</p>
                        @else
                            <p class="text-sm text-slate-500">Tutor Berpengalaman</p>
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
    <section class="py-16 sm:py-20 md:py-24 px-6">
        <div class="max-w-6xl mx-auto relative">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-500 to-amber-500 rounded-[3rem] rotate-1 opacity-60 blur-2xl transform scale-95 translate-y-4"></div>
            <div class="relative bg-gradient-to-br from-orange-500 via-orange-600 to-amber-500 rounded-[3rem] p-12 md:p-24 text-center overflow-hidden shadow-2xl">
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl sm:text-4xl md:text-6xl font-extrabold text-white mb-4 sm:mb-6 leading-tight tracking-tight">
                        Bergabunglah dengan Sahabat Rumba Lainnya!
                    </h2>
                    <p class="text-lg sm:text-xl text-white/90 mb-8 sm:mb-10 max-w-2xl mx-auto leading-relaxed font-medium">
                        Dapatkan pengalaman belajar yang menyenangkan dan raih prestasi terbaik bersama Rumba Athaya
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 justify-center items-center">
                        <a href="{{ route('register') }}" class="group px-8 sm:px-12 py-4 sm:py-5 bg-white text-orange-600 rounded-full font-bold text-base sm:text-xl hover:bg-gray-50 hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center gap-3 w-full sm:w-auto justify-center active:scale-95">
                            <span>Daftar Sekarang</span>
                        </a>
                        
                        <a href="{{ route('contact') }}" class="group px-8 sm:px-12 py-4 sm:py-5 bg-white/10 backdrop-blur-md text-white border-2 border-white/30 rounded-full font-bold text-base sm:text-xl hover:bg-white/20 hover:border-white/50 transition-all duration-300 flex items-center gap-3 w-full sm:w-auto justify-center">
                            <span>Hubungi Kami</span>
                        </a>
                    </div>
                    
                    <div class="mt-8 sm:mt-10 flex items-center justify-center gap-2 text-white/80 text-sm sm:text-base flex-wrap">
                        @foreach(['Konsultasi Gratis', 'Tanpa Biaya Pendaftaran', 'Fleksibel & Terpercaya'] as $index => $item)
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $item }}</span>
                            </div>
                            @if($index < 2)
                                <span class="mx-2">•</span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
