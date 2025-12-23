@extends('layouts.tutor')

@section('title', 'Absensi')

@section('content')
    @php
        $tutor = auth()->user();
        $today = now();
        $attendances = \App\Models\Attendance::where('tutor_id', $tutor->id)
            ->whereDate('date', $today)
            ->with(['student', 'schedule'])
            ->orderBy('created_at', 'desc')
            ->get();

        $schedules = \App\Models\Schedule::where('tutor_id', $tutor->id)
            ->where('is_active', true)
            ->with(['student', 'subject'])
            ->get();
    @endphp

    <div class="space-y-8 p-4 sm:p-8">
        <!-- Hero Section -->
        <div class="relative overflow-hidden rounded-[2.5rem] bg-violet-600 p-8 text-white shadow-xl shadow-violet-600/20">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-600 via-purple-600 to-fuchsia-600"></div>
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
            <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-violet-100 mb-4">
                        <i class="ph ph-clipboard-text text-yellow-300 text-lg"></i>
                        <span>Tutor Dashboard</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Absensi</h1>
                    <p class="text-violet-100 font-medium max-w-lg text-sm sm:text-base">
                        Kelola kehadiran siswa Anda hari ini dengan mudah dan cepat.
                    </p>
                </div>

                <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md p-1.5 rounded-2xl border border-white/20">
                    <input type="date" value="{{ $today->format('Y-m-d') }}"
                        class="bg-transparent border-0 text-white placeholder-white/70 focus:ring-0 text-sm font-bold min-w-[140px] [&::-webkit-calendar-picker-indicator]:invert [&::-webkit-calendar-picker-indicator]:cursor-pointer">
                </div>
            </div>
        </div>

        <!-- Today's Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <x-glass-card class="p-6 bg-white/60">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center shadow-sm">
                        <i class="ph-fill ph-check-circle text-3xl text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800">
                            {{ $attendances->where('status', 'present')->count() }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hadir</p>
                    </div>
                </div>
            </x-glass-card>

            <x-glass-card class="p-6 bg-white/60">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center shadow-sm">
                        <i class="ph-fill ph-x-circle text-3xl text-red-600"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800">
                            {{ $attendances->where('status', 'absent')->count() }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tidak Hadir</p>
                    </div>
                </div>
            </x-glass-card>

            <x-glass-card class="p-6 bg-white/60">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center shadow-sm">
                        <i class="ph-fill ph-info text-3xl text-amber-600"></i>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold text-slate-800">
                            {{ $attendances->where('status', 'permission')->count() }}</h3>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Izin</p>
                    </div>
                </div>
            </x-glass-card>
        </div>

        <!-- Attendance List -->
        @if($schedules->count() > 0)
            <x-glass-card class="p-6 sm:p-8 bg-white/60">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-black text-slate-800">Daftar Siswa</h2>
                        <p class="text-sm text-slate-500 font-medium">Jadwal hari ini</p>
                    </div>
                    <!-- Optional: Bulk Action Button -->
                </div>

                <div class="space-y-4">
                    @foreach($schedules as $schedule)
                        @php
                            $attendance = $attendances->firstWhere('schedule_id', $schedule->id);
                            $student = $schedule->student;
                        @endphp
                        <div
                            class="group flex flex-col sm:flex-row sm:items-center justify-between p-5 rounded-2xl bg-white/50 border border-white/60 hover:border-violet-200 hover:shadow-lg hover:shadow-violet-500/5 transition-all duration-300 gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-md shadow-indigo-500/20">
                                    {{ strtoupper(substr($student->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-lg">{{ $student->name ?? 'Siswa' }}</h3>
                                    <p class="text-sm text-slate-500 font-medium flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-violet-400"></span>
                                        {{ $schedule->subject ? $schedule->subject->name : 'Umum' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="px-4 py-2 rounded-xl bg-white border border-slate-200 flex items-center gap-2">
                                    <i class="ph-bold ph-clock text-slate-400"></i>
                                    <span class="text-sm font-bold text-slate-700">
                                        {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }}
                                    </span>
                                </div>

                                <select
                                    class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-sm font-bold text-slate-700 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 cursor-pointer">
                                    <option value="present" {{ $attendance && $attendance->status === 'present' ? 'selected' : '' }}>
                                        Hadir</option>
                                    <option value="absent" {{ $attendance && $attendance->status === 'absent' ? 'selected' : '' }}>
                                        Tidak Hadir</option>
                                    <option value="permission" {{ $attendance && $attendance->status === 'permission' ? 'selected' : '' }}>Izin</option>
                                </select>

                                <button
                                    class="w-10 h-10 rounded-xl bg-violet-600 text-white flex items-center justify-center hover:bg-violet-700 shadow-lg shadow-violet-500/30 transition-all hover:scale-105 active:scale-95"
                                    title="Simpan">
                                    <i class="ph-bold ph-check"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-glass-card>
        @else
            <div class="py-12">
                <x-empty-state icon="ph-calendar-x" title="Tidak Ada Jadwal"
                    description="Hore! Tidak ada jadwal mengajar untuk hari ini." />
            </div>
        @endif
    </div>
@endsection