@extends('layouts.app')

@section('page-title', 'Transkrip Nilai')
@section('page-description', 'Lihat transkrip nilai dan riwayat pembelajaran Anda')

@section('content')
@php
    $student = auth()->user()->student;
    $reports = $student 
        ? \App\Models\StudentReport::where('student_id', $student->id)
            ->with(['subject'])
            ->orderBy('created_at', 'desc')
            ->get()
        : collect();
    
    $reportsBySubject = $reports->groupBy('subject_id');
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Transkrip Nilai</h1>
            <p class="text-slate-600">Lihat transkrip nilai dan riwayat pembelajaran Anda</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold text-sm hover:bg-indigo-700 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download PDF
            </button>
        </div>
    </div>

    @if($reports->count() > 0)
        <!-- Summary Card -->
        <x-glass-card class="p-6 bg-gradient-to-br from-indigo-50 to-purple-50">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-slate-600 mb-1">Total Laporan</p>
                    <p class="text-3xl font-extrabold text-slate-900">{{ $reports->count() }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 mb-1">Rata-rata Nilai</p>
                    <p class="text-3xl font-extrabold text-slate-900">{{ number_format($reports->avg('score') ?? 0, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-600 mb-1">Nilai Tertinggi</p>
                    <p class="text-3xl font-extrabold text-slate-900">{{ $reports->max('score') ?? 0 }}</p>
                </div>
            </div>
        </x-glass-card>

        <!-- Reports by Subject -->
        @foreach($reportsBySubject as $subjectId => $subjectReports)
            @php
                $subject = $subjectReports->first()->subject;
                $subjectAverage = $subjectReports->avg('score');
            @endphp
            <x-glass-card class="p-6">
                <div class="space-y-4">
                    <!-- Subject Header -->
                    <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">{{ $subject ? $subject->name : 'Umum' }}</h2>
                            <p class="text-sm text-slate-600">{{ $subjectReports->count() }} laporan</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-slate-600">Rata-rata</p>
                            <p class="text-2xl font-extrabold text-indigo-600">{{ number_format($subjectAverage, 1) }}</p>
                        </div>
                    </div>

                    <!-- Reports List -->
                    <div class="space-y-3">
                        @foreach($subjectReports as $report)
                            <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-slate-900 mb-1">{{ $report->title ?? 'Laporan' }}</h3>
                                    @if($report->description)
                                        <p class="text-sm text-slate-600 line-clamp-1">{{ $report->description }}</p>
                                    @endif
                                    <p class="text-xs text-slate-500 mt-1">{{ $report->created_at->format('d M Y') }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-2xl font-extrabold {{ $report->score >= 80 ? 'text-green-600' : ($report->score >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $report->score ?? 'N/A' }}
                                        </p>
                                        <p class="text-xs text-slate-500">Nilai</p>
                                    </div>
                                    <a href="#" class="px-3 py-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-glass-card>
        @endforeach
    @else
        <!-- Empty State -->
        <x-empty-state 
            icon="ph-file-text"
            title="Belum Ada Transkrip"
            description="Belum ada laporan atau nilai yang tercatat saat ini."
        />
    @endif
</div>
@endsection
