@extends('layouts.landing')

@section('title', 'Testimoni')

@section('content')
@php
    $testimonials = \App\Models\Testimonial::where('is_published', true)
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <!-- Premium Hero Section -->
    <x-premium-hero 
        :badge="['icon' => 'ph-star', 'text' => 'Testimoni']"
        title="Testimoni"
        titleHighlight="Sahabat Rumba"
        description="Apa kata mereka tentang pengalaman belajar di Rumba Athaya?"
    />

    <section class="relative -mt-20 z-10 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($testimonials->count() === 0)
                <div class="text-center py-20">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="ph ph-star text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Testimoni</h3>
                    <p class="text-gray-600">Testimoni akan ditampilkan di sini setelah dipublikasikan</p>
                </div>
            @else
                <!-- Testimoni Grid -->
                <!-- Testimoni Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($testimonials as $index => $testimonial)
                        @php
                            $initials = '';
                            $nameParts = explode(' ', $testimonial->name ?? '');
                            if (count($nameParts) >= 2) {
                                $initials = strtoupper($nameParts[0][0] . $nameParts[1][0]);
                            } else {
                                $initials = strtoupper(substr($testimonial->name ?? 'T', 0, 2));
                            }
                            
                            $avatarColors = [
                                ['bg' => 'bg-brand-orange/10', 'text' => 'text-brand-orange', 'shadow' => 'shadow-orange-500/20'],
                                ['bg' => 'bg-brand-blue/10', 'text' => 'text-brand-blue', 'shadow' => 'shadow-blue-500/20'],
                                ['bg' => 'bg-green-500/10', 'text' => 'text-green-500', 'shadow' => 'shadow-green-500/20'],
                                ['bg' => 'bg-purple-100', 'text' => 'text-purple-600', 'shadow' => 'shadow-purple-500/20'],
                                ['bg' => 'bg-amber-100', 'text' => 'text-amber-600', 'shadow' => 'shadow-amber-500/20'],
                                ['bg' => 'bg-blue-100', 'text' => 'text-blue-600', 'shadow' => 'shadow-blue-500/20'],
                            ];
                            $color = $avatarColors[$index % count($avatarColors)];
                        @endphp
                        <x-animated-card delay="{{ $index * 0.1 }}" class="bg-white rounded-[2rem] p-8 shadow-lg shadow-gray-200/50 border border-gray-100">
                            <div class="flex items-center gap-4 mb-4">
                                @if($testimonial->photo_url)
                                    <img src="{{ $testimonial->photo_url }}" 
                                         alt="{{ $testimonial->name }}" 
                                         class="w-16 h-16 rounded-[2rem] object-cover border-2 border-white shadow-lg transition-transform duration-300 hover:scale-110"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="w-16 h-16 rounded-[2rem] {{ $color['bg'] }} flex items-center justify-center {{ $color['text'] }} font-bold text-2xl shadow-lg {{ $color['shadow'] }} transition-transform duration-500 hover:rotate-[360deg] hover:scale-110" style="display: none;">
                                        {{ $initials }}
                                    </div>
                                @else
                                    <div class="w-16 h-16 rounded-[2rem] {{ $color['bg'] }} flex items-center justify-center {{ $color['text'] }} font-bold text-2xl shadow-lg {{ $color['shadow'] }} transition-transform duration-500 hover:rotate-[360deg] hover:scale-110">
                                        {{ $initials }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ $testimonial->name }}</h4>
                                    <p class="text-sm text-slate-500">{{ $testimonial->role ?? 'Siswa' }}</p>
                                </div>
                            </div>
                            
                                <div class="flex gap-1 mb-4">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="ph-star {{ $i < $testimonial->rating ? 'ph-fill' : 'ph' }} text-amber-400"></i>
                                    @endfor
                                </div>

                            <p class="text-slate-700 leading-relaxed italic text-sm">
                                "{{ $testimonial->content }}"
                            </p>
                        </x-animated-card>
                    @endforeach
                </div>
            @endif

            <!-- CTA Section -->
            <x-animated-card delay="0.6" class="bg-gradient-to-br from-brand-orange via-orange-500 to-amber-600 rounded-[2rem] p-12 text-center text-white shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
                
                <div class="relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Bergabunglah dengan Sahabat Rumba Lainnya!</h2>
                    <p class="text-lg text-white/90 mb-8 max-w-2xl mx-auto">
                        Dapatkan pengalaman belajar yang menyenangkan dan raih prestasi terbaik bersama Rumba Athaya
                    </p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-brand-orange rounded-xl font-semibold hover:bg-amber-50 hover:shadow-xl hover:-translate-y-1 transition shadow-lg flex items-center gap-2">
                            <i class="ph ph-user-plus"></i>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('contact') }}" class="px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/30 text-white rounded-xl font-semibold hover:bg-white/20 hover:border-white/50 hover:shadow-xl hover:-translate-y-1 transition flex items-center gap-2">
                            <i class="ph ph-phone"></i>
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </x-animated-card>
        </div>
    </section>
</div>
@endsection

