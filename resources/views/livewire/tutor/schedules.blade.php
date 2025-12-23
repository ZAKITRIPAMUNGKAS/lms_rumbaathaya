<div class="space-y-6 p-4 sm:p-8">
    <!-- Hero Section (Dashboard Style) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div
            class="lg:col-span-2 relative overflow-hidden rounded-[2.5rem] bg-amber-600 p-6 sm:p-8 text-white shadow-xl shadow-amber-600/20">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500 via-amber-600 to-orange-600"></div>
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
            <div class="absolute top-0 left-0 w-40 h-40 bg-orange-500/20 rounded-full blur-2xl -ml-10 -mt-10"></div>

            <div
                class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 h-full">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-amber-100 mb-4">
                        <i class="ph ph-calendar-check text-yellow-300 text-sm"></i>
                        <span>{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight leading-tight">
                        Jadwal Mengajar 📅
                    </h1>
                    <p class="text-amber-100 font-medium max-w-md text-sm sm:text-base">
                        Lihat semua jadwal mengajar Anda dalam satu tempat
                    </p>
                </div>
                <div
                    class="hidden md:flex w-32 h-32 bg-white/10 backdrop-blur-md rounded-full border border-white/20 items-center justify-center shadow-inner text-5xl">
                    🎓
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div
            class="bg-white/80 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-4 sm:p-6 shadow-sm flex flex-col justify-center gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shadow-sm">
                    <i class="ph ph-calendar text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Jadwal</p>
                    <h3 class="text-2xl font-extrabold text-slate-800">{{ $schedules->flatten()->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule List -->
    @if($schedules->isEmpty())
        <div class="bg-white/80 backdrop-blur-xl border border-white/60 rounded-2xl p-12 text-center">
            <i class="ph ph-calendar-x text-5xl text-amber-300 mb-3"></i>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Belum ada Jadwal</h3>
            <p class="text-sm text-gray-500">Anda belum memiliki jadwal mengajar yang aktif</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($schedules as $day => $daySchedules)
                <div class="space-y-3">
                    <!-- Day Header -->
                    <div class="flex items-center gap-2 px-1">
                        <h2 class="text-lg font-bold text-gray-800">{{ $dayNamesIndo[$day] }}</h2>
                        @if($day === now()->format('l'))
                            <span
                                class="px-2.5 py-0.5 text-xs font-bold bg-amber-100 text-amber-700 rounded-full border border-amber-200">
                                Hari Ini
                            </span>
                        @endif
                    </div>

                    <!-- Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($daySchedules as $schedule)
                            @php
                                $hasAttendance = $schedule->has_attendance_today;
                            @endphp

                            <div
                                class="group relative bg-white/80 backdrop-blur-md border {{ $hasAttendance ? 'border-emerald-200 bg-emerald-50/50' : 'border-white/60' }} rounded-xl p-4 hover:shadow-lg transition-all hover:-translate-y-0.5">

                                <!-- Time & Status -->
                                <div class="flex items-center justify-between mb-3">
                                    <div
                                        class="flex items-center gap-1.5 text-sm font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-100">
                                        <i class="ph-bold ph-clock text-xs"></i>
                                        {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($schedule->time_end)->format('H:i') }}
                                    </div>
                                    @if($hasAttendance)
                                        <i class="ph-fill ph-check-circle text-emerald-500 text-xl"></i>
                                    @endif
                                </div>

                                <!-- Student Name -->
                                <h3 class="font-bold text-gray-900 mb-2 group-hover:text-amber-700 transition-colors">
                                    {{ $schedule->student->name }}
                                </h3>

                                <!-- Info Tags -->
                                <div class="flex flex-wrap gap-1.5 mb-3">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                        <i class="ph ph-graduation-cap text-xs"></i>
                                        {{ $schedule->student->classLevel->name }}
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                        <i class="ph ph-book-open text-xs"></i>
                                        {{ $schedule->subject->name }}
                                    </span>
                                </div>

                                <!-- Status -->
                                <div class="pt-2.5 border-t border-gray-100">
                                    @if($hasAttendance)
                                        <span class="text-xs text-emerald-600 font-semibold flex items-center gap-1">
                                            <i class="ph-fill ph-check text-sm"></i>
                                            Sudah absen
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 flex items-center gap-1">
                                            <i class="ph ph-clock-countdown text-sm"></i>
                                            Belum absen
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>