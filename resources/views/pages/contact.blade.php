@extends('layouts.landing')

@section('title', 'Kontak')

@section('content')
@php
    $contactInfo = [
        [
            'icon' => 'ph-whatsapp-logo',
            'title' => 'WhatsApp',
            'value' => '+62 812-3456-7890',
            'link' => 'https://wa.me/62812345678',
            'description' => 'Chat langsung via WhatsApp',
            'bgColor' => 'bg-green-100',
            'iconColor' => 'text-green-600',
        ],
        [
            'icon' => 'ph-envelope',
            'title' => 'Email',
            'value' => 'info@rumbaathaya.com',
            'link' => 'mailto:info@rumbaathaya.com',
            'description' => 'Kirim email untuk pertanyaan',
            'bgColor' => 'bg-brand-orange/10',
            'iconColor' => 'text-brand-orange',
        ],
        [
            'icon' => 'ph-map-pin',
            'title' => 'Alamat',
            'value' => 'Alamat Rumba Athaya',
            'link' => '#',
            'description' => 'Kunjungi lokasi kami',
            'bgColor' => 'bg-brand-blue/10',
            'iconColor' => 'text-brand-blue',
        ],
        [
            'icon' => 'ph-instagram-logo',
            'title' => 'Instagram',
            'value' => '@rumbaathaya',
            'link' => 'https://instagram.com/rumbaathaya',
            'description' => 'Follow kami di Instagram',
            'bgColor' => 'bg-purple-100',
            'iconColor' => 'text-purple-600',
        ],
        [
            'icon' => 'ph-youtube-logo',
            'title' => 'YouTube',
            'value' => 'Rumba Athaya',
            'link' => 'https://youtube.com/@rumbaathaya',
            'description' => 'Subscribe channel kami',
            'bgColor' => 'bg-red-100',
            'iconColor' => 'text-red-600',
        ],
    ];
    
    $operatingHours = [
        ['day' => 'Senin - Jumat', 'time' => '08:00 - 20:00 WIB'],
        ['day' => 'Sabtu', 'time' => '08:00 - 17:00 WIB'],
        ['day' => 'Minggu', 'time' => 'Tutup'],
    ];
@endphp

