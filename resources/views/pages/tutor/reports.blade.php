@extends('layouts.tutor')

@section('title', 'Laporan Siswa')

@section('content')
    @php
        $tutor = auth()->user();
        $schedules = \App\Models\Schedule::where('tutor_id', $tutor->id)
            ->where('is_active', true)
            ->with(['student', 'subject'])
            ->get();

        $reports = \App\Models\StudentReport::whereIn('student_id', $schedules->pluck('student_id'))
            ->with(['student', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);
    @endphp

    <div class="space-y-8 p-4 sm:p-8">
        <!-- Hero Section -->
        <div class="relative overflow-hidden rounded-[2.5rem] bg-rose-600 p-8 text-white shadow-xl shadow-rose-600/20">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-600 via-pink-600 to-fuchsia-600"></div>
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
            <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-rose-100 mb-4">
                        <i class="ph ph-file-text text-yellow-300 text-lg"></i>
                        <span>Tutor Dashboard</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Laporan Siswa</h1>
                    <p class="text-rose-100 font-medium max-w-lg text-sm sm:text-base">
                        Pantau perkembangan dan hasil belajar siswa secara berkala.
                    </p>
                </div>

                <button
                    class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-rose-600 font-bold shadow-lg shadow-black/5 hover:bg-rose-50 hover:-translate-y-1 transition-all duration-300">
                    <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                    <span>Buat Laporan</span>
                </button>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-glass-card class="p-6 bg-white/60">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center shadow-sm">
                        <i class="ph-fill ph-files text-3xl text-indigo-600"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800">{{ $reports->total() }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Laporan</p>
                    </div>
                </div>
            </x-glass-card>

            <x-glass-card class="p-6 bg-white/60">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center shadow-sm">
                        <i class="ph-fill ph-users text-3xl text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800">{{ $schedules->unique('student_id')->count() }}
                        </h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Siswa</p>
                    </div>
                </div>
            </x-glass-card>

            <x-glass-card class="p-6 bg-white/60">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center shadow-sm">
                        <i class="ph-fill ph-star text-3xl text-orange-600"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800">
                            {{ number_format($reports->avg('score') ?? 0, 1) }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Rata-rata Nilai</p>
                    </div>
                </div>
            </x-glass-card>
        </div>

        @if($reports->count() > 0)
            <!-- Reports List -->
            <div class="space-y-4">
                @foreach($reports as $report)
                    <x-glass-card class="p-6 hover:scale-[1.01] transition-transform duration-300 bg-white/60">
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <div class="flex-1 w-full">
                                <div class="flex items-start gap-4 mb-3">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center text-white font-bold shrink-0 shadow-lg shadow-rose-500/20">
                                        {{ strtoupper(substr($report->student->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h3 class="text-lg font-bold text-slate-900">
                                                {{ $report->student->name ?? 'Siswa' }}
                                            </h3>
                                            @if($report->subject)
                                                <span
                                                    class="px-2 py-1 rounded-lg text-[10px] uppercase font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                                    {{ $report->subject->name }}
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="font-bold text-slate-700 mb-1 line-clamp-1">{{ $report->title ?? 'Laporan' }}
                                        </h4>
                                        <div class="flex items-center gap-2 text-xs font-medium text-slate-400">
                                            <i class="ph-bold ph-calendar-blank"></i>
                                            <span>{{ $report->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                @if($report->description)
                                    <div class="pl-16">
                                        <p
                                            class="text-sm text-slate-600 line-clamp-2 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">
                                            {{ $report->description }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div
                                class="flex flex-row sm:flex-col items-center sm:items-end w-full sm:w-auto gap-4 sm:gap-6 border-t sm:border-t-0 p-4 sm:p-0 border-slate-100">
                                <div class="text-left sm:text-right flex-1 sm:flex-none">
                                    <p
                                        class="text-4xl font-extrabold {{ $report->score >= 80 ? 'text-green-500' : ($report->score >= 60 ? 'text-amber-500' : 'text-rose-500') }}">
                                        {{ $report->score ?? 'N/A' }}
                                    </p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Nilai Akhir</p>
                                </div>
                                <div class="flex gap-2">
                                    <button
                                        class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all flex items-center justify-center">
                                        <i class="ph-bold ph-pencil-simple text-lg"></i>
                                    </button>
                                    <button
                                        class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center">
                                        <i class="ph-bold ph-trash text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </x-glass-card>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reports->hasPages())
                <div class="mt-6">
                    {{ $reports->links() }}
                </div>
            @endif
        @else
            <div class="py-12">
                <x-empty-state icon="ph-file-text" title="Laporan Kosong"
                    description="Belum ada laporan hasil belajar yang dibuat. Klik tombol 'Buat Laporan' untuk memulai." />
            </div>
        @endif
    </div>
@endsection