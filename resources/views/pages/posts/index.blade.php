@extends('layouts.landing')

@section('title', 'Sahabat RA - Blog')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100">
    <!-- Premium Hero Section -->
    <x-premium-hero 
        :badge="['icon' => 'ph-newspaper', 'text' => 'Mading Online']"
        title="Sahabat RA"
        titleHighlight="Mading"
        description="Kabar terbaru, karya siswa, dan informasi pendidikan dari Rumba Athaya"
    />

    <section class="relative -mt-20 z-10 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($posts->count() === 0)
                <div class="text-center py-20">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="ph ph-newspaper text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Artikel</h3>
                    <p class="text-gray-600">Artikel akan segera hadir di sini.</p>
                </div>
            @else
                <!-- Posts Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($posts as $index => $post)
                        <a href="{{ route('posts.show', $post->slug) }}" 
                           class="group block animate-fade-in-up"
                           style="animation-delay: {{ $index * 100 }}ms">
                            <x-glass-card hover="true" class="p-0 overflow-hidden h-full flex flex-col">
                                <!-- Thumbnail -->
                                <div class="relative h-48 overflow-hidden">
                                    @if($post->thumbnail)
                                        <img src="{{ $post->thumbnail_url }}" 
                                             alt="{{ $post->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-brand-orange/20 to-amber-50 flex items-center justify-center">
                                            <i class="ph ph-newspaper text-6xl text-brand-orange/30"></i>
                                        </div>
                                    @endif
                                    <!-- Category Badge -->
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1.5 bg-white/90 backdrop-blur-md rounded-full text-xs font-bold text-slate-700 shadow-lg">
                                            {{ $post->category ?? 'Artikel' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-6 flex-1 flex flex-col">
                                    <h3 class="text-xl font-extrabold text-slate-800 mb-2 line-clamp-2 group-hover:text-brand-orange transition-colors">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-slate-600 text-sm mb-4 line-clamp-3 flex-1">
                                        {{ Str::limit(strip_tags($post->content), 120) }}
                                    </p>
                                    <div class="flex items-center justify-between pt-4 border-t border-slate-200">
                                        <span class="text-xs text-slate-500">
                                            {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}
                                        </span>
                                        <span class="text-brand-orange font-semibold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
                                            Baca
                                            <i class="ph ph-arrow-right text-sm"></i>
                                        </span>
                                    </div>
                                </div>
                            </x-glass-card>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

