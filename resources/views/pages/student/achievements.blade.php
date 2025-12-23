@extends('layouts.app')

@section('page-title', 'Pencapaian')
@section('page-description', 'Lihat pencapaian dan prestasi Anda')

@section('content')
@php
    $student = auth()->user()->student;
    $reports = $student 
        ? \App\Models\StudentReport::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get()
        : collect();
    
    // Calculate achievements from reports
    $totalReports = $reports->count();
    $averageScore = $reports->avg('score') ?? 0;
    $highestScore = $reports->max('score') ?? 0;
    $completedMaterials = $student ? \App\Models\Material::where('class_level_id', $student->class_level_id)->count() : 0;
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Pencapaian & Prestasi</h1>
        <p class="text-slate-600">Lihat pencapaian dan prestasi belajar Anda</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-glass-card class="p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-slate-900">{{ number_format($averageScore, 1) }}</p>
                    <p class="text-sm text-slate-600">Rata-rata Nilai</p>
                </div>
            </div>
        </x-glass-card>

        <x-glass-card class="p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $highestScore }}</p>
                    <p class="text-sm text-slate-600">Nilai Tertinggi</p>
                </div>
            </div>
        </x-glass-card>

        <x-glass-card class="p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $totalReports }}</p>
                    <p class="text-sm text-slate-600">Laporan Selesai</p>
                </div>
            </div>
        </x-glass-card>

        <x-glass-card class="p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-extrabold text-slate-900">{{ $completedMaterials }}</p>
                    <p class="text-sm text-slate-600">Materi Tersedia</p>
                </div>
            </div>
        </x-glass-card>
    </div>

    <!-- Recent Reports -->
    @if($reports->count() > 0)
        <div>
            <h2 class="text-xl font-bold text-slate-900 mb-4">Laporan Terbaru</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($reports->take(6) as $report)
                    <x-glass-card class="p-6">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-slate-900">{{ $report->title ?? 'Laporan' }}</h3>
                                <span class="px-2 py-1 rounded-lg text-xs font-bold bg-indigo-100 text-indigo-700">
                                    {{ $report->score ?? 'N/A' }}
                                </span>
                            </div>
                            @if($report->description)
                                <p class="text-sm text-slate-600 line-clamp-2">{{ $report->description }}</p>
                            @endif
                            <div class="flex items-center justify-between pt-2 border-t border-slate-200">
                                <span class="text-xs text-slate-500">
                                    {{ $report->created_at->format('d M Y') }}
                                </span>
                                <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    </x-glass-card>
                @endforeach
            </div>
        </div>
    @else
        <x-empty-state 
            icon="ph-trophy"
            title="Belum Ada Pencapaian"
            description="Belum ada laporan atau pencapaian yang tercatat saat ini."
        />
    @endif

    <!-- Badges Section -->
    <div>
        <h2 class="text-xl font-bold text-slate-900 mb-4">Lencana Prestasi</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @php
                $badges = [
                    ['name' => 'Pemula', 'icon' => '🌟', 'earned' => true],
                    ['name' => 'Rajin', 'icon' => '📚', 'earned' => $totalReports >= 5],
                    ['name' => 'Juara', 'icon' => '🏆', 'earned' => $highestScore >= 90],
                    ['name' => 'Konsisten', 'icon' => '💪', 'earned' => $totalReports >= 10],
                    ['name' => 'Sempurna', 'icon' => '⭐', 'earned' => $highestScore >= 100],
                    ['name' => 'Master', 'icon' => '👑', 'earned' => $totalReports >= 20 && $averageScore >= 85],
                ];
            @endphp
            @foreach($badges as $badge)
                <x-glass-card class="p-4 text-center {{ $badge['earned'] ? '' : 'opacity-50' }}">
                    <div class="text-4xl mb-2">{{ $badge['icon'] }}</div>
                    <p class="text-sm font-semibold text-slate-900">{{ $badge['name'] }}</p>
                    @if($badge['earned'])
                        <p class="text-xs text-green-600 mt-1">✓ Diperoleh</p>
                    @else
                        <p class="text-xs text-slate-400 mt-1">Belum</p>
                    @endif
                </x-glass-card>
            @endforeach
        </div>
    </div>
</div>
@endsection
