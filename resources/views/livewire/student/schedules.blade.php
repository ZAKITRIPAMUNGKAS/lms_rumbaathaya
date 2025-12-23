<div class="space-y-6 p-4 sm:p-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="ph ph-calendar-check text-indigo-600"></i>
                Jadwal Belajar
            </h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Pantau jadwal pembelajaran mingguan Anda</p>
        </div>
        <!-- Action / Time -->
        <div class="hidden sm:flex items-center gap-3">
            <div
                class="px-4 py-2 bg-slate-50 rounded-xl border border-slate-200 text-sm font-bold text-slate-600 flex items-center gap-2">
                <i class="ph ph-clock text-lg text-indigo-500"></i>
                {{ now()->format('d M Y') }}
            </div>
        </div>
    </div>

    @if($schedules->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                <i class="ph ph-calendar-slash text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Jadwal</h3>
            <p class="text-slate-500 max-w-sm mx-auto">
                Anda belum memiliki jadwal pembelajaran aktif saat ini.
            </p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
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
    @endif
</div>