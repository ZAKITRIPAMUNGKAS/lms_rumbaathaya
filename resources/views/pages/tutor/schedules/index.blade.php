@extends('layouts.tutor')

@section('title', 'Jadwal Mengajar')

@section('content')
@php
    $tutor = auth()->user();
    $schedules = \App\Models\Schedule::where('tutor_id', $tutor->id)
        ->where('is_active', true)
        ->with(['student', 'subject'])
        ->orderBy('day_of_week')
        ->orderBy('time_start')
        ->get();
    
    $daysOfWeek = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];
    
    $schedulesByDay = $schedules->groupBy('day_of_week');
@endphp

<div class="space-y-8 p-4 sm:p-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-amber-500 p-8 text-white shadow-xl shadow-amber-500/20">
        <div class="absolute inset-0 bg-gradient-to-br from-amber-500 via-orange-500 to-yellow-500"></div>
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-amber-100 mb-4">
                    <i class="ph ph-calendar text-yellow-200 text-lg"></i>
                    <span>Tutor Dashboard</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Jadwal Mengajar</h1>
                <p class="text-amber-100 font-medium max-w-lg text-sm sm:text-base">
                    Atur dan lihat jadwal mengajar Anda dalam satu minggu.
                </p>
            </div>
            
            <a href="{{ route('tutor.schedules.create') }}" class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-amber-600 font-bold shadow-lg shadow-black/5 hover:bg-amber-50 hover:-translate-y-1 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Jadwal Baru</span>
            </a>
        </div>
    </div>

    @if($schedules->count() > 0)
        <!-- Weekly Schedule -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($daysOfWeek as $dayNumber => $dayName)
                @php
                    $daySchedules = $schedulesByDay->get($dayNumber, collect());
                    $isToday = now()->dayOfWeek === ($dayNumber === 7 ? 0 : $dayNumber);
                @endphp
                <x-glass-card class="h-full bg-white/60 p-5 {{ $isToday ? 'ring-2 ring-amber-500 shadow-xl shadow-amber-500/10' : '' }}">
                    <div class="space-y-4 h-full flex flex-col">
                        <!-- Day Header -->
                        <div class="flex items-center justify-between">
                            <h3 class="font-black text-xl text-slate-800 {{ $isToday ? 'text-amber-600' : '' }}">
                                {{ $dayName }}
                            </h3>
                            @if($isToday)
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-amber-500 text-white shadow-sm shimmer">
                                    Hari Ini
                                </span>
                            @endif
                        </div>

                        <!-- Schedules for this day -->
                        @if($daySchedules->count() > 0)
                            <div class="space-y-3 flex-1 overflow-y-auto custom-scrollbar max-h-[400px] pr-1">
                                @foreach($daySchedules as $schedule)
                                    <div class="group relative p-4 rounded-2xl bg-white border border-slate-100 hover:border-amber-200 hover:shadow-lg hover:shadow-amber-500/5 transition-all duration-300">
                                        <div class="flex items-start justify-between gap-3 mb-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-slate-50 border border-slate-100 mb-2">
                                                    <i class="ph-bold ph-clock text-xs text-slate-400"></i>
                                                    <span class="text-[10px] font-bold text-slate-600">
                                                        {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }}
                                                    </span>
                                                </div>
                                                <p class="font-bold text-slate-800 group-hover:text-amber-600 transition-colors line-clamp-1">
                                                    {{ $schedule->subject ? $schedule->subject->name : 'Umum' }}
                                                </p>
                                            </div>
                                            <button class="w-8 h-8 rounded-lg text-slate-300 hover:bg-amber-50 hover:text-amber-500 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                                                <i class="ph-bold ph-dots-three-vertical"></i>
                                            </button>
                                        </div>
                                        
                                        @if($schedule->student)
                                            <div class="flex items-center gap-3 pt-3 border-t border-slate-50">
                                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                                    {{ strtoupper(substr($schedule->student->name ?? 'S', 0, 1)) }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-xs font-bold text-slate-700 truncate group-hover:text-amber-600 transition-colors">
                                                        {{ $schedule->student->name ?? 'Siswa' }}
                                                    </p>
                                                    <p class="text-[10px] text-slate-400 truncate">Siswa</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex-1 flex flex-col items-center justify-center py-8 text-slate-400 border-2 border-dashed border-slate-100 rounded-2xl bg-slate-50/50">
                                <i class="ph-duotone ph-coffee text-3xl mb-2 opacity-50"></i>
                                <p class="text-xs font-medium">Kosong</p>
                            </div>
                        @endif
                    </div>
                </x-glass-card>
            @endforeach
        </div>
    @else
        <div class="py-12">
            <x-empty-state 
                icon="ph-calendar"
                title="Jadwal Kosong"
                description="Belum ada jadwal mengajar yang tersedia. Klik tombol 'Jadwal Baru' untuk memulai."
            />
        </div>
    @endif
</div>
@endsection
