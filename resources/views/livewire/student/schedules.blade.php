<div class="space-y-6 p-4 sm:p-8">
    <!-- Header Card -->
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-violet-600 to-fuchsia-600 p-6 sm:p-8 text-white shadow-lg shadow-violet-500/20 mb-6 group">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-fuchsia-400/20 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-bold border border-white/10 text-white mb-3">
                    <i class="ph ph-calendar-check"></i>
                    Jadwal Kelas
                </span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">Jadwal Belajar</h1>
                <p class="text-indigo-100 text-xs sm:text-sm font-medium mt-1">Pantau jadwal pembelajaran mingguan Anda</p>
            </div>
            <div class="px-4 py-2 bg-white/15 backdrop-blur-md rounded-xl border border-white/15 text-xs sm:text-sm font-bold text-white flex items-center gap-2">
                <i class="ph ph-clock text-lg"></i>
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </div>

    @if($schedules->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-28 h-28 mb-4 transform hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('maskot.png') }}" alt="Mascot Rumba" class="w-full h-full object-contain opacity-75 filter drop-shadow-sm">
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Jadwal</h3>
            <p class="text-slate-500 max-w-sm mx-auto">
                Anda belum memiliki jadwal pembelajaran aktif saat ini.
            </p>
        </div>
    @else
        <!-- Desktop Grid View (Visible on Desktop, hidden on Mobile) -->
        <div class="hidden md:grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- Iterate through days of the week to maintain order -->
            @php
                $orderedDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $todayName = now()->format('l');
            @endphp

            @foreach($orderedDays as $dayEnglish)
                @php
                    $daySchedules = $groupedSchedules->get($dayEnglish);
                    $isToday = $dayEnglish === $todayName;
                    $dayIndo = $daysOfWeek[$dayEnglish];

                    // Card Styles
                    $cardClass = $isToday
                        ? 'bg-gradient-to-br from-indigo-600 to-violet-600 text-white shadow-xl shadow-indigo-500/30 transform scale-[1.02]'
                        : 'bg-white/80 backdrop-blur-xl border border-white/60 hover:border-indigo-200 hover:shadow-lg';

                    $textPrimary = $isToday ? 'text-white' : 'text-slate-800';
                    $textSecondary = $isToday ? 'text-indigo-100' : 'text-slate-500';
                    $iconClass = $isToday ? 'text-white/80' : 'text-indigo-500';
                    $itemBg = $isToday ? 'bg-white/10 border-white/20' : 'bg-slate-50 border-slate-100 group-hover:bg-white';
                @endphp

                <div
                    class="rounded-[2rem] p-5 {{ $cardClass }} transition-all duration-300 flex flex-col h-full relative overflow-hidden group">
                    @if($isToday)
                        <div class="absolute top-0 right-0 p-4">
                            <span
                                class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold border border-white/20">Hari
                                Ini</span>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3 class="text-xl font-extrabold {{ $textPrimary }} mb-1">{{ $dayIndo }}</h3>
                        <p class="text-xs font-bold uppercase tracking-wider {{ $textSecondary }}">
                            {{ $daySchedules ? $daySchedules->count() . ' Sesi' : 'Tidak ada jadwal' }}
                        </p>
                    </div>

                    <div class="space-y-3 flex-1">
                        @if($daySchedules && $daySchedules->isNotEmpty())
                            @foreach($daySchedules as $schedule)
                                <div class="p-3.5 rounded-2xl border {{ $itemBg }} transition-colors">
                                    <div class="flex items-start justify-between mb-2">
                                        <span
                                            class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $isToday ? 'bg-white text-indigo-600' : 'bg-indigo-100 text-indigo-700' }}">
                                            {{ $schedule->subject->name ?? 'Materi' }}
                                        </span>
                                        <div class="flex items-center gap-1 text-xs font-bold {{ $textSecondary }}">
                                            <i class="ph ph-clock"></i>
                                            {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }}
                                        </div>
                                    </div>

                                    @if($schedule->tutor)
                                        <div class="flex items-center gap-2 mt-2">
                                            <div
                                                class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold {{ $isToday ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-600' }}">
                                                {{ substr($schedule->tutor->name, 0, 1) }}
                                            </div>
                                            <span class="text-xs font-semibold {{ $textPrimary }} truncate">
                                                {{ $schedule->tutor->name }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="flex flex-col items-center justify-center h-24 text-center opacity-50">
                                <i class="ph ph-coffee text-2xl mb-2"></i>
                                <span class="text-xs font-medium">Libur</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Mobile List View (Visible on Mobile, hidden on Desktop) -->
        <div class="md:hidden space-y-4">
            @foreach($orderedDays as $dayEnglish)
                @php
                    $daySchedules = $groupedSchedules->get($dayEnglish);
                    $isToday = $dayEnglish === $todayName;
                    $dayIndo = $daysOfWeek[$dayEnglish];
                @endphp
                
                <div class="p-4 rounded-[2rem] bg-white border border-slate-100/80 shadow-sm relative overflow-hidden {{ $isToday ? 'ring-2 ring-indigo-500/20 bg-indigo-50/5' : '' }}">
                    @if($isToday)
                        <span class="absolute top-4 right-4 px-2 py-0.5 bg-indigo-100 text-indigo-700 text-[9px] font-black uppercase rounded-full border border-indigo-200">Hari Ini</span>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-slate-800 text-base">{{ $dayIndo }}</span>
                            @if($daySchedules && $daySchedules->isNotEmpty())
                                <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-[10px] font-bold">{{ $daySchedules->count() }} Sesi</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($daySchedules && $daySchedules->isNotEmpty())
                        <div class="space-y-2 mt-3">
                            @foreach($daySchedules as $schedule)
                                <div class="p-3 rounded-xl bg-slate-50/70 border border-slate-100/50 flex items-center justify-between gap-4">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded-md bg-indigo-100 text-indigo-700 text-[9px] font-black uppercase tracking-wider">
                                                {{ $schedule->subject->name ?? 'Materi' }}
                                            </span>
                                            <span class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                                                <i class="ph ph-clock text-indigo-400"></i>
                                                {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }}
                                            </span>
                                        </div>
                                        @if($schedule->tutor)
                                            <div class="flex items-center gap-1.5 mt-1.5 text-xs text-slate-600">
                                                <i class="ph-fill ph-user text-slate-400"></i>
                                                <span class="font-semibold truncate text-[11px]">{{ $schedule->tutor->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-[10px] font-bold text-slate-400 bg-slate-100/50 px-2 py-1 rounded-md shrink-0">
                                        {{ $schedule->location ?? 'Ruang Kelas' }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex items-center gap-2 text-slate-400/80 mt-1">
                            <i class="ph ph-coffee text-sm"></i>
                            <span class="text-xs font-semibold">Libur — Tidak ada jadwal</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>