<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <!-- Premium Hero Section -->
    <x-premium-hero 
        :badge="['icon' => 'ph-phone', 'text' => 'Hubungi Kami']"
        title="Kontak"
        titleHighlight="Kami"
        description="Hubungi kami untuk informasi lebih lanjut tentang program dan layanan Rumba Athaya"
    />

    <section class="relative -mt-20 z-10 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 sm:gap-10 lg:gap-12">
                <!-- Contact Info -->
                <div class="space-y-8">
                    <x-animated-card delay="0.1" class="bg-white rounded-[2rem] p-8 shadow-lg shadow-gray-200/50 border border-gray-100">
                        <h2 class="text-2xl font-bold text-slate-800 mb-6">Informasi Kontak</h2>
                        
                        <div class="space-y-6">
                            @foreach($contactInfo as $index => $info)
                                <div class="flex items-start gap-4"
                                     x-data="{ loaded: true }"
                                     x-intersect="loaded = true"
                                     x-show="loaded"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-x-5"
                                     x-transition:enter-end="opacity-100 translate-x-0"
                                     :style="'transition-delay: {{ $index * 0.1 }}s'">
                                    <div class="w-12 h-12 {{ $info['bgColor'] }} rounded-xl flex items-center justify-center {{ $info['iconColor'] }} flex-shrink-0"
                                         x-data="{ hovered: false }"
                                         @mouseenter="hovered = true"
                                         @mouseleave="hovered = false"
                                         :style="hovered ? 'transform: scale(1.1) rotate(5deg)' : ''"
                                         style="transition: transform 0.2s;">
                                        <i class="ph {{ $info['icon'] }} text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 mb-1">{{ $info['title'] }}</h3>
                                        <a href="{{ $info['link'] }}"
                                           @if(str_starts_with($info['link'], 'http'))
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           @endif
                                           class="text-brand-orange hover:text-orange-600 transition">
                                            {{ $info['value'] }}
                                        </a>
                                        <p class="text-sm text-gray-600 mt-1">{{ $info['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-animated-card>

                    <!-- Social Media -->
                    <x-animated-card delay="0.2" class="bg-gradient-to-br from-brand-orange/10 to-amber-50 rounded-[2rem] p-8 border border-brand-orange/20 shadow-lg shadow-orange-500/10">
                        <h3 class="text-xl font-bold text-slate-800 mb-4">Ikuti Kami</h3>
                        <div class="flex gap-4">
                            @foreach(['ph-instagram-logo', 'ph-youtube-logo', 'ph-whatsapp-logo'] as $index => $icon)
                                <a href="#"
                                   class="w-12 h-12 bg-white rounded-xl flex items-center justify-center text-purple-600 hover:bg-purple-100 transition shadow-sm hover:scale-110 hover:-translate-y-1"
                                   style="transition: transform 0.2s;">
                                    <i class="ph {{ $icon }} text-2xl"></i>
                                </a>
                            @endforeach
                        </div>
                    </x-animated-card>
                </div>

                <!-- Quick Actions -->
                <div class="space-y-6">
                    <x-animated-card delay="0.3" class="bg-white rounded-[2rem] p-8 shadow-lg shadow-gray-200/50 border border-gray-100">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-brand-orange/10 rounded-2xl flex items-center justify-center text-brand-orange text-3xl mx-auto mb-4 shadow-lg shadow-orange-500/20"
                                 x-data="{ hovered: false }"
                                 @mouseenter="hovered = true"
                                 @mouseleave="hovered = false"
                                 :style="hovered ? 'transform: scale(1.1) rotate(360deg)' : ''"
                                 style="transition: transform 0.6s;">
                                <i class="ph ph-user-plus"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900 mb-2">Daftar Sekarang</h2>
                            <p class="text-gray-600 text-sm">
                                Hubungi kami via WhatsApp untuk proses pendaftaran cepat
                            </p>
                        </div>
                        <a href="https://wa.me/62812345678?text=Halo,%20saya%20ingin%20daftar%20di%20Rumba%20Athaya"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex items-center justify-center gap-2 w-full bg-brand-orange text-white px-6 py-4 rounded-xl font-semibold hover:bg-orange-600 hover:shadow-xl hover:-translate-y-1 transition shadow-lg shadow-orange-500/30">
                            <i class="ph ph-whatsapp-logo text-xl"></i>
                            Daftar via WhatsApp
                        </a>
                    </x-animated-card>

                    <x-animated-card delay="0.4" class="bg-white rounded-[2rem] p-8 shadow-lg shadow-gray-200/50 border border-gray-100">
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-brand-blue/10 rounded-2xl flex items-center justify-center text-brand-blue text-3xl mx-auto mb-4 shadow-lg shadow-blue-500/20"
                                 x-data="{ hovered: false }"
                                 @mouseenter="hovered = true"
                                 @mouseleave="hovered = false"
                                 :style="hovered ? 'transform: scale(1.1) rotate(360deg)' : ''"
                                 style="transition: transform 0.6s;">
                                <i class="ph ph-chat-circle"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900 mb-2">Konsultasi Gratis</h2>
                            <p class="text-gray-600 text-sm">
                                Tanya tutor untuk memilih program yang tepat
                            </p>
                        </div>
                        <a href="https://wa.me/62812345678?text=Halo,%20saya%20ingin%20konsultasi%20tentang%20program%20Rumba%20Athaya"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex items-center justify-center gap-2 w-full bg-brand-blue text-white px-6 py-4 rounded-xl font-semibold hover:bg-blue-800 hover:shadow-xl hover:-translate-y-1 transition shadow-lg shadow-blue-500/30">
                            <i class="ph ph-whatsapp-logo text-xl"></i>
                            Konsultasi via WhatsApp
                        </a>
                    </x-animated-card>

                    <x-animated-card delay="0.5" class="bg-white rounded-[2rem] p-8 shadow-lg shadow-gray-200/50 border border-gray-100">
                        <h3 class="text-xl font-bold text-slate-800 mb-4">Jam Operasional</h3>
                        <div class="space-y-3 text-gray-700">
                            @foreach($operatingHours as $index => $schedule)
                                <div class="flex justify-between"
                                     x-data="{ loaded: true }"
                                     x-intersect="loaded = true"
                                     x-show="loaded"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-x-3"
                                     x-transition:enter-end="opacity-100 translate-x-0"
                                     :style="'transition-delay: {{ $index * 0.1 }}s'">
                                    <span>{{ $schedule['day'] }}</span>
                                    <span class="font-semibold">{{ $schedule['time'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </x-animated-card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

