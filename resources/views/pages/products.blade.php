@extends('layouts.landing')

@section('title', 'Produk')

@section('content')
    @php
        $programs = [
            [
                'id' => 'calistung-tk',
                'slug' => 'calistung-tk',
                'title' => 'Calistung TK',
                'description' => 'Program ini dibuat khusus untuk Sahabat Rumba Athaya yang masih duduk di Taman Kanak-kanak agar bisa lebih cepat membaca, menulis serta menghitung.',
                'icon' => 'ph-scribble-loop',
                'color' => 'amber',
                'badge' => 'POPULER',
                'borderColor' => 'border-amber-200 hover:border-brand-orange',
                'bgColor' => 'bg-amber-100',
                'iconColor' => 'text-brand-orange',
                'buttonColor' => 'bg-brand-orange hover:bg-amber-600',
                'shadowColor' => 'shadow-orange-500/30',
            ],
            [
                'id' => 'calistung-sd',
                'slug' => 'sd-kelas-1-3',
                'title' => 'Calistung Kelas 1-3 SD',
                'description' => 'Sahabat Rumba yang masih duduk di sekolah dasar pasti mau kan jadi juara di sekolah. Rumba Athaya bisa banget bantu kamu agar nilai rapormu meningkat, sehingga kamu bisa jadi juara di sekolah. Kamu akan BELAJAR dengan tutor yang akrab dan berkualitas, serta akan dibiasakan untuk BERLATIH mengerjakan berbagai variasi soal yang mirip dengan ujianmu di sekolah. Kamu juga akan BERPRESTASI baik prestasi Akademik maupun non akademik.',
                'icon' => 'ph-book',
                'color' => 'blue',
                'borderColor' => 'border-blue-200 hover:border-brand-blue',
                'bgColor' => 'bg-blue-100',
                'iconColor' => 'text-brand-blue',
                'buttonColor' => 'bg-brand-blue hover:bg-blue-700',
                'shadowColor' => 'shadow-blue-500/30',
                'levels' => ['1 SD', '2 SD', '3 SD'],
            ],
            [
                'id' => 'kelas-4-6-sd',
                'slug' => 'sd-kelas-4-6',
                'title' => 'Kelas 4-5-6 SD',
                'description' => 'Sahabat Rumba yang masih duduk di sekolah dasar pasti mau kan jadi juara di sekolah dan masuk ke SMP favorit? Rumba Athaya bisa banget bantu kamu agar nilai rapormu meningkat, sehingga kamu bisa jadi juara di sekolah dan masuk SMP favorit.',
                'icon' => 'ph-graduation-cap',
                'color' => 'green',
                'borderColor' => 'border-green-200 hover:border-green-500',
                'bgColor' => 'bg-green-100',
                'iconColor' => 'text-green-600',
                'buttonColor' => 'bg-green-500 hover:bg-green-600',
                'shadowColor' => 'shadow-green-500/30',
                'levels' => ['4 SD', '5 SD', '6 SD'],
            ],
            [
                'id' => 'kelas-7-9-smp',
                'slug' => 'smp-kelas-7-9',
                'title' => 'Kelas 7-8-9 SMP',
                'description' => 'Sahabat Rumba Athaya yang masih duduk di bangku SMP pasti mau kan jadi juara di sekolah dan masuk ke SMA favorit? Rumba Athaya bisa banget bantu kamu agar nilai rapormu meningkat, sehingga kamu bisa jadi juara di sekolah dan masuk SMA favorit. Di sini kamu akan BELAJAR bareng pengajar yang akrab dan berkualitas, serta ada banyak variasi soal yang mirip dengan ujian di sekolahmu untuk BERLATIH. Melalui aplikasi Rumba Athaya akan BERTANDING dengan mengikuti Try Out yang bisa diakses di mana saja.',
                'icon' => 'ph-student',
                'color' => 'purple',
                'borderColor' => 'border-purple-200 hover:border-purple-500',
                'bgColor' => 'bg-purple-100',
                'iconColor' => 'text-purple-600',
                'buttonColor' => 'bg-purple-500 hover:bg-purple-600',
                'shadowColor' => 'shadow-purple-500/30',
                'levels' => ['7 SMP', '8 SMP', '9 SMP'],
            ],
            [
                'id' => 'tahfidz',
                'slug' => 'kelas-tahfidz',
                'title' => 'Kelas Tahfidz',
                'description' => 'Sahabat Rumba Athaya yang ingin mendalami ilmu agama terutama hafalan serta tahsin kami di Bimbel Rumba Athaya juga mengakomodir kebutuhan Sahabat Rumba Athaya. Yuk pokoknya lengkap banget!',
                'icon' => 'ph-book-open-text',
                'color' => 'amber',
                'borderColor' => 'border-amber-200 hover:border-brand-orange',
                'bgColor' => 'bg-amber-100',
                'iconColor' => 'text-brand-orange',
                'buttonColor' => 'bg-brand-orange hover:bg-amber-600',
                'shadowColor' => 'shadow-orange-500/30',
            ],
            [
                'id' => 'rumba-edulive-online',
                'slug' => 'rumba-edulive-online',
                'title' => 'Rumba Edulive Kelas Online',
                'description' => 'Kelas belajar interaktif secara online dari rumah bersama tutor pilihan. Memudahkan Sahabat Rumba di seluruh penjuru wilayah untuk mendapatkan bimbingan belajar berkualitas.',
                'icon' => 'ph-video-camera',
                'color' => 'indigo',
                'borderColor' => 'border-indigo-200 hover:border-brand-blue',
                'bgColor' => 'bg-indigo-50',
                'iconColor' => 'text-indigo-600',
                'buttonColor' => 'bg-indigo-600 hover:bg-indigo-700',
                'shadowColor' => 'shadow-indigo-500/30',
            ],
        ];
    @endphp

    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
        <!-- Premium Hero Section -->
        <x-premium-hero :badge="['icon' => 'ph-graduation-cap', 'text' => 'Program Unggulan']" title="Program"
            titleHighlight="Pilihan"
            description="Pilih program yang sesuai dengan kebutuhan Sahabat Rumba untuk meraih prestasi terbaik" />

        <section class="relative -mt-20 z-10 pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="space-y-12">
                    @foreach($programs as $index => $program)
                        <x-animated-card delay="{{ $index * 0.1 }}"
                            class="bg-white rounded-[2rem] p-8 md:p-12 shadow-lg shadow-gray-200/50 border-2 {{ $program['borderColor'] }} transition duration-300">
                            <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 {{ $program['bgColor'] }} rounded-xl sm:rounded-[2rem] flex items-center justify-center {{ $program['iconColor'] }} text-3xl sm:text-4xl flex-shrink-0 shadow-lg {{ $program['shadowColor'] }}"
                                    x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                                    :style="hovered ? 'transform: scale(1.1) rotate(5deg)' : ''"
                                    style="transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
                                    <i class="ph {{ $program['icon'] }}"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-4">
                                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $program['title'] }}</h2>
                                        @if(isset($program['badge']))
                                            <span class="px-3 py-1 bg-brand-orange text-white text-xs font-bold rounded-full w-fit">
                                                {{ $program['badge'] }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-gray-700 text-base sm:text-lg leading-relaxed mb-4 sm:mb-6">
                                        {{ $program['description'] }}
                                    </p>
                                    @if(isset($program['levels']))
                                        <div class="{{ $program['bgColor'] }} rounded-xl p-4 mb-4">
                                            <p class="text-sm text-gray-700 font-semibold mb-2">Program ini tersedia untuk tingkat
                                                kelas:</p>
                                            <ul class="text-sm text-gray-600 space-y-1">
                                                @foreach($program['levels'] as $level)
                                                    <li>• {{ $level }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-4">
                                        <a href="{{ route('program.show', $program['slug']) }}"
                                            class="px-6 py-3 {{ $program['buttonColor'] }} text-white rounded-xl font-semibold hover:shadow-xl hover:-translate-y-1 transition shadow-lg {{ $program['shadowColor'] }} inline-flex items-center justify-center">
                                            <i class="ph ph-eye mr-2"></i>
                                            Lihat Program
                                        </a>
                                        <a href="{{ route('register') }}"
                                            class="px-6 py-3 border-2 {{ $program['borderColor'] }} {{ $program['iconColor'] }} rounded-xl font-semibold hover:{{ $program['buttonColor'] }} hover:text-white transition inline-flex items-center justify-center">
                                            <i class="ph ph-user-plus mr-2"></i>
                                            Daftar Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </x-animated-card>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection