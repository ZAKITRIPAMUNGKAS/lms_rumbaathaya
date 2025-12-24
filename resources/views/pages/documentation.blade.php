@extends('layouts.landing')

@section('title', 'Dokumentasi')

@section('content')
@php
    $documentations = \App\Models\Documentation::orderBy('event_date', 'desc')->get();
    $photos = $documentations->where('type', 'photo');
    $videos = $documentations->where('type', 'video');
@endphp

<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <!-- Premium Hero Section -->
    <x-premium-hero 
        :badge="['icon' => 'ph-camera', 'text' => 'Dokumentasi']"
        title="Dokumentasi"
        titleHighlight="Kegiatan"
        description="Kumpulan foto dan video kegiatan belajar, event, dan karya siswa Rumba Athaya"
    />

    <!-- Main Content -->
    <section class="relative -mt-20 z-10 py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'photos' }">
            <!-- Tabs -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex bg-white rounded-2xl p-1.5 shadow-lg border border-gray-100">
                    <button @click="activeTab = 'photos'"
                            :class="activeTab === 'photos' ? 'bg-gradient-to-r from-brand-orange to-orange-600 text-white shadow-lg' : 'text-gray-600 hover:text-gray-900'"
                            class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2">
                        <i class="ph ph-images text-xl"></i>
                        <span>Foto</span>
                        @if($photos->count() > 0)
                            <span :class="activeTab === 'photos' ? 'bg-white/20' : 'bg-gray-100'"
                                  class="text-xs px-2 py-0.5 rounded-full">
                                {{ $photos->count() }}
                            </span>
                        @endif
                    </button>
                    <button @click="activeTab = 'videos'"
                            :class="activeTab === 'videos' ? 'bg-gradient-to-r from-brand-orange to-orange-600 text-white shadow-lg' : 'text-gray-600 hover:text-gray-900'"
                            class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 flex items-center gap-2">
                        <i class="ph ph-play-circle text-xl"></i>
                        <span>Video</span>
                        @if($videos->count() > 0)
                            <span :class="activeTab === 'videos' ? 'bg-white/20' : 'bg-gray-100'"
                                  class="text-xs px-2 py-0.5 rounded-full">
                                {{ $videos->count() }}
                            </span>
                        @endif
                    </button>
                </div>
            </div>

            <!-- Photos Tab -->
            <div x-show="activeTab === 'photos'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                @if($photos->count() === 0)
                    <div class="text-center py-20">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="ph ph-images text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Foto</h3>
                        <p class="text-gray-600">Foto dokumentasi akan ditampilkan di sini setelah diupload</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6"
                         x-data="{ selectedPhoto: null }">
                        @foreach($photos as $index => $photo)
                            <div @click="selectedPhoto = @js($photo)"
                                 class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                                 x-data="{ loaded: true }"
                                 x-intersect="loaded = true"
                                 x-show="loaded"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-1 scale-100"
                                 style="transition-delay: {{ $index * 0.05 }}s">
                                <img src="{{ $photo->file_path ? \Storage::url($photo->file_path) : '' }}" 
                                     alt="{{ $photo->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                                        <h3 class="font-bold text-sm mb-1 line-clamp-2">{{ $photo->title }}</h3>
                                        @if($photo->event_date)
                                            <p class="text-xs text-white/80">
                                                {{ \Carbon\Carbon::parse($photo->event_date)->locale('id')->isoFormat('d MMMM yyyy') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="absolute top-3 right-3 w-10 h-10 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <i class="ph ph-magnifying-glass-plus text-brand-orange text-lg"></i>
                                </div>
                            </div>
                        @endforeach

                        <!-- Lightbox Modal -->
                        <div x-show="selectedPhoto !== null"
                             style="display: none;"
                             @click.self="selectedPhoto = null"
                             @keydown.escape.window="selectedPhoto = null"
                             class="fixed inset-0 z-50 bg-black/90 backdrop-blur-sm flex items-center justify-center p-4"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0">
                            <div @click.stop
                                 class="relative max-w-6xl w-full max-h-[90vh]"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-1 scale-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-1 scale-100"
                                 x-transition:leave-end="opacity-0 scale-90">
                                <button @click="selectedPhoto = null"
                                        class="absolute -top-12 right-0 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors">
                                    <i class="ph ph-x text-xl"></i>
                                </button>
                                
                                <div class="bg-white rounded-2xl overflow-hidden shadow-2xl">
                                    <div class="relative aspect-video bg-gray-900">
                                        <img x-bind:src="selectedPhoto ? '{{ \Storage::url('') }}' + selectedPhoto.file_path : ''"
                                             x-bind:alt="selectedPhoto?.title"
                                             class="w-full h-full object-contain">
                                    </div>
                                    <div class="p-6">
                                        <h3 x-text="selectedPhoto?.title" class="text-2xl font-bold text-gray-900 mb-2"></h3>
                                        <p x-show="selectedPhoto?.description" x-text="selectedPhoto?.description" class="text-gray-600 mb-4"></p>
                                        <div x-show="selectedPhoto?.event_date" class="flex items-center gap-2 text-sm text-gray-500">
                                            <i class="ph ph-calendar"></i>
                                            <span x-text="selectedPhoto ? new Date(selectedPhoto.event_date).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : ''"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Videos Tab -->
            <div x-show="activeTab === 'videos'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 style="display: none;">
                @if($videos->count() === 0)
                    <div class="text-center py-20">
                        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="ph ph-play-circle text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Video</h3>
                        <p class="text-gray-600">Video dokumentasi akan ditampilkan di sini setelah diupload</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($videos as $index => $video)
                            @php
                                $videoId = null;
                                if ($video->video_url) {
                                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video->video_url, $matches);
                                    $videoId = $matches[1] ?? null;
                                }
                            @endphp
                            <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1"
                                 x-data="{ loaded: true }"
                                 x-intersect="loaded = true"
                                 x-show="loaded"
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 scale-90"
                                 x-transition:enter-end="opacity-1 scale-100"
                                 style="transition-delay: {{ $index * 0.05 }}s">
                                @if($videoId)
                                    <div class="relative aspect-video bg-gray-900">
                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                                                title="{{ $video->title }}"
                                                class="w-full h-full"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                    </div>
                                @else
                                    <div class="relative aspect-video bg-gray-900 flex items-center justify-center">
                                        <i class="ph ph-play-circle text-6xl text-white/50"></i>
                                    </div>
                                @endif
                                <div class="p-5">
                                    <h3 class="font-bold text-lg text-gray-900 mb-2 line-clamp-2">{{ $video->title }}</h3>
                                    @if($video->description)
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $video->description }}</p>
                                    @endif
                                    @if($video->event_date)
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <i class="ph ph-calendar"></i>
                                            <span>{{ \Carbon\Carbon::parse($video->event_date)->locale('id')->isoFormat('d MMMM yyyy') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection

