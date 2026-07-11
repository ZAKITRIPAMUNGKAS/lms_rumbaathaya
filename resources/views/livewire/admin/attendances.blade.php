<div class="relative min-h-screen space-y-8 p-4 sm:p-8 overflow-hidden font-sans">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-amber-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-orange-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-red-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-amber-500 to-orange-600 p-8 sm:p-12 text-white shadow-2xl shadow-amber-500/20 group">
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16 group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10 group-hover:scale-110 transition-transform duration-500"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-amber-100 mb-6 shadow-sm cursor-default">
                    <i class="ph-fill ph-check-square-offset text-lg"></i>
                    <span>Absensi Kelas</span>
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Kehadiran Siswa
                </h1>
                <p class="text-amber-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                   Pantau kehadiran, kelola data absensi, dan pastikan rekapitulasi kegiatan belajar tercatat rapi.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-amber-500/10 rounded-[2.5rem] p-6 md:p-8 relative overflow-hidden">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div>
                 <h2 class="text-2xl font-black text-slate-800">Riwayat Absensi</h2>
                <p class="text-slate-500 font-medium">Data kehadiran semua siswa.</p>
            </div>
            <button wire:click="openCreateModal" class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold shadow-lg shadow-amber-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-amber-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Catat Kehadiran</span>
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col xl:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <i class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-amber-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari siswa atau topik..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-amber-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 w-full xl:w-auto">
                <div class="relative w-full">
                    <select wire:model.live="studentFilter" class="w-full pl-4 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-amber-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                        <option value="">👨‍🎓 Semua Siswa</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                    <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>

                <div class="relative w-full">
                    <select wire:model.live="tutorFilter" class="w-full pl-4 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-amber-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                        <option value="">👨‍🏫 Semua Tutor</option>
                        @foreach($tutors as $tutor)
                            <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                        @endforeach
                    </select>
                    <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>

                <div class="relative w-full">
                    <select wire:model.live="statusFilter" class="w-full pl-4 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-amber-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                         <option value="">📊 Semua Status</option>
                        <option value="present">Hadir</option>
                        <option value="absent">Tidak Hadir</option>
                        <option value="late">Terlambat</option>
                    </select>
                    <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <!-- Attendances List -->
        <div class="space-y-4">
            @forelse($attendances as $attendance)
                <div class="group relative bg-white/50 border border-white/60 hover:bg-white/80 transition-all duration-300 rounded-[2rem] p-5 shadow-sm hover:shadow-xl hover:shadow-amber-500/10 hover:-translate-y-1">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                         <!-- Date Badge -->
                        <div class="flex-shrink-0 text-center">
                            <div class="w-20 h-20 rounded-3xl bg-white border-2 border-slate-100 flex flex-col items-center justify-center group-hover:border-amber-200 transition-colors shadow-sm">
                                <span class="text-2xl font-black text-slate-800">{{ $attendance->date->format('d') }}</span>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $attendance->date->format('M') }}</span>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="flex-1 w-full text-center md:text-left">
                            <div class="flex flex-col md:flex-row items-center md:items-start gap-2 mb-2 justify-center md:justify-start">
                                <h3 class="font-extrabold text-slate-800 text-lg group-hover:text-amber-600 transition-colors">
                                    {{ $attendance->student->name ?? '-' }}
                                </h3>
                                 @php
                                    $statusColors = [
                                        'present' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'absent' => 'bg-rose-100 text-rose-700 border-rose-200',
                                        'late' => 'bg-amber-100 text-amber-700 border-amber-200'
                                    ];
                                    $statusIcons = [
                                        'present' => 'ph-check-circle',
                                        'absent' => 'ph-x-circle',
                                        'late' => 'ph-clock-countdown'
                                    ];
                                    $statusLabels = [
                                        'present' => 'Hadir',
                                        'absent' => 'Tidak Hadir',
                                        'late' => 'Terlambat'
                                    ];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $statusColors[$attendance->status] ?? 'bg-slate-100' }}">
                                    <i class="ph-fill {{ $statusIcons[$attendance->status] ?? 'ph-question' }}"></i>
                                    {{ $statusLabels[$attendance->status] ?? 'Unknown' }}
                                </span>
                            </div>
                            
                            <div class="flex flex-col md:flex-row gap-4 text-xs font-semibold text-slate-500 justify-center md:justify-start items-center">
                                 <span class="flex items-center gap-1.5 bg-white/60 px-2 py-1 rounded-lg">
                                    <i class="ph-fill ph-chalkboard-teacher text-indigo-400"></i>
                                    Tutor: <span class="text-slate-700">{{ $attendance->tutor->name ?? '-' }}</span>
                                </span>
                                @if($attendance->topic_taught)
                                    <span class="flex items-center gap-1.5 bg-white/60 px-2 py-1 rounded-lg max-w-[200px] truncate">
                                        <i class="ph-fill ph-book-bookmark text-pink-400"></i>
                                        Topik: <span class="text-slate-700" title="{{ $attendance->topic_taught }}">{{ $attendance->topic_taught }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Evidence / Actions -->
                         <div class="flex items-center gap-3 flex-shrink-0 w-full md:w-auto justify-center border-t md:border-t-0 border-slate-100 pt-4 md:pt-0">
                            @if($attendance->photo_evidence_path)
                                <a href="{{ Storage::url($attendance->photo_evidence_path) }}" target="_blank" 
                                    class="w-12 h-12 rounded-2xl bg-white hover:bg-white hover:scale-110 text-slate-400 hover:text-amber-500 transition-all border border-transparent hover:border-amber-200 shadow-sm hover:shadow-md flex items-center justify-center relative group/img overflow-hidden">
                                    <img src="{{ Storage::url($attendance->photo_evidence_path) }}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover/img:opacity-100">
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/10 group-hover/img:bg-transparent">
                                         <i class="ph-bold ph-eye text-white drop-shadow-md"></i>
                                    </div>
                                </a>
                            @endif

                            <div class="flex gap-2">
                                 <button wire:click="openEditModal({{ $attendance->id }})" 
                                    class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 flex items-center justify-center shadow-sm hover:shadow-indigo-500/30 group/btn" title="Edit">
                                    <i class="ph-bold ph-pencil-simple text-lg transition-transform group-hover/btn:rotate-12"></i>
                                </button>
                                <button wire:click="openDeleteModal({{ $attendance->id }})" 
                                    class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white transition-all duration-300 flex items-center justify-center shadow-sm hover:shadow-rose-500/30 group/btn" title="Hapus">
                                    <i class="ph-bold ph-trash text-lg transition-transform group-hover/btn:rotate-12"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                 <div class="col-span-full py-12 text-center text-slate-500">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ph-duotone ph-check-square-offset text-3xl text-slate-400"></i>
                    </div>
                    <p class="font-bold text-slate-600">Belum ada data absensi</p>
                    <p class="text-sm text-slate-400">Data kehadiran masih kosong.</p>
                </div>
            @endforelse
        </div>

        @if($attendances->hasPages())
            <div class="mt-6">
                {{ $attendances->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div class="relative bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl rounded-[2.5rem] w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col animate-modal-pop">
            
             <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-white/50 backdrop-blur-md z-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg shadow-amber-500/20">
                        <i class="ph-fill ph-check-square-offset text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ $editingId ? 'Edit Absensi' : 'Catat Kehadiran' }}</h3>
                    </div>
                </div>
                <button wire:click="closeModal" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-all flex items-center justify-center">
                    <i class="ph-bold ph-x text-lg"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-8">
                <form wire:submit.prevent="save" class="space-y-6">
                     <!-- Data Utama -->
                    <div class="bg-white/50 rounded-[2rem] p-6 border border-white/60 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Tutor Pengajar <span class="text-rose-500">*</span></label>
                            <select wire:model="tutor_id" required
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-amber-400 focus:ring-4 focus:ring-amber-100 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                                <option value="">Pilih Tutor</option>
                                @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                @endforeach
                            </select>
                            @error('tutor_id') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                         <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Siswa <span class="text-rose-500">*</span></label>
                            <select wire:model="student_id" required
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-amber-400 focus:ring-4 focus:ring-amber-100 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                                <option value="">Pilih Siswa</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('student_id') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Tanggal <span class="text-rose-500">*</span></label>
                            <input type="date" wire:model="date" required
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-amber-400 focus:ring-4 focus:ring-amber-100 rounded-xl transition-all font-semibold text-slate-700">
                            @error('date') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                         <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Status Kehadiran <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-3 gap-2">
                                <button type="button" wire:click="$set('status', 'present')" class="px-3 py-3 rounded-2xl border-2 font-bold text-xs transition-all {{ $status === 'present' ? 'bg-emerald-100 border-emerald-500 text-emerald-700' : 'bg-white border-slate-100 text-slate-500 hover:border-emerald-200' }}">
                                    Hadir
                                </button>
                                 <button type="button" wire:click="$set('status', 'absent')" class="px-3 py-3 rounded-2xl border-2 font-bold text-xs transition-all {{ $status === 'absent' ? 'bg-rose-100 border-rose-500 text-rose-700' : 'bg-white border-slate-100 text-slate-500 hover:border-rose-200' }}">
                                    Absen
                                </button>
                                 <button type="button" wire:click="$set('status', 'late')" class="px-3 py-3 rounded-2xl border-2 font-bold text-xs transition-all {{ $status === 'late' ? 'bg-amber-100 border-amber-500 text-amber-700' : 'bg-white border-slate-100 text-slate-500 hover:border-amber-200' }}">
                                    Terlambat
                                </button>
                            </div>
                            @error('status') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                     <!-- Detail Pembelajaran -->
                    <div class="space-y-4">
                       <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-2">
                            <i class="ph-fill ph-notebook text-lg"></i> Detail Pembelajaran
                        </h4>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Topik / Materi yang Diajarkan</label>
                            <input type="text" wire:model="topic_taught" placeholder="Contoh: Perkalian Dasar..."
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-amber-400 focus:ring-4 focus:ring-amber-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Catatan Progress Siswa</label>
                            <textarea wire:model="student_progress_note" rows="3" placeholder="Bagaimana perkembangan siswa hari ini?"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-amber-400 focus:ring-4 focus:ring-amber-100 rounded-xl transition-all font-semibold placeholder-slate-400"></textarea>
                        </div>
                    </div>

                     <!-- Photo Upload -->
                    <div class="bg-white/50 rounded-[2rem] p-6 border border-white/60">
                         <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide mb-4">Bukti Foto Kegiatan</h4>
                         <div class="flex items-center gap-4">
                            @if($photo_evidence)
                                <div class="w-24 h-24 rounded-2xl border-4 border-white shadow-md overflow-hidden relative">
                                    <img src="{{ $photo_evidence->temporaryUrl() }}" class="w-full h-full object-cover">
                                </div>
                            @elseif($photo_evidence_path)
                                <div class="w-24 h-24 rounded-2xl border-4 border-white shadow-md overflow-hidden relative">
                                    <img src="{{ Storage::url($photo_evidence_path) }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-24 h-24 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-300 border-4 border-white shadow-inner">
                                    <i class="ph-bold ph-camera text-2xl"></i>
                                </div>
                            @endif

                            <div class="flex-1">
                                <div class="relative group">
                                     <input type="file" wire:model="photo_evidence" accept="image/*" id="photo-upload" class="hidden">
                                     <label for="photo-upload" 
                                        class="flex flex-col items-start justify-center p-4 border-2 border-dashed border-slate-300 rounded-2xl hover:border-amber-400 hover:bg-amber-50/50 transition-all cursor-pointer group-hover:shadow-sm">
                                        <div class="flex items-center gap-2 text-amber-600 font-bold mb-1">
                                            <i class="ph-bold ph-upload-simple"></i>
                                            <span>Upload Foto</span>
                                        </div>
                                        <p class="text-[10px] text-slate-500 font-medium">Klik untuk memilih (Max 5MB)</p>
                                    </label>
                                </div>
                            </div>
                         </div>
                         @error('photo_evidence') <span class="text-xs text-rose-500 font-bold mt-2 block">{{ $message }}</span> @enderror
                    </div>

                     <!-- Footer -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-slate-200">
                        <button type="button" wire:click="closeModal" 
                            class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold shadow-lg shadow-amber-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-amber-500/40 disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center gap-2">
                            <span wire:loading.remove wire:target="save">{{ $editingId ? 'Simpan Data' : 'Simpan Absensi' }}</span>
                            <span wire:loading wire:target="save"><i class="ph-bold ph-spinner animate-spin"></i> Memproses...</span>
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
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Absensi?</h3>
            <p class="text-slate-500 font-medium mb-8">Data yang dihapus tidak dapat dipulihkan.</p>
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
