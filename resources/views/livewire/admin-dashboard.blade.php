@php
    // Quick Actions Data with Updated Colors/Icons
    $quickActions = [
        ['title' => 'Kelola Siswa', 'description' => 'Database siswa', 'icon' => 'users', 'href' => route('admin.students.index'), 'gradient' => 'from-violet-500 to-fuchsia-500'],
        ['title' => 'Kelola Tutor', 'description' => 'Manajemen pengajar', 'icon' => 'graduation-cap', 'href' => route('admin.tutors.index'), 'gradient' => 'from-amber-400 to-orange-500'],
        ['title' => 'Jadwal', 'description' => 'Atur jadwal', 'icon' => 'calendar-check', 'href' => route('admin.schedules.index'), 'gradient' => 'from-emerald-400 to-teal-500'],
        ['title' => 'Absensi', 'description' => 'Rekap kehadiran', 'icon' => 'clipboard-text', 'href' => route('admin.attendances.index'), 'gradient' => 'from-rose-400 to-pink-500'],
        ['title' => 'Jurnal', 'description' => 'Log harian kelas', 'icon' => 'article', 'href' => route('admin.journals.index'), 'gradient' => 'from-sky-400 to-blue-500'],
        ['title' => 'Materi', 'description' => 'Bank soal & modul', 'icon' => 'book-open', 'href' => route('admin.materials.index'), 'gradient' => 'from-indigo-400 to-purple-500'],
        ['title' => 'Jenjang', 'description' => 'Level kelas', 'icon' => 'stack', 'href' => route('admin.class-levels.index'), 'gradient' => 'from-cyan-400 to-sky-500'],
        ['title' => 'Mapel', 'description' => 'Kurikulum', 'icon' => 'bookmark', 'href' => route('admin.subjects.index'), 'gradient' => 'from-lime-400 to-green-500'],
        ['title' => 'Artikel', 'description' => 'Sahabat RA', 'icon' => 'newspaper', 'href' => route('admin.posts.index'), 'gradient' => 'from-fuchsia-400 to-pink-500'],
    ];

    $systemHealth = 100;
@endphp

