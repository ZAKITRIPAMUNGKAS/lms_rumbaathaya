@extends('layouts.app')

@section('page-title', 'Jadwal Pembelajaran')
@section('page-description', 'Lihat jadwal pembelajaran Anda')

@section('content')
@php
    $student = auth()->user()->student;
    $schedules = $student 
        ? \App\Models\Schedule::where('student_id', $student->id)
            ->where('is_active', true)
            ->with(['tutor', 'subject'])
            ->orderBy('day_of_week')
            ->orderBy('time_start')
            ->get()
        : collect();
    
    $daysOfWeek = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu',
    ];
    
    // Map day names to numbers for comparison
    $dayNameToNumber = [
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6,
        'Sunday' => 7,
    ];
    
    $schedulesByDay = $schedules->groupBy('day_of_week');
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Jadwal Pembelajaran</h1>
        <p class="text-slate-600">Lihat jadwal pembelajaran Anda untuk minggu ini</p>
    </div>

    @if($schedules->count() > 0)
        <!-- Weekly Schedule -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-7 gap-4">
            @php
                $dayNameToNumber = [
                    'Monday' => 1,
                    'Tuesday' => 2,
                    'Wednesday' => 3,
                    'Thursday' => 4,
                    'Friday' => 5,
                    'Saturday' => 6,
                    'Sunday' => 7,
                ];
                $numberToDayName = array_flip($dayNameToNumber);
                $today = now();
                $currentDayOfWeek = $today->dayOfWeek === 0 ? 7 : $today->dayOfWeek;
            @endphp
            @foreach($daysOfWeek as $dayNumber => $dayName)
                @php
                    $dayNameKey = $numberToDayName[$dayNumber] ?? null;
                    $daySchedules = $dayNameKey ? $schedulesByDay->get($dayNameKey, collect()) : collect();
                    $isToday = $currentDayOfWeek === $dayNumber;
                @endphp
                <x-glass-card class="p-4 {{ $isToday ? 'ring-2 ring-indigo-500 bg-indigo-50/50' : '' }}">
                    <div class="space-y-3">
                        <!-- Day Header -->
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="font-bold text-slate-900 {{ $isToday ? 'text-indigo-700' : '' }}">
                                {{ $dayName }}
                            </h3>
                            @if($isToday)
                                <span class="px-2 py-1 rounded-lg text-xs font-bold bg-indigo-600 text-white">
                                    Hari Ini
                                </span>
                            @endif
                        </div>

                        <!-- Schedules for this day -->
                        @if($daySchedules->count() > 0)
                            <div class="space-y-2">
                                @foreach($daySchedules as $schedule)
                                    <div class="p-3 rounded-xl bg-white border border-slate-200 hover:border-indigo-300 hover:shadow-md transition-all">
                                        <div class="flex items-start justify-between gap-2 mb-2">
                                            <div class="flex-1 min-w-0">
                                                <p class="font-semibold text-sm text-slate-900 mb-1">
                                                    {{ $schedule->subject ? $schedule->subject->name : 'Umum' }}
                                                </p>
                                                <p class="text-xs text-slate-600 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($schedule->time_end)->format('H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        @if($schedule->tutor)
                                            <div class="flex items-center gap-2 mt-2 pt-2 border-t border-slate-100">
                                                <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-xs font-bold">
                                                    {{ strtoupper(substr($schedule->tutor->name, 0, 1)) }}
                                                </div>
                                                <p class="text-xs text-slate-600 truncate">
                                                    {{ $schedule->tutor->name }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-400 text-center py-4">Tidak ada jadwal</p>
                        @endif
                    </div>
                </x-glass-card>
            @endforeach
        </div>

        <!-- Upcoming Schedule -->
        @php
            $today = now();
            $currentDayOfWeek = $today->dayOfWeek === 0 ? 7 : $today->dayOfWeek;
            $currentTime = $today->format('H:i:s');
            
            $upcomingSchedules = $schedules->filter(function($schedule) use ($currentDayOfWeek, $currentTime, $dayNameToNumber) {
                $scheduleDayNumber = $dayNameToNumber[$schedule->day_of_week] ?? 0;
                if ($scheduleDayNumber === 0) return false;
                
                // Check if schedule is in the future
                if ($scheduleDayNumber > $currentDayOfWeek) {
                    return true;
                }
                // If same day, check if time is in the future
                if ($scheduleDayNumber == $currentDayOfWeek) {
                    $scheduleTime = $schedule->time_start instanceof \Carbon\Carbon 
                        ? $schedule->time_start->format('H:i:s')
                        : $schedule->time_start;
                    return $scheduleTime > $currentTime;
                }
                return false;
            })->sortBy(function($schedule) use ($currentDayOfWeek, $dayNameToNumber) {
                $scheduleDayNumber = $dayNameToNumber[$schedule->day_of_week] ?? 0;
                $dayDiff = $scheduleDayNumber - $currentDayOfWeek;
                if ($dayDiff < 0) $dayDiff += 7;
                
                $scheduleTime = $schedule->time_start instanceof \Carbon\Carbon 
                    ? $schedule->time_start->format('H:i:s')
                    : $schedule->time_start;
                $timeValue = str_replace(':', '', $scheduleTime);
                
                return $dayDiff * 10000 + (int)$timeValue;
            })->take(3);
        @endphp

        @if($upcomingSchedules->count() > 0)
            <div class="mt-8">
                <h2 class="text-xl font-bold text-slate-900 mb-4">Jadwal Selanjutnya</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($upcomingSchedules as $schedule)
                        <x-glass-card class="p-4">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    @php
                                        $scheduleDayNumber = $dayNameToNumber[$schedule->day_of_week] ?? 0;
                                        $scheduleDayName = $scheduleDayNumber > 0 ? $daysOfWeek[$scheduleDayNumber] : $schedule->day_of_week;
                                    @endphp
                                    <span class="px-2 py-1 rounded-lg text-xs font-bold bg-indigo-100 text-indigo-700">
                                        {{ $scheduleDayName }}
                                    </span>
                                    <span class="text-xs text-slate-500">
                                        {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($schedule->time_end)->format('H:i') }}
                                    </span>
                                </div>
                                <h3 class="font-semibold text-slate-900">
                                    {{ $schedule->subject ? $schedule->subject->name : 'Umum' }}
                                </h3>
                                @if($schedule->tutor)
                                    <p class="text-sm text-slate-600">
                                        Tutor: {{ $schedule->tutor->name }}
                                    </p>
                                @endif
                            </div>
                        </x-glass-card>
                    @endforeach
                </div>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <x-empty-state 
            icon="ph-calendar"
            title="Belum Ada Jadwal"
            description="Belum ada jadwal pembelajaran yang tersedia untuk Anda saat ini."
        />
    @endif
</div>
@endsection
