@extends('layouts.tutor')

@section('title', 'Materi Pembelajaran')

@section('content')
@php
    $tutor = auth()->user();
    $materials = \App\Models\Material::where('uploaded_by', $tutor->id)
        ->with(['subject', 'classLevel'])
        ->orderBy('created_at', 'desc')
        ->paginate(12);
@endphp

<div class="space-y-8 p-4 sm:p-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-emerald-600 p-8 text-white shadow-xl shadow-emerald-500/20">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600"></div>
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-emerald-100 mb-4">
                    <i class="ph ph-books text-yellow-300 text-lg"></i>
                    <span>Tutor Dashboard</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Bank Materi</h1>
                <p class="text-emerald-100 font-medium max-w-lg text-sm sm:text-base">
                    Simpan dan kelola modul pembelajaran Anda di sini.
                </p>
            </div>
            
            <a href="{{ route('tutor.materials.create') }}" class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-emerald-600 font-bold shadow-lg shadow-black/5 hover:bg-emerald-50 hover:-translate-y-1 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Upload Materi</span>
            </a>
        </div>
    </div>

    @if($materials->count() > 0)
        <!-- Materials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($materials as $material)
                <x-glass-card class="p-6 hover:scale-[1.02] transition-transform duration-300 bg-white/60 group">
                    <div class="space-y-4">
                        <!-- Material Header -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $material->subject ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">
                                        {{ $material->subject ? $material->subject->name : 'Umum' }}
                                    </span>
                                    @if($material->classLevel)
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-orange-50 text-orange-600 border border-orange-100">
                                            {{ $material->classLevel->name }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-1 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                    {{ $material->title }}
                                </h3>
                            </div>
                        </div>

                        <!-- Material Description -->
                        @if($material->description)
                            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
                                {{ strip_tags($material->description) }}
                            </p>
                        @endif

                        <!-- Material Info -->
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100/50">
                            <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                                <i class="ph-bold ph-calendar-blank"></i>
                                <span>{{ $material->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Material Actions -->
                        <div class="flex items-center gap-2 pt-2">
                             @if($material->file_path)
                                <a href="{{ asset('storage/' . $material->file_path) }}" 
                                   target="_blank"
                                   class="flex-1 px-4 py-2.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl font-bold text-xs hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center gap-2 group/btn">
                                    <i class="ph-bold ph-download-simple group-hover/btn:animate-bounce"></i>
                                    Download
                                </a>
                            @endif
                            <a href="{{ route('tutor.materials.edit', $material->id) }}" 
                               class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-amber-50 hover:text-amber-500 transition-colors" title="Edit">
                                <i class="ph-bold ph-pencil-simple"></i>
                            </a>
                        </div>
                    </div>
                </x-glass-card>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($materials->hasPages())
            <div class="mt-6">
                {{ $materials->links() }}
            </div>
        @endif
    @else
        <div class="py-12">
            <x-empty-state 
                icon="ph-books"
                title="Bank Materi Kosong"
                description="Anda belum mengupload materi pembelajaran. Klik tombol 'Upload Materi' untuk memulai."
            />
        </div>
    @endif
</div>
@endsection
