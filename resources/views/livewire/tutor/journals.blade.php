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
    <div class="relative overflow-hidden rounded-[2.5rem] bg-indigo-600 p-8 text-white shadow-xl shadow-indigo-600/20">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-blue-600 to-sky-600"></div>
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-indigo-100 mb-4">
                    <i class="ph ph-notebook text-yellow-300 text-lg"></i>
                    <span>Tutor Dashboard</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Jurnal Mengajar</h1>
                <p class="text-indigo-100 font-medium max-w-lg text-sm sm:text-base">
                    Catat aktivitas dan perkembangan siswa setiap pertemuan.
                </p>
            </div>

            <button wire:click="openCreateModal"
                class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-indigo-600 font-bold shadow-lg shadow-black/5 hover:bg-indigo-50 hover:-translate-y-1 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Jurnal Baru</span>
            </button>
        </div>
    </div>

    <!-- Journals List -->
    @if($journals->count() > 0)
        <div class="space-y-4">
            @foreach($journals as $journal)
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:scale-[1.01] hover:shadow-[0_15px_45px_rgb(0,0,0,0.05)] transition-all duration-300 flex flex-col sm:flex-row items-start justify-between gap-4">
                    <div class="flex-1 w-full">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white shrink-0 shadow-lg shadow-indigo-500/20">
                                <i class="ph-bold ph-student text-2xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <h3 class="text-xl font-bold text-slate-900">
                                        {{ $journal->schedule && $journal->schedule->student ? $journal->schedule->student->name : 'Siswa' }}
                                    </h3>
                                    @if($journal->schedule && $journal->schedule->subject)
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-600 border border-indigo-100">
                                            {{ $journal->schedule->subject->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <i class="ph-bold ph-calendar-blank text-indigo-400"></i>
                                        <span>{{ \Carbon\Carbon::parse($journal->date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <i class="ph-bold ph-clock text-indigo-400"></i>
                                        <span>{{ $journal->time }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($journal->material)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 mb-4">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Materi</p>
                                <p class="text-slate-700 leading-relaxed font-semibold">{{ $journal->material }}</p>
                            </div>
                        @endif

                        @if($journal->documentation_path)
                            <a href="{{ asset('storage/' . $journal->documentation_path) }}" target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 text-blue-600 text-sm font-bold hover:bg-blue-100 transition-colors">
                                <i class="ph-bold ph-image"></i>
                                Lihat Dokumentasi
                            </a>
                        @endif
                    </div>

                    <div class="flex sm:flex-col gap-2 w-full sm:w-auto mt-4 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-100 shrink-0">
                        <button wire:click="openEditModal({{ $journal->id }})"
                            class="flex-1 sm:flex-none px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all text-center">
                            Edit
                        </button>
                        <button wire:click="confirmDelete({{ $journal->id }})"
                            class="flex-1 sm:flex-none px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-sm hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all text-center">
                            Hapus
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($journals->hasPages())
            <div class="mt-6">
                {{ $journals->links() }}
            </div>
        @endif
    @else
        <div class="py-12 bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col items-center justify-center p-8 text-center">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500 text-3xl mb-4">
                <i class="ph ph-notebook"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Jurnal Kosong</h3>
            <p class="text-sm text-slate-500 mt-1 max-w-sm">Belum ada jurnal mengajar yang tercatat. Klik tombol 'Jurnal Baru' untuk memulai.</p>
        </div>
    @endif

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm" wire:click="resetForm"></div>

            <!-- Content -->
            <div class="relative w-full max-w-lg bg-white rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden z-10 animate-scale-in">
                <div class="p-6 sm:p-8 flex items-center justify-between border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        {{ $editingId ? 'Edit Jurnal Mengajar' : 'Catat Jurnal Mengajar Baru' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 text-xl font-bold p-1">✕</button>
                </div>

                <form wire:submit.prevent="save" class="p-6 sm:p-8 space-y-5">
                    <!-- Schedule -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Pilih Kelas / Jadwal</label>
                        <select wire:model="schedule_id" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all font-semibold text-slate-700">
                            <option value="">-- Hubungkan dengan Jadwal (Opsional) --</option>
                            @foreach($schedules as $sched)
                                <option value="{{ $sched->id }}">
                                    {{ $sched->student ? $sched->student->name : 'Siswa' }} | {{ $sched->subject ? $sched->subject->name : 'Mapel' }} ({{ $sched->day_of_week }}, {{ substr($sched->time_start, 0, 5) }} - {{ substr($sched->time_end, 0, 5) }})
                                </option>
                            @endforeach
                        </select>
                        @error('schedule_id') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Date -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Tanggal</label>
                            <input type="date" wire:model="date" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all font-semibold text-slate-700">
                            @error('date') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Time -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Waktu</label>
                            <input type="text" wire:model="time" placeholder="Contoh: 15:30 - 17:00" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all font-semibold text-slate-700">
                            @error('time') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Material -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Catatan Aktivitas / Materi Belajar</label>
                        <textarea wire:model="material" rows="4" placeholder="Tuliskan materi yang dipelajari dan rangkuman aktivitas mengajar..." class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all font-semibold text-slate-700 placeholder:text-slate-400"></textarea>
                        @error('material') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Documentation -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Foto Dokumentasi (Opsional)</label>
                        
                        @if($documentation_path && !$documentation)
                            <div class="mb-2 p-2 border border-slate-100 rounded-xl bg-slate-50 flex items-center gap-3">
                                <i class="ph ph-file-image text-blue-500 text-xl"></i>
                                <span class="text-xs text-slate-500 truncate">Foto saat ini terunggah</span>
                            </div>
                        @endif

                        <input type="file" wire:model="documentation" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @error('documentation') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="resetForm" class="flex-1 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-bold transition-all text-center">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-all text-center shadow-lg shadow-indigo-500/20">
                            Simpan Jurnal
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
                <h3 class="text-lg font-bold text-slate-900">Hapus Jurnal?</h3>
                <p class="text-sm text-slate-500 mt-2 mb-6">Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin ingin menghapus catatan jurnal mengajar ini?</p>
                
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