<div class="space-y-8 p-4 sm:p-8">
    <!-- Hero Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-violet-500 to-fuchsia-600 p-8 text-white shadow-2xl shadow-violet-500/20 group">
            <!-- Background Decor -->
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16 group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="absolute top-0 left-0 w-40 h-40 bg-amber-400/30 rounded-full blur-2xl -ml-10 -mt-10 group-hover:scale-110 transition-transform duration-500"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 h-full">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-white mb-6 shadow-sm hover:scale-105 transition-transform origin-left cursor-default">
                        <i class="ph-bold ph-hand-waving text-base text-amber-200"></i>
                        <span>Admin Dashboard</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm flex items-center gap-2">
                        <span>Halo, {{ explode(' ', auth()->user()->name)[0] ?? 'Admin' }}!</span> 
                        <i class="ph-fill ph-rocket text-2xl text-amber-300 animate-bounce"></i>
                    </h1>
                    <p class="text-violet-100 font-medium max-w-md text-sm sm:text-base leading-relaxed">
                        Pantau semua aktivitas sekolah dan kelola data operasional dengan mudah dan menyenangkan.
                    </p>
                </div>
                <!-- Floating Illustration -->
                <div class="hidden md:flex w-32 h-32 bg-white/10 backdrop-blur-md rounded-full border-2 border-white/30 items-center justify-center shadow-[0_0_40px_rgba(255,255,255,0.3)] hover:rotate-6 transition-transform duration-300">
                    <i class="ph-fill ph-chart-bar text-6xl text-white drop-shadow-md"></i>
                </div>
            </div>
        </div>

        <!-- System Stats Small -->
        <div class="bg-white/60 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-6 shadow-xl shadow-indigo-500/5 flex flex-col justify-center gap-6 relative overflow-hidden group hover:bg-white/70 transition-colors">
             <!-- Decor -->
             <div class="absolute top-0 right-0 w-32 h-32 bg-sky-200/40 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <div class="flex items-center gap-5 relative z-10">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-300 to-orange-400 flex items-center justify-center shadow-lg shadow-orange-500/20 text-white text-2xl group-hover:scale-110 transition-transform duration-300">
                   <i class="ph-fill ph-lightning"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">System Health</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $systemHealth }}%</h3>
                </div>
            </div>
            <div class="h-px w-full bg-slate-200/60 relative z-10"></div>
            <div class="space-y-4 relative z-10">
                <div class="flex justify-between text-xs font-bold text-slate-600">
                    <span>Uptime</span>
                    <span class="text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-100">99.9%</span>
                </div>
                <div class="flex justify-between text-xs font-bold text-slate-600">
                    <span>Performance</span>
                    <span class="text-violet-500 bg-violet-50 px-2 py-0.5 rounded-lg border border-violet-100">Excellent</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <!-- Total Siswa -->
        <div class="group relative overflow-hidden p-6 rounded-[2.5rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-2xl hover:bg-white/80 transition-all duration-300 hover:-translate-y-1">
             <div class="absolute top-0 right-0 w-24 h-24 bg-blue-100/50 rounded-full blur-2xl -mr-8 -mt-8 group-hover:bg-blue-200/50 transition-colors"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-400 to-indigo-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-300">
                    <i class="ph-fill ph-users text-xl"></i>
                </div>
                @if(isset($stats['new_students_this_month']) && $stats['new_students_this_month'] > 0)
                    <span class="text-[10px] font-bold text-white bg-emerald-500 px-2 py-1 rounded-full shadow-md shadow-emerald-500/20">
                        +{{ $stats['new_students_this_month'] }}
                    </span>
                @endif
            </div>
            <div class="space-y-1 relative z-10">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $stats['total_students'] ?? 0 }}</h3>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Siswa</p>
            </div>
        </div>

        <!-- Total Tutor -->
        <div class="group relative overflow-hidden p-6 rounded-[2.5rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-2xl hover:bg-white/80 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-100/50 rounded-full blur-2xl -mr-8 -mt-8 group-hover:bg-amber-200/50 transition-colors"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center shadow-lg shadow-orange-500/20 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-300">
                    <i class="ph-fill ph-graduation-cap text-xl"></i>
                </div>
            </div>
            <div class="space-y-1 relative z-10">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $stats['total_tutors'] ?? 0 }}</h3>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Tutor</p>
            </div>
        </div>

        <!-- Total Materi -->
        <div class="group relative overflow-hidden p-6 rounded-[2.5rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-2xl hover:bg-white/80 transition-all duration-300 hover:-translate-y-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-pink-100/50 rounded-full blur-2xl -mr-8 -mt-8 group-hover:bg-pink-200/50 transition-colors"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-400 to-rose-500 text-white flex items-center justify-center shadow-lg shadow-pink-500/20 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                    <i class="ph-fill ph-book-open text-xl"></i>
                </div>
            </div>
            <div class="space-y-1 relative z-10">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $stats['total_materials'] ?? 0 }}</h3>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Materi Aktif</p>
            </div>
        </div>

        <!-- Aktivitas -->
        <div class="group relative overflow-hidden p-6 rounded-[2.5rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-2xl hover:bg-white/80 transition-all duration-300 hover:-translate-y-1">
             <div class="absolute top-0 right-0 w-24 h-24 bg-violet-100/50 rounded-full blur-2xl -mr-8 -mt-8 group-hover:bg-violet-200/50 transition-colors"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-400 to-purple-500 text-white flex items-center justify-center shadow-lg shadow-purple-500/20 group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                     <i class="ph-fill ph-clock-counter-clockwise text-xl"></i>
                </div>
            </div>
            <div class="space-y-1 relative z-10">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ count($activities) }}</h3>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Log Aktivitas</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div>
        <h3 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
            <span class="w-2 h-6 bg-gradient-to-b from-violet-500 to-fuchsia-500 rounded-full"></span>
            Akses Cepat
        </h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($quickActions as $action)
                <a href="{{ $action['href'] }}" class="group relative p-6 rounded-[2rem] bg-white/70 backdrop-blur-xl border border-white/60 shadow-md hover:shadow-xl transition-all flex flex-col items-center text-center gap-4 hover:-translate-y-1 hover:bg-white/90">
                    <div class="w-16 h-16 rounded-3xl bg-gradient-to-br {{ $action['gradient'] }} flex items-center justify-center text-white shadow-lg transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                        <i class="ph-fill ph-{{ $action['icon'] }} text-3xl"></i>
                    </div>
                    <div class="text-center">
                        <h3 class="text-sm font-bold text-slate-700 group-hover:text-fuchsia-600 transition-colors leading-tight mb-1">
                            {{ $action['title'] }}
                        </h3>
                        <p class="text-[10px] sm:text-xs text-slate-500 leading-tight">
                            {{ $action['description'] }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Analytics & Timeline -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2">
                    <span class="w-2 h-6 bg-gradient-to-b from-amber-400 to-orange-500 rounded-full"></span>
                    Statistik Mingguan
                </h3>
                <div class="relative">
                    <select class="appearance-none bg-white/70 backdrop-blur-md border border-white/60 text-xs font-bold text-slate-600 rounded-xl px-4 py-2 pr-8 outline-none cursor-pointer hover:bg-white hover:border-violet-200 focus:ring-2 focus:ring-violet-400 transition-all shadow-sm">
                        <option>7 Hari Terakhir</option>
                        <option>Bulan Ini</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <i class="ph-bold ph-caret-down"></i>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                 <div class="p-6 rounded-[2rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-xl transition-all">
                    @include('livewire.partials.area-chart', [
                        'title' => 'Kehadiran',
                        'data' => $charts['attendances'] ?? [],
                        'colorStart' => '#F97316', // Orange-500
                        'colorEnd' => '#FFF7ED'    // Orange-50
                    ])
                </div>
                
                <div class="p-6 rounded-[2rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-xl transition-all">
                    @include('livewire.partials.area-chart', [
                        'title' => 'Pendaftaran',
                        'data' => $charts['registrations'] ?? [],
                        'colorStart' => '#3B82F6', // Blue-500
                        'colorEnd' => '#EFF6FF'    // Blue-50
                    ])
                </div>
                
                <div class="p-6 rounded-[2rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-xl transition-all">
                    @include('livewire.partials.area-chart', [
                        'title' => 'Materi Baru',
                        'data' => $charts['materials'] ?? [],
                        'colorStart' => '#10B981', // Emerald-500
                        'colorEnd' => '#ECFDF5'    // Emerald-50
                    ])
                </div>
                
                <div class="p-6 rounded-[2rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-lg hover:shadow-xl transition-all">
                    @include('livewire.partials.area-chart', [
                        'title' => 'Jadwal Kelas',
                        'data' => $charts['schedules'] ?? [],
                        'colorStart' => '#8B5CF6', // Violet-500
                        'colorEnd' => '#F5F3FF'    // Violet-50
                    ])
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="text-lg font-extrabold text-slate-800 flex items-center gap-2">
                <span class="w-2 h-6 bg-gradient-to-b from-sky-400 to-blue-500 rounded-full"></span>
                Timeline Aktivitas
            </h3>
            <div class="h-[450px] overflow-hidden rounded-[2.5rem] bg-white/60 backdrop-blur-xl border border-white/60 shadow-xl shadow-blue-500/5 relative">
                <!-- Inner Decor -->
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-slate-100/50 rounded-full blur-3xl -mr-8 -mb-8 pointer-events-none"></div>

                <div class="h-full overflow-y-auto p-6 custom-scrollbar relative z-10">
                    @if(count($activities) === 0)
                        <div class="flex flex-col items-center justify-center h-full text-slate-400">
                            <i class="ph ph-clock-counter-clockwise text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm font-bold">Belum ada aktivitas</p>
                        </div>
                    @else
                        <div class="space-y-6 relative">
                            <div class="absolute left-5 top-2 bottom-2 w-0.5 bg-slate-200/80 border-l-2 border-dotted border-slate-300 z-0"></div>
                            @foreach($activities as $idx => $act)
                                @php
                                    $isHighlight = $idx < 3;
                                    $iconType = $act['type'] ?? 'default';
                                    $iconName = 'activity';
                                    $colorClass = 'bg-slate-100 text-slate-400 border-slate-200';
                                    
                                    if(str_contains($iconType, 'student')) { $iconName = 'user-plus'; $colorClass = 'bg-blue-100 text-blue-600 border-blue-200'; }
                                    elseif(str_contains($iconType, 'material')) { $iconName = 'file-plus'; $colorClass = 'bg-fuchsia-100 text-fuchsia-600 border-fuchsia-200'; }
                                    elseif(str_contains($iconType, 'schedule')) { $iconName = 'calendar-plus'; $colorClass = 'bg-emerald-100 text-emerald-600 border-emerald-200'; }
                                    elseif(str_contains($iconType, 'post')) { $iconName = 'newspaper'; $colorClass = 'bg-amber-100 text-amber-600 border-amber-200'; }
                                    elseif(str_contains($iconType, 'attendance')) { $iconName = 'check-circle'; $colorClass = 'bg-violet-100 text-violet-600 border-violet-200'; }
                                @endphp
                                <div class="relative z-10 flex gap-4 section-fade-in" style="animation-delay: {{ $idx * 100 }}ms">
                                    <div class="w-10 h-10 rounded-2xl border-2 {{ $colorClass }} flex items-center justify-center shrink-0 shadow-sm bg-white">
                                        <i class="ph-fill ph-{{ $iconName }} text-lg"></i>
                                    </div>
                                    <div class="flex-1 py-1 px-4 rounded-2xl transition-all {{ $isHighlight ? 'bg-white/60 shadow-sm border border-white/50' : 'opacity-80 hover:opacity-100' }}">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="text-sm font-bold text-slate-700 leading-tight line-clamp-1">{{ $act['title'] ?? 'System' }}</h4>
                                            <span class="text-[10px] font-bold text-slate-400 whitespace-nowrap ml-2 bg-slate-100 px-2 py-0.5 rounded-full">{{ $act['time'] ?? 'Now' }}</span>
                                        </div>
                                        <p class="text-xs text-slate-500 leading-snug line-clamp-2 font-medium">{{ $act['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(203, 213, 225, 0.5);
            border-radius: 20px;
        }
        .section-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(10px);
        }
        @keyframes fadeIn {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</div>
