@extends('layouts.landing')

@section('meta')
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 200) }}">
    @if($post->thumbnail)
        <meta property="og:image" content="{{ asset('uploads/' . $post->thumbnail) }}">
        <meta property="og:image:secure_url" content="{{ asset('uploads/' . $post->thumbnail) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="{{ $post->title }}">
        <meta property="og:image:type" content="image/jpeg">
    @endif
    @if($post->published_at)
        <meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
    @endif
    @if($post->updated_at)
        <meta property="article:modified_time" content="{{ $post->updated_at->toIso8601String() }}">
    @endif
    @if($post->category)
        <meta property="article:section" content="{{ $post->category }}">
        <meta property="article:tag" content="{{ $post->category }}">
    @endif
    <meta property="article:author" content="Rumba Athaya">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 200) }}">
    @if($post->thumbnail)
        <meta name="twitter:image" content="{{ asset('uploads/' . $post->thumbnail) }}">
        <meta name="twitter:image:alt" content="{{ $post->title }}">
    @endif
@endsection

@section('title', $post->title)
@section('description', $post->excerpt ?? Str::limit(strip_tags($post->content), 200))
@section('og_type', 'article')
@if($post->thumbnail)
    @section('og_image', asset('uploads/' . $post->thumbnail))
@endif

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Animated Background Blobs -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-300/20 to-indigo-300/20 rounded-full blur-3xl animate-blob">
            </div>
            <div
                class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-br from-purple-300/20 to-pink-300/20 rounded-full blur-3xl animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 w-96 h-96 bg-gradient-to-br from-indigo-300/20 to-blue-300/20 rounded-full blur-3xl animate-blob animation-delay-4000">
            </div>
        </div>

        <!-- Hero Section -->
        <section class="relative pt-32 pb-12 overflow-hidden">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <!-- Back Button -->
                <a href="{{ route('posts.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white/80 backdrop-blur-md border border-indigo-100 rounded-xl text-indigo-600 font-semibold hover:bg-white hover:shadow-lg transition-all mb-6 group">
                    <span class="group-hover:-translate-x-1 transition-transform">←</span>
                    <span>Kembali ke Blog</span>
                </a>

                <!-- Hero Card -->
                <div
                    class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white/60 shadow-2xl overflow-hidden">
                    @if(!empty($post->thumbnail))
                        <div class="relative h-64 sm:h-80 md:h-96 overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
                            <img src="{{ asset('uploads/' . $post->thumbnail) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center\'><div class=\'text-white text-center p-8\'><i class=\'ph-bold ph-image text-6xl mb-4 opacity-50\'></i><p class=\'text-lg font-semibold opacity-75\'>Gambar tidak tersedia</p></div></div>';">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                        </div>
                    @else
                        <div
                            class="relative h-64 sm:h-80 md:h-96 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 overflow-hidden flex items-center justify-center">
                            <div class="absolute inset-0 opacity-10">
                                <div class="absolute top-10 left-10 w-32 h-32 bg-white rounded-full blur-2xl"></div>
                                <div class="absolute bottom-10 right-10 w-40 h-40 bg-white rounded-full blur-3xl"></div>
                                <div
                                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 bg-white rounded-full blur-3xl">
                                </div>
                            </div>
                            <div class="relative z-10 text-white text-center p-8">
                                <i class="ph-bold ph-newspaper text-7xl mb-4 opacity-80"></i>
                                <p class="text-2xl font-bold opacity-90">Sahabat RA</p>
                            </div>
                        </div>
                    @endif

                    <div class="p-6 sm:p-8 md:p-12">
                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center gap-3 mb-6">
                            @if($post->category)
                                <span
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-full text-sm font-bold shadow-lg">
                                    <i class="ph-fill ph-tag"></i>
                                    {{ $post->category }}
                                </span>
                            @endif
                            <span
                                class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-indigo-700 rounded-full text-sm font-semibold border border-indigo-200">
                                <i class="ph-fill ph-calendar"></i>
                                {{ $post->published_at ? $post->published_at->locale('id')->isoFormat('D MMMM Y') : 'Draft' }}
                            </span>
                            @if($post->author)
                                <span
                                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 rounded-full text-sm font-semibold border border-purple-200">
                                    <i class="ph-fill ph-user"></i>
                                    {{ $post->author }}
                                </span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h1
                            class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-900 leading-tight mb-6">
                            {{ $post->title }}
                        </h1>

                        <!-- Excerpt -->
                        @if($post->excerpt)
                            <p class="text-lg sm:text-xl text-slate-600 leading-relaxed mb-8 font-medium">
                                {{ $post->excerpt }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Content Section -->
        <section class="relative py-12">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div
                    class="bg-white/80 backdrop-blur-xl rounded-[2rem] border border-white/60 shadow-xl p-6 sm:p-8 md:p-12">
                    <!-- Article Content with Typography -->
                    <article class="prose prose-lg prose-indigo max-w-none
                            prose-headings:font-extrabold prose-headings:text-slate-900
                            prose-p:text-slate-700 prose-p:leading-relaxed
                            prose-a:text-indigo-600 prose-a:font-semibold prose-a:no-underline hover:prose-a:underline
                            prose-strong:text-slate-900 prose-strong:font-bold
                            prose-ul:list-disc prose-ol:list-decimal
                            prose-li:text-slate-700
                            prose-blockquote:border-l-4 prose-blockquote:border-indigo-500 prose-blockquote:bg-indigo-50 prose-blockquote:rounded-r-xl prose-blockquote:py-2
                            prose-img:rounded-2xl prose-img:shadow-lg
                            prose-hr:border-slate-200">
                        {!! $post->content !!}
                    </article>

                    <!-- Share Section -->
                    <div class="mt-12 pt-8 border-t border-slate-200">
                        <p class="text-sm font-bold text-slate-600 mb-4">Bagikan Artikel:</p>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-xl font-semibold hover:bg-blue-600 transition-colors shadow-lg">
                                <i class="ph-fill ph-facebook-logo"></i>
                                Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-sky-500 text-white rounded-xl font-semibold hover:bg-sky-600 transition-colors shadow-lg">
                                <i class="ph-fill ph-twitter-logo"></i>
                                Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-xl font-semibold hover:bg-green-600 transition-colors shadow-lg">
                                <i class="ph-fill ph-whatsapp-logo"></i>
                                WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Posts Section -->
        @if(isset($relatedPosts) && $relatedPosts->count() > 0)
            <section class="relative py-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-3">
                            Baca Juga 📚
                        </h2>
                        <p class="text-lg text-slate-600">Artikel menarik lainnya untuk Anda</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedPosts as $related)
                            <a href="{{ route('posts.show', $related->slug) }}" class="group">
                                <div
                                    class="h-full bg-white/80 backdrop-blur-xl rounded-2xl border border-white/60 shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                                    @if(!empty($related->thumbnail))
                                        <div class="relative h-48 overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200">
                                            <img src="{{ asset('uploads/' . $related->thumbnail) }}" 
                                                 alt="{{ $related->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                 onerror="this.style.display='none'; this.parentElement.classList.add('bg-gradient-to-br', 'from-indigo-400', 'to-purple-500', 'flex', 'items-center', 'justify-center'); this.parentElement.innerHTML='<i class=\'ph-bold ph-image text-5xl text-white opacity-50\'></i>';">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                        </div>
                                    @else
                                        <div class="h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                            <i class="ph-bold ph-image text-5xl text-white opacity-50"></i>
                                        </div>
                                    @endif

                                    <div class="p-6">
                                        @if($related->category)
                                            <span
                                                class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold mb-3">
                                                {{ $related->category }}
                                            </span>
                                        @endif

                                        <h3
                                            class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                            {{ $related->title }}
                                        </h3>

                                        @if($related->excerpt)
                                            <p class="text-sm text-slate-600 line-clamp-3 mb-4">
                                                {{ $related->excerpt }}
                                            </p>
                                        @endif

                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <i class="ph ph-calendar"></i>
                                            {{ $related->published_at ? $related->published_at->locale('id')->isoFormat('D MMM Y') : 'Draft' }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>

    <!-- Custom CSS for Text Alignment Support -->
    <style>
        .prose .text-left {
            text-align: left !important;
        }

        .prose .text-center {
            text-align: center !important;
        }

        .prose .text-right {
            text-align: right !important;
        }

        .prose .text-justify {
            text-align: justify !important;
        }

        /* Ensure alignment classes work in prose */
        .prose [style*="text-align: left"] {
            text-align: left !important;
        }

        .prose [style*="text-align: center"] {
            text-align: center !important;
        }

        .prose [style*="text-align: right"] {
            text-align: right !important;
        }

        .prose [style*="text-align: justify"] {
            text-align: justify !important;
        }
    </style>
@endsection