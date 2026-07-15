<div class="space-y-8 p-4 sm:p-8">
    <!-- Notifications -->
    @if (session()->has('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-xl flex items-center gap-3 animate-fade-in shadow-sm">
            <i class="ph ph-check-circle text-emerald-500 text-xl shrink-0"></i>
            <span class="text-sm font-semibold text-emerald-800">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 bg-rose-50 border-l-4 border-rose-500 rounded-xl flex items-center gap-3 animate-fade-in shadow-sm">
            <i class="ph ph-warning-circle text-rose-500 text-xl shrink-0"></i>
            <span class="text-sm font-semibold text-rose-800">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-rose-600 p-8 text-white shadow-xl shadow-rose-600/20">
        <div class="absolute inset-0 bg-gradient-to-br from-rose-600 via-pink-600 to-fuchsia-600"></div>
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-rose-100 mb-4">
                    <i class="ph ph-file-text text-yellow-300 text-lg"></i>
                    <span>Tutor Dashboard</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Laporan Siswa</h1>
                <p class="text-rose-100 font-medium max-w-lg text-sm sm:text-base">
                    Pantau perkembangan dan hasil belajar siswa secara berkala.
                </p>
            </div>

            <button wire:click="openCreateModal"
                class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-rose-600 font-bold shadow-lg shadow-black/5 hover:bg-rose-50 hover:-translate-y-1 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Buat Laporan</span>
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center shadow-sm">
                    <i class="ph-fill ph-files text-3xl text-indigo-600"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800">{{ $reports->total() }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Laporan</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center shadow-sm">
                    <i class="ph-fill ph-users text-3xl text-green-600"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800">{{ $schedules->unique('student_id')->count() }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Siswa</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center shadow-sm">
                    <i class="ph-fill ph-star text-3xl text-orange-600"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800">{{ number_format($reports->avg('score') ?? 0, 1) }}</h3>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Rata-rata Nilai</p>
                </div>
            </div>
        </div>
    </div>

    @if($reports->count() > 0)
        <!-- Reports List -->
        <div class="space-y-4">
            @foreach($reports as $report)
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:scale-[1.01] hover:shadow-[0_15px_45px_rgb(0,0,0,0.04)] transition-all duration-300 flex flex-col sm:flex-row items-center gap-6">
                    <div class="flex-1 w-full">
                        <div class="flex items-start gap-4 mb-3">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center text-white font-bold shrink-0 shadow-lg shadow-rose-500/20">
                                {{ strtoupper(substr($report->student->name ?? 'S', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="text-lg font-bold text-slate-900">
                                        {{ $report->student->name ?? 'Siswa' }}
                                    </h3>
                                    @if($report->subject)
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] uppercase font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                            {{ $report->subject->name }}
                                        </span>
                                    @endif
                                </div>
                                <h4 class="font-extrabold text-slate-700 mb-1 line-clamp-1">Periode: {{ $report->period }}</h4>
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                                    <i class="ph-bold ph-calendar-blank"></i>
                                    <span>Laporan Tanggal: {{ \Carbon\Carbon::parse($report->report_date)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        @if($report->notes)
                            <div class="pl-16">
                                <div class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Catatan Guru:</p>
                                    <p class="font-semibold text-slate-700">{{ $report->notes }}</p>
                                    @if($report->attendance_count !== null)
                                        <p class="text-xs text-slate-500 mt-2 font-bold"><i class="ph-bold ph-calendar-check text-green-500"></i> Hadir: {{ $report->attendance_count }} Pertemuan</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-row sm:flex-col items-center sm:items-end w-full sm:w-auto gap-4 sm:gap-6 border-t sm:border-t-0 pt-4 sm:pt-0 border-slate-100 shrink-0">
                        <div class="text-left sm:text-right flex-1 sm:flex-none">
                            <p class="text-4xl font-extrabold {{ $report->score >= 80 ? 'text-green-500' : ($report->score >= 60 ? 'text-amber-500' : 'text-rose-500') }}">
                                {{ $report->score ?? 'N/A' }}
                            </p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Nilai Akhir</p>
                        </div>
                        <div class="flex gap-2">
                            <button wire:click="openEditModal({{ $report->id }})"
                                class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all flex items-center justify-center">
                                <i class="ph-bold ph-pencil-simple text-lg"></i>
                            </button>
                            <button wire:click="confirmDelete({{ $report->id }})"
                                class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all flex items-center justify-center">
                                <i class="ph-bold ph-trash text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($reports->hasPages())
            <div class="mt-6">
                {{ $reports->links() }}
            </div>
        @endif
    @else
        <div class="py-12 bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col items-center justify-center p-8 text-center">
            <div class="w-16 h-16 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500 text-3xl mb-4">
                <i class="ph ph-file-text"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Laporan Kosong</h3>
            <p class="text-sm text-slate-500 mt-1 max-w-sm">Belum ada laporan hasil belajar yang dibuat. Klik tombol 'Buat Laporan' untuk memulai.</p>
        </div>
    @endif

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm" wire:click="resetForm"></div>

            <div class="relative w-full max-w-lg bg-white rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden z-10 animate-scale-in">
                <div class="p-6 sm:p-8 flex items-center justify-between border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        {{ $editingId ? 'Edit Laporan Perkembangan' : 'Buat Laporan Baru' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 text-xl font-bold p-1">✕</button>
                </div>

                <form wire:submit.prevent="save" class="p-6 sm:p-8 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Student Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Pilih Siswa</label>
                            <select wire:model="student_id" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition-all font-semibold text-slate-700">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($students as $stud)
                                    <option value="{{ $stud->id }}">{{ $stud->name }}</option>
                                @endforeach
                            </select>
                            @error('student_id') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Subject Selection -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Mata Pelajaran</label>
                            <select wire:model="subject_id" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition-all font-semibold text-slate-700">
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($subjects as $subj)
                                    <option value="{{ $subj->id }}">{{ $subj->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Score -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Nilai Akhir (0 - 100)</label>
                            <input type="number" wire:model="score" placeholder="Contoh: 85" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition-all font-semibold text-slate-700">
                            @error('score') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Attendance Count -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Jumlah Kehadiran</label>
                            <input type="number" wire:model="attendance_count" placeholder="Contoh: 12" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition-all font-semibold text-slate-700">
                            @error('attendance_count') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Period -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Periode Belajar</label>
                            <input type="text" wire:model="period" placeholder="Contoh: Juli 2026 atau Ganjil" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition-all font-semibold text-slate-700">
                            @error('period') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Report Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Tanggal Laporan</label>
                            <input type="date" wire:model="report_date" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition-all font-semibold text-slate-700">
                            @error('report_date') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Catatan Guru (Perkembangan Belajar)</label>
                        <textarea wire:model="notes" rows="4" placeholder="Tuliskan catatan detail kemajuan belajar siswa selama periode ini..." class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-rose-500 focus:ring-2 focus:ring-rose-500/20 outline-none transition-all font-semibold text-slate-700 placeholder:text-slate-400"></textarea>
                        @error('notes') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="resetForm" class="flex-1 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-bold transition-all text-center">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold transition-all text-center shadow-lg shadow-rose-500/20">
                            Simpan Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm" wire:click="$set('showDeleteModal', false)"></div>
            
            <div class="relative w-full max-w-sm bg-white rounded-3xl p-6 text-center shadow-2xl border border-slate-100 z-10 animate-scale-in">
                <div class="w-12 h-12 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="ph ph-trash"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Hapus Laporan?</h3>
                <p class="text-sm text-slate-500 mt-2 mb-6">Apakah Anda yakin ingin menghapus laporan perkembangan siswa ini?</p>
                
                <div class="flex gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="flex-1 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-bold transition-all">
                        Batal
                    </button>
                    <button wire:click="delete" class="flex-1 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold transition-all shadow-lg shadow-rose-500/20">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
