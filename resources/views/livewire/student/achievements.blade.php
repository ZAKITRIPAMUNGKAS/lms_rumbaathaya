<div class="space-y-6 p-4 sm:p-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="ph ph-trophy text-indigo-600"></i>
                Pencapaian & Prestasi
            </h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Jejak prestasi dan kemajuan belajar Anda</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Avg Score -->
        <div
            class="bg-white/80 backdrop-blur-xl border border-white/60 p-6 rounded-[2rem] shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-110 transition-transform duration-300">
                    <i class="ph ph-chart-line-up text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">
                        {{ number_format($stats['average'], 1) }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Rata-rata Nilai</p>
                </div>
            </div>
        </div>

        <!-- Highest Score -->
        <div
            class="bg-white/80 backdrop-blur-xl border border-white/60 p-6 rounded-[2rem] shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                    <i class="ph ph-crown text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $stats['highest'] }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Nilai Tertinggi</p>
                </div>
            </div>
        </div>

        <!-- Total Reports -->
        <div
            class="bg-white/80 backdrop-blur-xl border border-white/60 p-6 rounded-[2rem] shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                    <i class="ph ph-check-circle text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $stats['reports'] }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Laporan Selesai</p>
                </div>
            </div>
        </div>

        <!-- Materials -->
        <div
            class="bg-white/80 backdrop-blur-xl border border-white/60 p-6 rounded-[2rem] shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                    <i class="ph ph-books text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $stats['materials'] }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Materi Tersedia</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Badges Section -->
    <div>
        <div class="flex items-center gap-2 mb-6">
            <i class="ph ph-medal text-2xl text-amber-500"></i>
            <h2 class="text-xl font-bold text-slate-800">Lencana Prestasi</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($badges as $badge)
                <div
                    class="relative bg-white/60 backdrop-blur-md border {{ $badge['earned'] ? 'border-amber-200' : 'border-slate-200' }} rounded-[2rem] p-6 text-center transition-all duration-300 hover:scale-105 {{ $badge['earned'] ? 'opacity-100 shadow-md' : 'opacity-60 grayscale' }}">
                    @if($badge['earned'])
                        <div class="absolute top-3 right-3 text-emerald-500">
                            <i class="ph ph-check-circle-fill text-xl"></i>
                        </div>
                    @else
                        <div class="absolute top-3 right-3 text-slate-300">
                            <i class="ph ph-lock-key text-xl"></i>
                        </div>
                    @endif

                    <div
                        class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-gradient-to-br {{ $badge['earned'] ? 'from-amber-100 to-orange-100 text-amber-600' : 'from-slate-100 to-slate-200 text-slate-400' }}">
                        <i class="ph ph-{{ $badge['icon'] }} text-3xl"></i>
                    </div>

                    <h3 class="font-bold text-slate-800 mb-1">{{ $badge['name'] }}</h3>
                    <p class="text-[10px] text-slate-500 font-medium">{{ $badge['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Reports -->
    <div>
        <div class="flex items-center gap-2 mb-6">
            <i class="ph ph-notebook text-2xl text-indigo-500"></i>
            <h2 class="text-xl font-bold text-slate-800">Laporan Terbaru</h2>
        </div>

        @if($reports->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($reports->take(6) as $report)
                    <div
                        class="bg-white/80 backdrop-blur-xl border border-white/60 p-6 rounded-[2rem] shadow-sm hover:shadow-xl transition-all group flex flex-col h-full">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform">
                                <i class="ph ph-file-text text-2xl"></i>
                            </div>
                            <div
                                class="px-3 py-1 rounded-xl bg-slate-100 text-slate-700 font-bold text-sm border border-slate-200">
                                {{ $report->score ?? 'N/A' }}
                            </div>
                        </div>

                        <h3
                            class="text-lg font-bold text-slate-800 mb-2 line-clamp-1 group-hover:text-indigo-600 transition-colors">
                            {{ $report->title ?? 'Laporan Tanpa Judul' }}
                        </h3>

                        @if($report->description)
                            <p class="text-sm text-slate-500 line-clamp-3 mb-4 flex-1 leading-relaxed">
                                {{ $report->description }}
                            </p>
                        @else
                            <p class="text-sm text-slate-400 italic mb-4 flex-1">Tidak ada deskripsi.</p>
                        @endif

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
                            <div class="flex items-center gap-1 text-xs font-semibold text-slate-400">
                                <i class="ph ph-calendar"></i>
                                {{ $report->created_at->format('d M Y') }}
                            </div>
                            <button
                                class="text-sm font-bold text-indigo-600 flex items-center gap-1 hover:gap-2 transition-all">
                                Detail <i class="ph ph-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div
                class="flex flex-col items-center justify-center py-12 text-center bg-white/40 rounded-[2rem] border border-dashed border-slate-300">
                <i class="ph ph-notebook text-4xl text-slate-300 mb-3"></i>
                <p class="text-slate-500 font-medium">Belum ada laporan belajar.</p>
            </div>
        @endif
    </div>
</div>