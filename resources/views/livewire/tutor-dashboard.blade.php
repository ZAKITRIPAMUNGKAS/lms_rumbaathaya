<div class="space-y-8 p-4 sm:p-8">
    <!-- Hero Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div
            class="lg:col-span-2 relative overflow-hidden rounded-[2.5rem] bg-violet-600 p-6 sm:p-8 text-white shadow-xl shadow-violet-600/20">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-600 via-purple-600 to-fuchsia-600"></div>
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
            <div class="absolute top-0 left-0 w-40 h-40 bg-pink-500/20 rounded-full blur-2xl -ml-10 -mt-10"></div>
            <div
                class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 h-full">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-violet-100 mb-4">
                        <i class="ph ph-wifi-high text-yellow-300 text-sm"></i>
                        <span>Sistem Online</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight leading-tight">
                        Halo, {{ explode(' ', auth()->user()->name)[0] ?? 'Tutor' }}! 👋
                    </h1>
                    @php
                        $todaySchedules = $schedules->filter(function ($s) {
                            $dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                            return $s->day_of_week === $dayNames[now()->dayOfWeek];
                        });
                    @endphp
                    <p class="text-violet-100 font-medium max-w-md text-sm sm:text-base">
                        Anda memiliki <span class="text-white font-bold">{{ $todaySchedules->count() }} kelas</span>
                        hari ini. Persiapkan materi Anda.
                    </p>
                </div>
                <div class="hidden md:flex w-32 h-32 bg-white/10 backdrop-blur-md rounded-full border-2 border-white/20 shadow-lg overflow-hidden">
                    @if(auth()->user()->avatar_url)
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-white/20 to-white/10 flex items-center justify-center text-white text-4xl font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- System Stats Small -->
        <div
            class="bg-white/80 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-4 sm:p-6 shadow-sm flex flex-col justify-center gap-4 sm:gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-fuchsia-100 text-fuchsia-600 flex items-center justify-center shadow-sm">
                    <i class="ph ph-users text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ $stats['active_students'] ?? 0 }}</h3>
                </div>
            </div>
            <div class="h-px w-full bg-slate-100"></div>
            <div class="space-y-3">
                <div class="flex justify-between text-xs font-bold text-slate-600">
                    <span>Kelas Aktif</span>
                    <span>{{ $stats['active_classes'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-xs font-bold text-slate-600">
                    <span>Absensi Bulan Ini</span>
                    <span>{{ $stats['monthly_attendance'] ?? 0 }}</span>
                </div>
                <div class="flex justify-between text-xs font-bold text-slate-600">
                    <span>Status</span>
                    <span class="text-emerald-600">Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Siswa Ajar -->
        <x-glass-card hover="true" class="p-5 h-full flex items-center gap-4 bg-white/60 group">
            <div
                class="p-3.5 rounded-2xl transition-all duration-300 group-hover:scale-110 shadow-sm border border-blue-100 bg-blue-100 text-blue-600">
                <i class="ph ph-users text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $stats['active_students'] ?? 0 }}
                </h3>
                <p class="text-[11px] uppercase tracking-wider font-semibold text-slate-500">Siswa Ajar</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Total Aktif</p>
            </div>
        </x-glass-card>

        <!-- Kelas Aktif -->
        <x-glass-card hover="true" class="p-5 h-full flex items-center gap-4 bg-white/60 group">
            <div
                class="p-3.5 rounded-2xl transition-all duration-300 group-hover:scale-110 shadow-sm border border-amber-100 bg-amber-100 text-amber-600">
                <i class="ph ph-chalkboard-teacher text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $stats['active_classes'] ?? 0 }}
                </h3>
                <p class="text-[11px] uppercase tracking-wider font-semibold text-slate-500">Kelas Aktif</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Total Jadwal</p>
            </div>
        </x-glass-card>

        <!-- Materi Uploaded -->
        <x-glass-card hover="true" class="p-5 h-full flex items-center gap-4 bg-white/60 group">
            <div
                class="p-3.5 rounded-2xl transition-all duration-300 group-hover:scale-110 shadow-sm border border-emerald-100 bg-emerald-100 text-emerald-600">
                <i class="ph ph-books text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                    {{ $stats['materials_uploaded'] ?? 0 }}</h3>
                <p class="text-[11px] uppercase tracking-wider font-semibold text-slate-500">Materi</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Total Upload</p>
            </div>
        </x-glass-card>

        <!-- Absensi Hari Ini -->
        <x-glass-card hover="true" class="p-5 h-full flex items-center gap-4 bg-white/60 group">
            <div
                class="p-3.5 rounded-2xl transition-all duration-300 group-hover:scale-110 shadow-sm border border-violet-100 bg-violet-100 text-violet-600">
                <i class="ph ph-clipboard-text text-xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-extrabold text-slate-800 tracking-tight">{{ $stats['today_attendance'] ?? 0 }}
                </h3>
                <p class="text-[11px] uppercase tracking-wider font-semibold text-slate-500">Absensi</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Hari Ini</p>
            </div>
        </x-glass-card>
    </div>

    <!-- Stats & Schedules -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Schedule List -->
        <div class="lg:col-span-2">
            <x-glass-card hover="false" class="p-6 bg-white/60">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-800">Jadwal Hari Ini</h3>
                    <a href="{{ route('tutor.schedules.index') }}"
                        class="text-sm font-bold text-violet-600 hover:bg-violet-50 px-3 py-1.5 rounded-lg transition-colors">Lihat
                        Semua</a>
                </div>
                <div class="space-y-3">
                    @if($todaySchedules->count() > 0)
                        @foreach($todaySchedules->take(3) as $idx => $schedule)
                            @php
                                $isActive = $idx === 0;
                                $scheduleType = $schedule->type ?? 'onsite';
                                $isOnline = $scheduleType === 'online';
                                $timeDisplay = ($schedule->time_start ?? '00:00') . ($schedule->time_end ? ' - ' . $schedule->time_end : '');
                                $timeHour = explode(':', $schedule->time_start ?? '00:00')[0];
                                $location = $schedule->student ? 'Siswa: ' . ($schedule->student->name ?? 'Tidak diketahui') : ($schedule->location ?? 'Ruang Kelas');
                            @endphp
                            <a href="{{ route('tutor.schedules.index') }}"
                                class="flex items-center gap-4 p-4 rounded-2xl border transition-all duration-300 group cursor-pointer hover:scale-[1.02] active:scale-[0.98] {{ $isActive ? 'bg-violet-50 border-violet-100 shadow-sm' : 'bg-white border-slate-100 hover:shadow-md' }}">
                                <div
                                    class="flex flex-col items-center justify-center w-14 h-14 rounded-2xl font-bold border {{ $isActive ? 'bg-violet-600 text-white border-violet-600' : 'bg-white text-slate-500 border-slate-200 group-hover:bg-violet-50 group-hover:text-violet-600 transition-colors' }}">
                                    <span class="text-[10px] uppercase opacity-80">Jam</span>
                                    <span class="text-lg leading-none">{{ $timeHour }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <h4 class="font-bold truncate {{ $isActive ? 'text-violet-900' : 'text-slate-700' }}">
                                            {{ $schedule->subject->name ?? 'Kelas' }}</h4>
                                        <span
                                            class="text-[10px] font-bold px-2 py-0.5 rounded-full border flex items-center gap-1 {{ $isOnline ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-orange-50 text-orange-600 border-orange-100' }}">
                                            @if($isOnline)
                                                <i class="ph ph-video-camera text-xs"></i>
                                                Zoom
                                            @else
                                                <i class="ph ph-map-pin text-xs"></i>
                                                Onsite
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500 font-medium flex items-center gap-1 mt-1">
                                        <i class="ph ph-clock text-xs"></i>
                                        {{ $timeDisplay }}
                                    </p>
                                    @if($location)
                                        <p class="text-xs text-slate-400 font-medium flex items-center gap-1 mt-0.5">
                                            <i class="ph ph-user text-xs"></i>
                                            {{ $location }}
                                        </p>
                                    @endif
                                </div>
                                @if($isActive)
                                    <div class="w-2 h-2 rounded-full bg-violet-500 animate-pulse"></div>
                                @endif
                            </a>
                        @endforeach
                    @else
                        <div class="text-center py-10 text-slate-400">
                            <i class="ph ph-calendar-slash text-4xl mb-3 opacity-30"></i>
                            <p class="text-sm font-medium">Tidak ada jadwal hari ini</p>
                        </div>
                    @endif
                </div>
            </x-glass-card>
        </div>

        <!-- Placeholder Graph -->
        <div>
            <x-glass-card hover="false"
                class="p-6 h-full flex flex-col justify-center items-center text-slate-400 bg-white/40">
                <i class="ph ph-chart-line-up text-4xl mb-3 opacity-30"></i>
                <p class="text-sm font-medium">Grafik Perkembangan</p>
                <p class="text-xs opacity-70">Data akan muncul setelah ada aktivitas</p>
            </x-glass-card>
        </div>
    </div>
</div>