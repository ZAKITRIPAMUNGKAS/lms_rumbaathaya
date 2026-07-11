<div class="relative min-h-screen space-y-8 p-4 sm:p-8 overflow-hidden font-sans">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-rose-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-pink-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-purple-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-rose-600 to-pink-600 p-8 sm:p-12 text-white shadow-2xl shadow-rose-500/20 group">
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16 group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10 group-hover:scale-110 transition-transform duration-500"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-rose-100 mb-6 shadow-sm cursor-default">
                    <i class="ph-fill ph-notebook text-lg"></i>
                    <span>Jurnal Guru</span>
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Jurnal Pembelajaran
                </h1>
                <p class="text-rose-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                   Dokumentasikan kegiatan belajar, materi yang disampaikan, dan evaluasi harian dengan mudah.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-rose-500/10 rounded-[2.5rem] p-6 md:p-8 relative overflow-hidden">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div>
                 <h2 class="text-2xl font-black text-slate-800">Daftar Jurnal</h2>
                <p class="text-slate-500 font-medium">Rekap kegiatan pembelajaran guru.</p>
            </div>
            <button wire:click="openCreateModal" class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-rose-500 to-pink-600 text-white font-bold shadow-lg shadow-rose-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-rose-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tulis Jurnal</span>
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <i class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-rose-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari materi atau topik..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-rose-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
            
            <div class="relative md:w-64">
                <select wire:model.live="tutorFilter" class="w-full px-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-rose-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                    <option value="">Semua Tutor</option>
                    @foreach($tutors as $tutor)
                        <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                    @endforeach
                </select>
                <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>
        </div>

        <!-- Journals Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($journals as $journal)
                <div class="group relative bg-white/50 border border-white/60 hover:bg-white/80 transition-all duration-300 rounded-[2rem] p-6 shadow-sm hover:shadow-xl hover:shadow-rose-500/10 hover:-translate-y-1 flex flex-col h-full">
                    <!-- Header: Date & Tutor -->
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-pink-600 flex flex-col items-center justify-center text-white shadow-md flex-shrink-0">
                            <span class="text-lg font-black">{{ $journal->date->format('d') }}</span>
                            <span class="text-[9px] font-bold uppercase tracking-widest">{{ $journal->date->format('M') }}</span>
                        </div>
                        <div>
                             <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider border border-indigo-100 mb-1">
                                <i class="ph-bold ph-chalkboard-teacher"></i> {{ $journal->tutor->name ?? '-' }}
                            </span>
                            <div class="text-xs text-slate-400 font-semibold flex items-center gap-1">
                                <i class="ph-fill ph-clock"></i> {{ $journal->time }}
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 mb-4">
                        <h3 class="font-bold text-slate-800 text-lg mb-2 line-clamp-2 group-hover:text-rose-600 transition-colors">
                            {{ $journal->material }}
                        </h3>
                        @if($journal->note)
                            <p class="text-sm font-medium text-slate-500 line-clamp-3 leading-relaxed italic">
                                "{{ $journal->note }}"
                            </p>
                        @endif
                    </div>

                    <!-- Documentation Thumbnail (If exists) -->
                    @if($journal->documentation_path)
                        <div class="mb-4 relative h-32 rounded-2xl overflow-hidden group/img shrink-0">
                             @php 
                                $ext = pathinfo($journal->documentation_path, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']);
                            @endphp
                            
                            @if($isImage)
                                <img src="{{ Storage::url($journal->documentation_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-110">
                                <div class="absolute inset-0 bg-black/20 group-hover/img:bg-black/0 transition-colors"></div>
                            @else
                                 <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <i class="ph-duotone ph-file-text text-4xl"></i>
                                </div>
                            @endif
                            
                            <a href="{{ Storage::url($journal->documentation_path) }}" target="_blank" 
                                class="absolute top-2 right-2 w-8 h-8 rounded-full bg-white/90 text-rose-600 flex items-center justify-center shadow-sm hover:scale-110 transition-transform">
                                <i class="ph-bold ph-arrow-square-out"></i>
                            </a>
                        </div>
                    @endif

                    <!-- Footer Actions -->
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                         <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            ID: #{{ $journal->id }}
                        </span>
                        <div class="flex items-center gap-1">
                            <button wire:click="openEditModal({{ $journal->id }})" 
                                class="w-8 h-8 rounded-lg text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all flex items-center justify-center" title="Edit">
                                <i class="ph-bold ph-pencil-simple"></i>
                            </button>
                            <button wire:click="openDeleteModal({{ $journal->id }})" 
                                class="w-8 h-8 rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all flex items-center justify-center" title="Hapus">
                                <i class="ph-bold ph-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                 <div class="col-span-full py-12 text-center text-slate-500">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ph-duotone ph-pencil-line text-3xl text-slate-400"></i>
                    </div>
                    <p class="font-bold text-slate-600">Belum ada jurnal</p>
                    <p class="text-sm text-slate-400">Mulai tulis jurnal kegiatan belajar mengajar.</p>
                </div>
            @endforelse
        </div>

        @if($journals->hasPages())
            <div class="mt-6">
                {{ $journals->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div class="relative bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl rounded-[2.5rem] w-full max-w-3xl max-h-[90vh] overflow-hidden flex flex-col animate-modal-pop">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-white/50 backdrop-blur-md z-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center text-white shadow-lg shadow-rose-500/20">
                        <i class="ph-fill ph-pencil-line text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ $editingId ? 'Edit Jurnal' : 'Tulis Jurnal' }}</h3>
                    </div>
                </div>
                <button wire:click="closeModal" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-all flex items-center justify-center">
                    <i class="ph-bold ph-x text-lg"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-8">
                <form wire:submit.prevent="save" class="space-y-6">
                    <!-- Info Section -->
                    <div class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Tutor <span class="text-rose-500">*</span></label>
                                <select wire:model="tutor_id" required
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                                    <option value="">Pilih Tutor</option>
                                    @foreach($tutors as $tutor)
                                        <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                    @endforeach
                                </select>
                                @error('tutor_id') <span class="text-xs font-bold text-rose-500 mt-1 flex items-center gap-1"><i class="ph-bold ph-warning"></i> {{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Jadwal (Opsional)</label>
                                <select wire:model="schedule_id"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                                    <option value="">Pilih Jadwal Terkait</option>
                                    @foreach($schedules as $schedule)
                                        <option value="{{ $schedule->id }}">
                                            {{ $schedule->student->name ?? '-' }} - {{ $schedule->subject->name ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Tanggal <span class="text-rose-500">*</span></label>
                                <input type="date" wire:model="date" required
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 rounded-xl transition-all font-semibold text-slate-700">
                                @error('date') <span class="text-xs font-bold text-rose-500 mt-1 flex items-center gap-1"><i class="ph-bold ph-warning"></i> {{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Waktu <span class="text-rose-500">*</span></label>
                                <input type="time" wire:model="time" required
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 rounded-xl transition-all font-semibold text-slate-700">
                                @error('time') <span class="text-xs font-bold text-rose-500 mt-1 flex items-center gap-1"><i class="ph-bold ph-warning"></i> {{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Materi / Kegiatan <span class="text-rose-500">*</span></label>
                            <textarea wire:model="material" required rows="3" placeholder="Apa yang diajarkan hari ini?"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-rose-400 focus:ring-4 focus:ring-rose-100 rounded-xl transition-all font-semibold placeholder-slate-400"></textarea>
                            @error('material') <span class="text-xs font-bold text-rose-500 mt-1 flex items-center gap-1"><i class="ph-bold ph-warning"></i> {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Documentation -->
                    <div class="bg-white/50 rounded-[2rem] p-6 border border-white/60">
                            <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-4">Dokumentasi</h4>
                            <div class="flex items-center gap-4">
                            @if($documentation)
                                    <div class="w-16 h-16 rounded-xl bg-slate-200 flex items-center justify-center text-slate-400 border border-slate-300">
                                    <i class="ph-bold ph-file-check text-2xl text-emerald-500"></i>
                                </div>
                            @elseif($documentation_path)
                                <div class="w-16 h-16 rounded-xl overflow-hidden border-2 border-slate-200 relative">
                                    @php 
                                        $ext = pathinfo($documentation_path, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']);
                                    @endphp
                                    @if($isImage)
                                        <img src="{{ Storage::url($documentation_path) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                            <i class="ph-bold ph-file text-slate-400"></i>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="w-16 h-16 rounded-xl bg-slate-100 flex items-center justify-center text-slate-300 border-2 border-dashed border-slate-300">
                                    <i class="ph-bold ph-file-plus text-2xl"></i>
                                </div>
                            @endif

                            <div class="flex-1">
                                <div class="relative group">
                                        <input type="file" wire:model="documentation" accept=".pdf,.jpg,.jpeg,.png,.webp" id="doc-upload" class="hidden">
                                        <label for="doc-upload" 
                                        class="flex flex-col items-start justify-center p-4 border-2 border-dashed border-slate-300 rounded-2xl hover:border-rose-400 hover:bg-rose-50/50 transition-all cursor-pointer group-hover:shadow-sm">
                                        <div class="flex items-center gap-2 text-rose-600 font-bold mb-1">
                                            <i class="ph-bold ph-upload-simple"></i>
                                            <span>Upload File</span>
                                        </div>
                                        <p class="text-[10px] text-slate-500 font-medium">PDF/Gambar (Max 10MB)</p>
                                    </label>
                                </div>
                            </div>
                            </div>
                            @error('documentation') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Footer -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-slate-200">
                        <button type="button" wire:click="closeModal" 
                            class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-rose-500 to-pink-600 text-white font-bold shadow-lg shadow-rose-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-rose-500/40 disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center gap-2">
                            <span wire:loading.remove wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Simpan Jurnal' }}</span>
                            <span wire:loading wire:target="save"><i class="ph-bold ph-spinner animate-spin"></i> Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div class="relative bg-white/90 backdrop-blur-2xl border border-white/60 shadow-2xl rounded-[2.5rem] p-10 max-w-sm w-full text-center">
             <div class="mx-auto flex items-center justify-center w-20 h-20 rounded-3xl bg-rose-50 text-rose-500 mb-6 shadow-sm">
                <i class="ph-duotone ph-trash text-4xl"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Jurnal?</h3>
            <p class="text-slate-500 font-medium mb-8">Data yang dihapus tidak dapat dikembalikan.</p>
             <div class="flex gap-3">
                <button wire:click="closeDeleteModal" class="flex-1 px-5 py-3 rounded-xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50 transition-all">Batal</button>
                <button wire:click="delete" class="flex-1 px-5 py-3 rounded-xl bg-rose-500 text-white font-bold shadow-lg shadow-rose-500/30 hover:bg-rose-600 transition-all">Hapus</button>
            </div>
        </div>
    </div>
    
     <style>
        @keyframes blob { 0% { transform: translate(0px, 0px) scale(1); } 33% { transform: translate(30px, -50px) scale(1.1); } 66% { transform: translate(-20px, 20px) scale(0.9); } 100% { transform: translate(0px, 0px) scale(1); } }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
    </style>
</div>
