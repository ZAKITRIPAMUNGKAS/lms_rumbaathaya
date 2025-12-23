@extends('layouts.landing')

@section('title', 'Tentang Kami')

@section('content')
    @php
        $formula3B = [
            [
                'title' => 'Belajar',
                'description' => 'Menciptakan suasana belajar yang interaktif, mudah dipahami, dan jauh dari kesan membosankan.',
                'icon' => 'ph-book-open-text',
                'color' => 'blue',
                'bgColor' => 'bg-blue-50',
                'iconBg' => 'bg-blue-600',
                'shadowColor' => 'shadow-blue-500/30',
            ],
            [
                'title' => 'Berlatih',
                'description' => 'Mendorong Sahabat Rumba untuk secara konsisten mengasah kemampuan melalui latihan soal yang terstruktur dan terukur.',
                'icon' => 'ph-pencil-circle',
                'color' => 'orange',
                'bgColor' => 'bg-orange-50',
                'iconBg' => 'bg-brand-orange',
                'shadowColor' => 'shadow-orange-500/30',
            ],
            [
                'title' => 'Berprestasi',
                'description' => 'Memastikan proses Belajar dan Berlatih menghasilkan peningkatan nilai dan pencapaian prestasi akademik terbaik.',
                'icon' => 'ph-trophy',
                'color' => 'green',
                'bgColor' => 'bg-green-50',
                'iconBg' => 'bg-green-500',
                'shadowColor' => 'shadow-green-500/30',
            ],
        ];

        $misi = [
            'Menyediakan lingkungan belajar yang menyenangkan dan kondusif',
            'Menggunakan metode pembelajaran yang efektif dan terukur',
            'Membantu siswa meraih prestasi akademik terbaik',
        ];
    @endphp

    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
        <!-- Premium Hero Section -->
        <x-premium-hero :badge="['icon' => 'ph-info', 'text' => 'Tentang Kami']" title="Tentang" titleHighlight="Rumba Athaya"
            description="Bimbingan belajar yang berkomitmen menciptakan suasana belajar yang menyenangkan, efektif, dan inspiratif" />

        <section class="relative -mt-20 z-10 pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Sejarah -->
                <x-animated-card delay="0.1" :noAnimation="false"
                    class="bg-white rounded-[2rem] p-8 md:p-12 shadow-lg shadow-gray-200/50 border border-gray-100 mb-12">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 bg-brand-orange/10 rounded-2xl flex items-center justify-center text-brand-orange text-3xl shadow-lg shadow-orange-500/20"
                            x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                            :style="hovered ? 'transform: rotate(360deg)' : ''" style="transition: transform 0.6s;">
                            <i class="ph ph-book-open-text"></i>
                        </div>
                        <h2 class="text-3xl font-bold text-slate-900">Sejarah</h2>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-lg mb-4">
                        <strong>Belajar Asyik, Prestasi Terbaik</strong>
                    </p>
                    <p class="text-gray-700 leading-relaxed text-lg mb-4">
                        Bimbel Rumba Athaya adalah bimbingan belajar yang berkomitmen menciptakan suasana belajar yang
                        menyenangkan, efektif, dan inspiratif bagi Sahabat Rumba. Sejak berdiri pada <strong>6 Maret
                            2023</strong>, kami telah membantu Sahabat Rumba meraih potensi akademiknya secara maksimal
                        dengan Formula 3B.
                    </p>
                    <p class="text-gray-700 leading-relaxed text-lg">
                        Dengan mengusung tagline <strong>"Belajar Asyik, Prestasi Terbaik"</strong>, kami didukung oleh tim
                        pengajar yang berdedikasi dan berpengalaman di bidangnya.
                    </p>
                </x-animated-card>

                <!-- Formula 3B -->
                <x-animated-section delay="0.2" class="mb-12">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 text-center mb-16">Formula 3B Rumba Athaya
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        @foreach($formula3B as $index => $item)
                            <x-animated-card delay="{{ $index * 0.1 }}"
                                class="group p-8 rounded-[2rem] bg-white border border-gray-100 shadow-lg shadow-gray-200/50 hover:shadow-2xl hover:shadow-{{ $item['color'] }}-500/10 transition-all duration-300 relative overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 w-32 h-32 {{ $item['bgColor'] }} rounded-bl-[4rem] -mr-8 -mt-8 transition-transform group-hover:scale-110">
                                </div>
                                <div class="w-16 h-16 {{ $item['iconBg'] }} text-white rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg {{ $item['shadowColor'] }} relative z-10"
                                    x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                                    :style="hovered ? 'transform: scale(1.1) rotate(5deg)' : ''"
                                    style="transition: transform 0.2s;">
                                    <i class="ph {{ $item['icon'] }}"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-slate-900 mb-3 relative z-10">{{ $item['title'] }}</h3>
                                <p class="text-gray-600 leading-relaxed relative z-10">{{ $item['description'] }}</p>
                            </x-animated-card>
                        @endforeach
                    </div>
                </x-animated-section>

                <!-- Visi Misi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                    <x-animated-card delay="0.3"
                        class="bg-white rounded-[2rem] p-8 shadow-lg shadow-gray-200/50 border border-gray-100">
                        <div class="w-16 h-16 bg-brand-orange/10 rounded-2xl flex items-center justify-center text-brand-orange text-3xl mb-6 shadow-lg shadow-orange-500/20"
                            x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                            :style="hovered ? 'transform: scale(1.1)' : ''" style="transition: transform 0.2s;">
                            <i class="ph ph-eye"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Visi</h3>
                        <p class="text-gray-700 leading-relaxed">
                            Menjadi bimbingan belajar terdepan yang menciptakan generasi berprestasi melalui metode belajar
                            yang menyenangkan dan efektif.
                        </p>
                    </x-animated-card>

                    <x-animated-card delay="0.4"
                        class="bg-white rounded-[2rem] p-8 shadow-lg shadow-gray-200/50 border border-gray-100">
                        <div class="w-16 h-16 bg-brand-blue/10 rounded-2xl flex items-center justify-center text-brand-blue text-3xl mb-6 shadow-lg shadow-blue-500/20"
                            x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                            :style="hovered ? 'transform: scale(1.1)' : ''" style="transition: transform 0.2s;">
                            <i class="ph ph-target"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Misi</h3>
                        <ul class="text-gray-700 leading-relaxed space-y-2">
                            @foreach($misi as $index => $item)
                                <li class="flex items-start gap-2" x-data="{ loaded: true }" x-intersect="loaded = true"
                                    x-show="loaded" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-x-5"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    :style="'transition-delay: {{ $index * 0.1 }}s'">
                                    <i class="ph ph-check text-brand-orange mt-1"></i>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </x-animated-card>
                </div>

                <!-- Belajar Seru -->
                <x-animated-card delay="0.5"
                    class="bg-gradient-to-br from-brand-orange/10 to-amber-50 rounded-[2rem] p-8 md:p-12 shadow-lg shadow-orange-500/10 border border-brand-orange/20 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-orange/5 rounded-full blur-3xl -mr-32 -mt-32">
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-6 text-center relative z-10">Belajar Seru dan
                        Menyenangkan</h2>
                    <p class="text-gray-700 leading-relaxed text-lg text-center max-w-3xl mx-auto mb-8 relative z-10">
                        Bimbel Rumba Athaya tidak hanya soal mendampingi belajar, tetapi Sahabat Rumba akan dibersamai oleh
                        Tutor yang berpengalaman, fasilitas sarana penunjang yang lengkap dan kekinian serta merasakan
                        pengalaman belajar yang seru dan interaktif sesuai dengan tagline <strong>"Belajar Asyik, Prestasi
                            Terbaik"</strong>.
                    </p>
                    <div class="bg-white rounded-2xl p-6 border border-brand-orange/30 shadow-sm relative z-10">
                        <p class="text-gray-700 leading-relaxed text-center italic">
                            <i class="ph ph-info text-brand-orange"></i>
                            Belajar bersama Tutor Rumba Athaya dari berbagai PTN serta berpengalaman dalam memotivasi dan
                            juga memantau perkembangan Sahabat Rumba dengan pemantauan yang akan disampaikan ke orang tua
                            setiap bulannya.
                        </p>
                    </div>
                </x-animated-card>
            </div>
        </section>
    </div>
@endsection