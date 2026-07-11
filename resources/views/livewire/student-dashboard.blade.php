<div class="relative min-h-screen space-y-8 p-4 sm:p-8 overflow-hidden">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-violet-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-fuchsia-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-sky-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000">
        </div>
    </div>

    <!-- Hero Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div
            class="lg:col-span-2 relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-violet-500 to-fuchsia-600 p-8 text-white shadow-2xl shadow-violet-500/20 group">
            <!-- Background Decor -->
            <div
                class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16 group-hover:bg-white/20 transition-all duration-500">
            </div>
            <div
                class="absolute top-0 left-0 w-40 h-40 bg-amber-400/30 rounded-full blur-2xl -ml-10 -mt-10 group-hover:scale-110 transition-transform duration-500">
            </div>

            <div
                class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 h-full text-center md:text-left">
                <div class="flex-1">
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-white mb-6 shadow-sm hover:scale-105 transition-transform origin-left cursor-default">
                        <span class="text-lg">🎯</span>
                        <span>Target Mingguan: 80%</span>
                    </div>
                    <h1
                        class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                        Hai, {{ explode(' ', auth()->user()->name)[0] ?? 'Sahabat' }}! <span
                            class="animate-pulse inline-block">👋</span>
                    </h1>
                    <p class="text-violet-100 font-medium max-w-lg text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                        Siap untuk petualangan belajar hari ini? Klik fotomu untuk menggantinya! ✨
                    </p>
                </div>

                <!-- Profile Photo Uploader (Main Visual) -->
                <div class="relative group/avatar shrink-0">
                    <div
                        class="w-32 h-32 md:w-40 md:h-40 rounded-full p-1.5 bg-gradient-to-br from-white/50 to-white/20 backdrop-blur-md border border-white/30 shadow-[0_0_40px_rgba(255,255,255,0.3)] hover:scale-105 transition-transform duration-300">
                        <div
                            class="w-full h-full rounded-full overflow-hidden border-4 border-white/50 bg-white relative">
                            @if ($photo)
                                <div class="w-full h-full bg-cover bg-center"
                                    style="background-image: url('{{ $photo->temporaryUrl() }}')"></div>
                            @elseif (Auth::user()->avatar_url)
                                <img src="{{ Auth::user()->avatar_url }}" class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full bg-gradient-to-br from-violet-400 to-fuchsia-500 flex items-center justify-center text-5xl font-black text-white">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Floating Upload Button -->
                    <label for="dashboard-photo-upload"
                        class="absolute bottom-2 right-2 w-10 h-10 md:w-12 md:h-12 bg-fuchsia-500 hover:bg-fuchsia-400 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer transition-all hover:scale-110 hover:rotate-12 border-4 border-white/20 z-20">
                        <i class="ph-bold ph-camera text-lg md:text-xl"></i>
                    </label>
                    <input type="file" id="dashboard-photo-upload" wire:model="photo" class="hidden">

                    <div wire:loading wire:target="photo"
                        class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full backdrop-blur-sm z-30">
                        <i class="ph-bold ph-spinner animate-spin text-3xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gamification Card -->
        <div
            class="bg-white/60 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-6 shadow-xl shadow-fuchsia-500/5 flex flex-col justify-center gap-6 relative overflow-hidden group hover:bg-white/70 transition-colors">
            <!-- Decor -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-200/40 rounded-full blur-3xl -mr-16 -mt-16"></div>

            <div class="flex items-center gap-5 relative">
                <div
                    class="w-16 h-16 rounded-3xl bg-gradient-to-br from-amber-300 to-orange-400 flex items-center justify-center shadow-lg shadow-orange-500/20 group-hover:scale-110 transition-transform duration-300">
                    <i class="ph-fill ph-star text-3xl text-white"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total XP Kamu</p>
                    <h3 class="text-4xl font-black text-slate-800 tracking-tight">
                        {{ number_format((($stats['monthly_attendance'] ?? 0) * 10 + ($stats['completed_materials'] ?? 0) * 5)) }}
                    </h3>
                </div>
            </div>

            <div class="h-px w-full bg-slate-200/60"></div>

            <div class="space-y-5">
                <!-- Progress Card: Materi -->
                <div>
                    <div
                        class="flex justify-between text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-2">
                        <span>Materi Selesai</span>
                        <span
                            class="text-emerald-600">{{ $stats['completed_materials'] ?? 0 }}/{{ $stats['total_materials'] ?? 10 }}</span>
                    </div>
                    <div
                        class="h-4 w-full bg-slate-100/80 rounded-full overflow-hidden border border-slate-200/50 shadow-inner">
                        <div x-data="{ width: 0 }"
                            x-init="setTimeout(() => width = {{ min((($stats['completed_materials'] ?? 0) / max($stats['total_materials'] ?? 10, 1)) * 100, 100) }}, 100)"
                            class="h-full bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full transition-all duration-1000 ease-out shadow-sm relative"
                            :style="'width: ' + width + '%'">
                            <div class="absolute inset-0 bg-white/30 animate-pulse"></div>
                        </div>
                    </div>
                </div>
                <!-- Progress Card: Kehadiran -->
                <div>
                    <div
                        class="flex justify-between text-xs font-extrabold text-slate-600 uppercase tracking-wider mb-2">
                        <span>Kehadiran</span>
                        <span class="text-blue-600">{{ $stats['monthly_attendance'] ?? 0 }}/100</span>
                    </div>
                    <div
                        class="h-4 w-full bg-slate-100/80 rounded-full overflow-hidden border border-slate-200/50 shadow-inner">
                        <div x-data="{ width: 0 }"
                            x-init="setTimeout(() => width = {{ min((($stats['monthly_attendance'] ?? 0) / 100) * 100, 100) }}, 200)"
                            class="h-full bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full transition-all duration-1000 ease-out shadow-sm relative"
                            :style="'width: ' + width + '%'">
                            <div class="absolute inset-0 bg-white/30 animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Grid & Schedule -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Menu Buttons -->
        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-2 gap-4 sm:gap-6">
                <a href="{{ route('student.materials.index') }}"
                    class="group relative overflow-hidden p-6 sm:p-8 rounded-[2.5rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-2xl hover:bg-white/80 transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-blue-100/50 rounded-full blur-2xl -mr-10 -mt-10 group-hover:bg-blue-200/50 transition-colors">
                    </div>
                    <div class="flex flex-col items-center text-center gap-4 relative z-10">
                        <div
                            class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-sky-300 to-blue-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                            <i class="ph-fill ph-books text-4xl"></i>
                        </div>
                        <div>
                            <h3
                                class="text-xl font-black text-slate-800 mb-1 group-hover:text-blue-600 transition-colors">
                                Materi Belajar</h3>
                            <p class="text-sm text-slate-500 font-medium">Akses modul & video pembelajaran</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('student.schedules.index') }}"
                    class="group relative overflow-hidden p-6 sm:p-8 rounded-[2.5rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-2xl hover:bg-white/80 transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-violet-100/50 rounded-full blur-2xl -mr-10 -mt-10 group-hover:bg-violet-200/50 transition-colors">
                    </div>
                    <div class="flex flex-col items-center text-center gap-4 relative z-10">
                        <div
                            class="w-20 h-20 rounded-[2rem] bg-gradient-to-br from-violet-300 to-purple-500 text-white flex items-center justify-center shadow-lg shadow-violet-500/30 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                            <i class="ph-fill ph-calendar-check text-4xl"></i>
                        </div>
                        <div>
                            <h3
                                class="text-xl font-black text-slate-800 mb-1 group-hover:text-violet-600 transition-colors">
                                Jadwal Kelas</h3>
                            <p class="text-sm text-slate-500 font-medium">Cek waktu belajar mingguan</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Recent Materials List -->
            <div
                class="bg-white/60 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-6 sm:p-8 shadow-xl shadow-indigo-500/5 relative overflow-hidden">
                <!-- Decor -->
                <div
                    class="absolute bottom-0 left-0 w-48 h-48 bg-pink-100/40 rounded-full blur-3xl -ml-16 -mb-16 pointer-events-none">
                </div>

                <div class="flex items-center justify-between mb-8 relative z-10">
                    <h3 class="text-xl font-extrabold text-slate-800 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-pink-100 flex items-center justify-center text-pink-500">
                            <i class="ph-fill ph-clock-counter-clockwise text-lg"></i>
                        </span>
                        Materi Terbaru
                    </h3>
                    <a href="{{ route('student.materials.index') }}"
                        class="text-sm font-bold text-violet-600 hover:text-violet-700 hover:bg-violet-50 px-4 py-2 rounded-xl transition-all">
                        Lihat Semua
                    </a>
                </div>

                @if($recentMaterials->count() > 0)
                    <div class="divide-y divide-slate-100/80 relative z-10">
                        @foreach($recentMaterials as $material)
                            @php
                                $colors = [
                                    'bg-orange-50 text-orange-600 border-orange-100',
                                    'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'bg-sky-50 text-sky-600 border-sky-100',
                                    'bg-violet-50 text-violet-600 border-violet-100'
                                ];
                                $colorClass = $colors[$loop->index % 4];
                                $subjectInitials = strtoupper(substr($material->subject->name ?? 'MT', 0, 2));
                            @endphp
                            <a href="{{ route('student.materials.index') }}" class="group block py-3.5 first:pt-0 last:pb-0">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-xl {{ $colorClass }} border flex items-center justify-center font-extrabold text-sm shadow-sm group-hover:scale-105 transition-transform flex-shrink-0">
                                            {{ $subjectInitials }}
                                        </div>
                                        <div class="min-w-0">
                                            <h4
                                                class="font-bold text-slate-800 text-sm sm:text-base mb-0.5 group-hover:text-violet-600 transition-colors line-clamp-1">
                                                {{ $material->title }}
                                            </h4>
                                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                                                <span class="flex items-center gap-1">
                                                    <i class="ph-fill ph-bookmark-simple text-slate-400"></i>
                                                    {{ $material->subject->name ?? 'Materi' }}
                                                </span>
                                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                                <span class="flex items-center gap-1">
                                                    <i class="ph-fill ph-user text-slate-400"></i>
                                                    {{ $material->tutor->name ?? 'Tutor' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-slate-400 group-hover:text-violet-600 group-hover:translate-x-1 transition-all">
                                        <i class="ph-bold ph-caret-right text-lg"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-slate-50/50 rounded-[2rem] border-2 border-dashed border-slate-200">
                        <div
                            class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <span class="text-4xl grayscale opacity-50">📂</span>
                        </div>
                        <p class="text-slate-500 font-medium text-sm">Belum ada materi baru nih.</p>
                        <a href="{{ route('student.materials.index') }}"
                            class="mt-4 inline-block text-sm font-bold text-violet-600 hover:text-violet-700">
                            Cari materi di perpustakaan →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Upcoming Schedule -->
        <div class="space-y-6">
            <div
                class="bg-white/60 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-6 sm:p-8 shadow-xl shadow-emerald-500/5 h-full relative overflow-hidden flex flex-col">
                <!-- Decor -->
                <div
                    class="absolute top-0 right-0 w-48 h-48 bg-emerald-100/40 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
                </div>

                <div class="flex items-center justify-between mb-8 relative z-10">
                    <h3 class="text-xl font-extrabold text-slate-800 flex items-center gap-3">
                        <span
                            class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <i class="ph-fill ph-calendar text-lg"></i>
                        </span>
                        Kelas Selanjutnya
                    </h3>
                </div>

                @if($nextSchedule)
                    <div class="space-y-6 relative z-10 flex-1">
                        <div class="relative">
                            <div
                                class="absolute left-8 top-12 bottom-0 w-0.5 bg-slate-200 border-l-2 border-dashed border-slate-200/60 z-0">
                            </div>

                            <!-- Main Schedule Card -->
                            <div class="relative z-10">
                                <span
                                    class="absolute -top-3 left-4 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase tracking-wider border border-emerald-200 z-20">
                                    Hari Ini
                                </span>
                                <a href="{{ route('student.schedules.index') }}" class="block mt-2">
                                    <div
                                        class="flex items-center gap-5 p-5 rounded-[2rem] bg-gradient-to-br from-indigo-500 to-violet-600 text-white shadow-lg shadow-indigo-500/20 hover:scale-[1.02] transition-transform cursor-pointer group">
                                        <div
                                            class="flex flex-col items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md border border-white/20 text-white">
                                            <span
                                                class="text-[10px] font-bold uppercase tracking-wider opacity-90">Jam</span>
                                            <span
                                                class="text-xl font-black leading-none">{{ substr($nextSchedule->time_start ?? '00:00', 0, 5) }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4
                                                class="font-bold text-lg mb-1 truncate group-hover:underline decoration-2 underline-offset-4 decoration-white/50">
                                                {{ $nextSchedule->subject->name ?? 'Kelas' }}
                                            </h4>
                                            <div class="flex items-center gap-3 text-xs font-medium text-indigo-100">
                                                <span class="flex items-center gap-1.5">
                                                    <i class="ph-fill ph-user"></i>
                                                    {{ $nextSchedule->tutor->name ?? 'Tutor' }}
                                                </span>
                                            </div>
                                            <div
                                                class="mt-2 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white/10 text-[10px] font-bold border border-white/10 text-white">
                                                <i class="ph-fill ph-map-pin"></i>
                                                {{ $nextSchedule->location ?? 'Ruang Kelas' }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Placeholder Next -->
                            <div class="mt-6 flex items-center gap-5 opacity-50 relative z-10 pl-2">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center border border-slate-200 text-slate-400 font-bold text-xs">
                                    Selesai
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-600 text-sm">Istirahat / Pulang</h4>
                                    <p class="text-xs text-slate-400">Sampai jumpa besok! 👋</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12 flex-1 flex flex-col justify-center items-center">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-amber-100 to-orange-100 rounded-full flex items-center justify-center mb-6 shadow-sm animate-bounce-slow">
                            <span class="text-5xl">☕</span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-lg mb-1">Wah, Kosong!</h4>
                        <p class="text-slate-500 font-medium text-sm px-6">Tidak ada jadwal kelas untuk hari ini. Waktunya
                             istirahat atau belajar mandiri!</p>
                    </div>
                @endif

                <a href="{{ route('student.schedules.index') }}"
                    class="w-full mt-6 py-3.5 rounded-2xl bg-slate-100 hover:bg-violet-50 text-slate-600 hover:text-violet-700 font-bold text-sm transition-all duration-300 flex items-center justify-center gap-2 group shadow-sm hover:shadow-md">
                    <span>Lihat Jadwal Lengkap</span>
                    <i class="ph-bold ph-arrow-right group-hover:translate-x-0.5 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>

    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .animate-bounce-slow {
            animation: bounce 3s infinite;
        }
    </style>
</div>