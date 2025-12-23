@extends('layouts.app')

@section('page-title', 'Materi Pembelajaran')
@section('page-description', 'Akses semua materi pembelajaran Anda')

@section('content')
@php
    $student = auth()->user()->student;
    $materials = $student 
        ? \App\Models\Material::where('class_level_id', $student->class_level_id)
            ->with(['subject', 'classLevel', 'uploader'])
            ->orderBy('created_at', 'desc')
            ->paginate(12)
        : collect();
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Materi Pembelajaran</h1>
            <p class="text-slate-600">Akses semua materi pembelajaran sesuai jenjang Anda</p>
        </div>
        <div class="flex items-center gap-2">
            <select id="filter-subject" class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Semua Mata Pelajaran</option>
                @foreach(\App\Models\Subject::all() as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    @if($materials->count() > 0)
        <!-- Materials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($materials as $material)
                <x-glass-card class="p-6 hover:scale-[1.02] transition-transform duration-300 cursor-pointer group">
                    <div class="space-y-4">
                        <!-- Material Header -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 rounded-lg text-xs font-bold {{ $material->subject ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $material->subject ? $material->subject->name : 'Umum' }}
                                    </span>
                                    @if($material->classLevel)
                                        <span class="px-2 py-1 rounded-lg text-xs font-bold bg-orange-100 text-orange-700">
                                            {{ $material->classLevel->name }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                    {{ $material->title }}
                                </h3>
                            </div>
                        </div>

                        <!-- Material Description -->
                        @if($material->description)
                            <p class="text-sm text-slate-600 line-clamp-2">
                                {{ $material->description }}
                            </p>
                        @endif

                        <!-- Material Info -->
                        <div class="flex items-center justify-between pt-4 border-t border-slate-200">
                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $material->created_at->format('d M Y') }}</span>
                            </div>
                            @if($material->uploader)
                                <div class="text-xs text-slate-500">
                                    Oleh: {{ $material->uploader->name }}
                                </div>
                            @endif
                        </div>

                        <!-- Material Actions -->
                        <div class="flex items-center gap-2 pt-2">
                            @if($material->file_path)
                                <a href="{{ asset('storage/' . $material->file_path) }}" 
                                   target="_blank"
                                   class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold text-sm hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Download
                                </a>
                            @endif
                            @if($material->video_url)
                                <a href="{{ $material->video_url }}" 
                                   target="_blank"
                                   class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Video
                                </a>
                            @endif
                        </div>
                    </div>
                </x-glass-card>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($materials->hasPages())
            <div class="flex justify-center">
                {{ $materials->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <x-empty-state 
            icon="ph-book-open"
            title="Belum Ada Materi"
            description="Belum ada materi pembelajaran yang tersedia untuk jenjang Anda saat ini."
        />
    @endif
</div>

@push('scripts')
<script>
    // Filter by subject
    document.getElementById('filter-subject')?.addEventListener('change', function() {
        const subjectId = this.value;
        const url = new URL(window.location.href);
        if (subjectId) {
            url.searchParams.set('subject', subjectId);
        } else {
            url.searchParams.delete('subject');
        }
        window.location.href = url.toString();
    });
</script>
@endpush
@endsection
