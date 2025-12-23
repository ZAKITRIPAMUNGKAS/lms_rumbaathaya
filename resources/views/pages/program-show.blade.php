@extends('layouts.landing')

@section('title', 'Detail Program')

@section('content')
    {{-- TODO: Implement Program Detail Page --}}

    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
        <!-- Premium Hero Section -->
        <x-premium-hero :badge="['icon' => 'ph-student', 'text' => 'Detail Program']" :title="$program['title']"
            titleHighlight="Rumba Athaya" :description="$program['description']" />

        <section class="relative -mt-20 z-10 pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-animated-card delay="0.1" class="mb-12">
                    <div
                        class="bg-white rounded-[2rem] p-8 md:p-12 shadow-lg shadow-gray-200/50 border border-gray-100 flex flex-col lg:flex-row gap-12 items-center">
                        <!-- Image/Visual -->
                        <div class="w-full lg:w-1/2">
                            <div
                                class="relative rounded-3xl overflow-hidden shadow-2xl transform rotate-2 hover:rotate-0 transition-all duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent z-10"></div>
                                <img src="{{ Str::startsWith($program['image'], ['http://', 'https://']) ? $program['image'] : (Str::startsWith($program['image'], '/') ? $program['image'] : '/' . $program['image']) }}"
                                    alt="{{ $program['title'] }}"
                                    class="w-full h-auto object-cover transform hover:scale-105 transition-transform duration-700"
                                    onerror="this.src='https://via.placeholder.com/800x600?text={{ urlencode($program['title']) }}'">

                                <!-- Badge Overlay -->
                                <div class="absolute top-6 left-6 z-20">
                                    @php
                                        $badgeColors = [
                                            'pink' => 'bg-pink-500 text-white',
                                            'orange' => 'bg-brand-orange text-white',
                                            'red' => 'bg-red-500 text-white',
                                            'blue' => 'bg-blue-500 text-white',
                                            'green' => 'bg-green-500 text-white',
                                        ];
                                        $badgeClass = $badgeColors[$program['color']] ?? 'bg-brand-orange text-white';
                                    @endphp
                                    <span class="px-4 py-2 rounded-full text-sm font-bold shadow-lg {{ $badgeClass }}">
                                        {{ $program['badge'] }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="w-full lg:w-1/2">
                            <h2 class="text-3xl font-bold text-slate-900 mb-6">Mengapa Memilih Program Ini?</h2>
                            <p class="text-lg text-gray-600 leading-relaxed mb-8">
                                {{ $program['description'] }}
                            </p>

                            <div class="space-y-4 mb-10">
                                @foreach($program['benefits'] as $index => $benefit)
                                    <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-md transition-all duration-300"
                                        x-data="{ loaded: true }" x-intersect="loaded = true" x-show="loaded"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 translate-x-4"
                                        x-transition:enter-end="opacity-100 translate-x-0"
                                        style="transition-delay: {{ $index * 0.1 }}s">
                                        <div
                                            class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 {{ str_replace('bg-', 'bg-', $badgeClass) }} bg-opacity-10">
                                            <i
                                                class="ph ph-check-circle text-xl {{ str_replace('bg-', 'text-', $badgeClass) }}"></i>
                                        </div>
                                        <span class="font-medium text-gray-700">{{ $benefit }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('register') }}"
                                    class="group px-8 py-4 bg-brand-orange text-white rounded-xl font-bold hover:bg-orange-600 shadow-xl shadow-orange-500/30 transition-all duration-300 flex items-center justify-center gap-3">
                                    <span>Daftar Sekarang</span>
                                    <i class="ph ph-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                </a>
                                <a href="{{ route('contact') }}"
                                    class="px-8 py-4 bg-white text-gray-700 border-2 border-gray-200 rounded-xl font-bold hover:border-brand-orange hover:text-brand-orange transition-all duration-300 flex items-center justify-center gap-3">
                                    <span>Tanya Lebih Lanjut</span>
                                    <i class="ph ph-whatsapp-logo text-xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </x-animated-card>

                <!-- Other Programs -->
                <div class="mt-20">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-slate-900 mb-4">Program Lainnya</h2>
                        <p class="text-gray-600">Jelajahi pilihan program belajar lainnya di Rumba Athaya</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @php
                            $allPrograms = \App\Http\Controllers\ProgramController::getAllPrograms();
                            // Filter out current program
                            $otherPrograms = array_filter($allPrograms, function ($p) use ($program) {
                                return $p['slug'] !== $program['slug'];
                            });
                            // Limit to 4
                            $otherPrograms = array_slice($otherPrograms, 0, 4);
                        @endphp

                        @foreach($otherPrograms as $other)
                            <a href="{{ route('program.show', $other['slug']) }}"
                                class="group bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                <div class="h-40 rounded-xl overflow-hidden mb-4 relative">
                                    <img src="{{ Str::startsWith($other['image'], ['http://', 'https://']) ? $other['image'] : (Str::startsWith($other['image'], '/') ? $other['image'] : '/' . $other['image']) }}"
                                        alt="{{ $other['title'] }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                        onerror="this.src='https://via.placeholder.com/400x300?text={{ urlencode($other['title']) }}'">
                                    <div
                                        class="absolute top-2 right-2 bg-white/90 backdrop-blur rounded-lg px-2 py-1 text-xs font-bold text-slate-700">
                                        {{ $other['badge'] }}
                                    </div>
                                </div>
                                <h3
                                    class="font-bold text-lg text-slate-900 mb-2 group-hover:text-brand-orange transition-colors">
                                    {{ $other['title'] }}
                                </h3>
                                <p class="text-sm text-gray-500 line-clamp-2">{{ $other['description'] }}</p>
                                <div class="mt-4 flex items-center text-brand-orange font-semibold text-sm">
                                    Lihat Detail <i
                                        class="ph ph-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection