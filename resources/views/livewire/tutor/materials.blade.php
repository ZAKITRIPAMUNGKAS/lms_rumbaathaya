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
    <div class="relative overflow-hidden rounded-[2.5rem] bg-emerald-600 p-8 text-white shadow-xl shadow-emerald-500/20">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-600"></div>
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-emerald-100 mb-4">
                    <i class="ph ph-books text-yellow-300 text-lg"></i>
                    <span>Tutor Dashboard</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Bank Materi</h1>
                <p class="text-emerald-100 font-medium max-w-lg text-sm sm:text-base">
                    Simpan dan kelola modul pembelajaran Anda di sini.
                </p>
            </div>
            
            <button wire:click="openCreateModal" class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-emerald-600 font-bold shadow-lg shadow-black/5 hover:bg-emerald-50 hover:-translate-y-1 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Upload Materi</span>
            </button>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.01)] flex flex-col sm:flex-row items-center gap-4">
        <!-- Search -->
        <div class="relative w-full sm:flex-1">
            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl"></i>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari materi berdasarkan judul..." class="w-full pl-12 pr-4 py-3 border border-slate-200 rounded-2xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all font-semibold text-slate-700 placeholder:text-slate-400">
        </div>
        
        <!-- Subject Filter -->
        <select wire:model.live="subjectFilter" class="w-full sm:w-48 px-4 py-3 border border-slate-200 rounded-2xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 bg-white outline-none transition-all font-bold text-slate-600">
            <option value="">Semua Mapel</option>
            @foreach($subjects as $subj)
                <option value="{{ $subj->id }}">{{ $subj->name }}</option>
            @endforeach
        </select>

        <!-- Class Level Filter -->
        <select wire:model.live="classLevelFilter" class="w-full sm:w-48 px-4 py-3 border border-slate-200 rounded-2xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 bg-white outline-none transition-all font-bold text-slate-600">
            <option value="">Semua Kelas</option>
            @foreach($classLevels as $lvl)
                <option value="{{ $lvl->id }}">{{ $lvl->name }}</option>
            @endforeach
        </select>
    </div>

    @if($materials->count() > 0)
        <!-- Materials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($materials as $material)
                <div class="bg-white rounded-[2rem] p-6 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)] hover:scale-[1.02] hover:shadow-[0_15px_45px_rgb(0,0,0,0.04)] transition-all duration-300 group flex flex-col justify-between">
                    <div class="space-y-4">
                        <!-- Header -->
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $material->subject ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-slate-50 text-slate-500 border border-slate-100' }}">
                                        {{ $material->subject ? $material->subject->name : 'Umum' }}
                                    </span>
                                    @if($material->classLevel)
                                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-orange-50 text-orange-600 border border-orange-100">
                                            {{ $material->classLevel->name }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-1 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                    {{ $material->title }}
                                </h3>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($material->description)
                            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed font-semibold">
                                {{ strip_tags($material->description) }}
                            </p>
                        @endif

                        <!-- Video Link indicator if exists -->
                        @if($material->video_url)
                            <a href="{{ $material->video_url }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-xs font-bold hover:bg-red-100 transition-colors">
                                <i class="ph-bold ph-youtube-logo text-lg"></i>
                                Video Pendukung
                            </a>
                        @endif

                        <!-- Info -->
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100/50">
                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                                <i class="ph-bold ph-calendar-blank"></i>
                                <span>{{ \Carbon\Carbon::parse($material->created_at)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 pt-4 mt-4 border-t border-slate-50">
                        @if($material->file_path)
                            <a href="{{ asset('storage/' . $material->file_path) }}" 
                               target="_blank"
                               class="flex-1 px-4 py-2.5 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl font-bold text-xs hover:bg-emerald-600 hover:text-white transition-all flex items-center justify-center gap-2 group/btn">
                                <i class="ph-bold ph-download-simple group-hover/btn:animate-bounce"></i>
                                Download
                            </a>
                        @endif
                        <button wire:click="openEditModal({{ $material->id }})" 
                           class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-amber-50 hover:text-amber-500 transition-colors" title="Edit">
                            <i class="ph-bold ph-pencil-simple"></i>
                        </button>
                        <button wire:click="confirmDelete({{ $material->id }})" 
                           class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center hover:bg-rose-50 hover:text-rose-600 transition-colors" title="Hapus">
                            <i class="ph-bold ph-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($materials->hasPages())
            <div class="mt-6">
                {{ $materials->links() }}
            </div>
        @endif
    @else
        <div class="py-12 bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col items-center justify-center p-8 text-center">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500 text-3xl mb-4">
                <i class="ph ph-books"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Materi Tidak Ditemukan</h3>
            <p class="text-sm text-slate-500 mt-1 max-w-sm">Belum ada modul materi yang dicari atau diunggah. Klik tombol 'Upload Materi' untuk memulai.</p>
        </div>
    @endif

    <!-- Create/Edit Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-slate-950/40 backdrop-blur-sm" wire:click="resetForm"></div>

            <div class="relative w-full max-w-lg bg-white rounded-[2rem] shadow-2xl border border-slate-100 overflow-hidden z-10 animate-scale-in">
                <div class="p-6 sm:p-8 flex items-center justify-between border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xl font-extrabold text-slate-900">
                        {{ $editingId ? 'Edit Materi Pembelajaran' : 'Unggah Materi Baru' }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-600 text-xl font-bold p-1">✕</button>
                </div>

                <form wire:submit.prevent="save" class="p-6 sm:p-8 space-y-4">
                    <!-- Title -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Judul Materi</label>
                        <input type="text" wire:model="title" placeholder="Contoh: Modul Eksponen & Logaritma SMA Kelas 10" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all font-semibold text-slate-700">
                        @error('title') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Subject -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Mata Pelajaran</label>
                            <select wire:model="subject_id" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all font-semibold text-slate-700">
                                <option value="">-- Pilih Mapel --</option>
                                @foreach($subjects as $subj)
                                    <option value="{{ $subj->id }}">{{ $subj->name }}</option>
                                @endforeach
                            </select>
                            @error('subject_id') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Class Level -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Tingkat Kelas</label>
                            <select wire:model="class_level_id" class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all font-semibold text-slate-700">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($classLevels as $lvl)
                                    <option value="{{ $lvl->id }}">{{ $lvl->name }}</option>
                                @endforeach
                            </select>
                            @error('class_level_id') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Deskripsi / Petunjuk Belajar</label>
                        <textarea wire:model="description" rows="3" placeholder="Tuliskan petunjuk pengerjaan atau rangkuman materi di sini..." class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all font-semibold text-slate-700 placeholder:text-slate-400"></textarea>
                        @error('description') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Video URL -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Link Video Pembelajaran (Opsional)</label>
                        <input type="text" wire:model="video_url" placeholder="Contoh: https://www.youtube.com/watch?v=..." class="w-full px-4 py-3 border border-slate-200 bg-white rounded-xl focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition-all font-semibold text-slate-700">
                        @error('video_url') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <!-- File Upload -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Berkas Modul (PDF, Word, PPT, ZIP, Max 10MB)</label>
                        @if($file_path && !$file)
                            <div class="mb-2 p-2 border border-slate-100 rounded-xl bg-slate-50 flex items-center gap-3">
                                <i class="ph ph-file-pdf text-emerald-500 text-xl"></i>
                                <span class="text-xs text-slate-500 truncate">File terunggah saat ini</span>
                            </div>
                        @endif
                        <input type="file" wire:model="file" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        @error('file') <span class="text-xs text-rose-500 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="resetForm" class="flex-1 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl font-bold transition-all text-center">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition-all text-center shadow-lg shadow-emerald-500/20">
                            Simpan Materi
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
                <h3 class="text-lg font-bold text-slate-900">Hapus Materi?</h3>
                <p class="text-sm text-slate-500 mt-2 mb-6">Apakah Anda yakin ingin menghapus modul materi pembelajaran ini dari sistem?</p>
                
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
