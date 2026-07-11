<div class="relative min-h-screen space-y-8 p-4 sm:p-8 overflow-hidden font-sans">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-indigo-600 to-purple-600 p-8 sm:p-12 text-white shadow-2xl shadow-indigo-500/20 group">
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16 group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10 group-hover:scale-110 transition-transform duration-500"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-indigo-100 mb-6 shadow-sm cursor-default">
                    <i class="ph-fill ph-books text-lg"></i>
                    <span>Bank Materi</span>
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Manajemen Materi
                </h1>
                <p class="text-indigo-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                   Pusat penyimpanan modul, bahan ajar, dan konten edukasi untuk kegiatan belajar mengajar.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-indigo-500/10 rounded-[2.5rem] p-6 md:p-8 relative overflow-hidden">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div>
                 <h2 class="text-2xl font-black text-slate-800">Daftar Materi</h2>
                <p class="text-slate-500 font-medium">Semua modul dan bahan ajar.</p>
            </div>
            <button wire:click="openCreateModal" class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-indigo-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tambah Materi</span>
            </button>
        </div>

        <!-- Filters -->
         <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <i class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-indigo-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul materi..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
            <div class="relative md:w-64">
                <select wire:model.live="subjectFilter" class="w-full px-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                    <option value="">Semua Mapel</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative md:w-64">
                <select wire:model.live="classLevelFilter" class="w-full px-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                    <option value="">Semua Jenjang</option>
                    @foreach($classLevels as $classLevel)
                        <option value="{{ $classLevel->id }}">{{ $classLevel->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Materials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($materials as $material)
                <div class="group relative bg-white/50 border border-white/60 hover:bg-white/80 transition-all duration-300 rounded-[2rem] p-5 shadow-sm hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 flex flex-col h-full">
                    <!-- Icon/Thumbnail Section -->
                    <div class="relative mb-4 shrink-0">
                         @if($material->video_url)
                            <div class="relative w-full aspect-video rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white shadow-inner group-hover:scale-[1.02] transition-transform duration-300 overflow-hidden">
                                <div class="absolute top-0 right-0 w-20 h-20 bg-white/20 rounded-full -mr-10 -mt-10"></div>
                                <div class="absolute bottom-0 left-0 w-16 h-16 bg-black/10 rounded-full -ml-8 -mb-8"></div>
                                <i class="ph-fill ph-youtube-logo text-5xl drop-shadow-lg z-10"></i>
                            </div>
                        @elseif($material->file_path)
                            @php
                                $extension = pathinfo($material->file_path, PATHINFO_EXTENSION);
                                $bgClass = match(strtolower($extension)) {
                                    'pdf' => 'from-red-500 to-rose-600',
                                    'doc', 'docx' => 'from-blue-500 to-indigo-600',
                                    'xls', 'xlsx' => 'from-emerald-500 to-teal-600',
                                    'ppt', 'pptx' => 'from-orange-500 to-amber-600',
                                    default => 'from-slate-500 to-slate-600'
                                };
                                $iconClass = match(strtolower($extension)) {
                                    'pdf' => 'ph-file-pdf',
                                    'doc', 'docx' => 'ph-file-doc',
                                    'xls', 'xlsx' => 'ph-file-xls',
                                    'ppt', 'pptx' => 'ph-file-ppt',
                                    default => 'ph-file'
                                };
                            @endphp
                            <div class="relative w-full aspect-video rounded-2xl bg-gradient-to-br {{ $bgClass }} flex items-center justify-center text-white shadow-inner group-hover:scale-[1.02] transition-transform duration-300 overflow-hidden">
                                 <div class="absolute top-0 right-0 w-20 h-20 bg-white/20 rounded-full -mr-10 -mt-10"></div>
                                <i class="ph-fill {{ $iconClass }} text-5xl drop-shadow-lg z-10"></i>
                            </div>
                        @else
                            <div class="relative w-full aspect-video rounded-2xl bg-gradient-to-br from-slate-400 to-slate-600 flex items-center justify-center text-white shadow-inner group-hover:scale-[1.02] transition-transform duration-300">
                                <i class="ph-fill ph-file-text text-5xl drop-shadow-lg"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-1 flex flex-col mb-4">
                        <div class="flex items-start justify-between gap-2 mb-2">
                             <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider border border-indigo-100">
                                 {{ $material->subject->name ?? 'Umum' }}
                            </span>
                             <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-pink-50 text-pink-600 text-[10px] font-bold uppercase tracking-wider border border-pink-100">
                                 {{ $material->classLevel->name ?? 'Semua' }}
                            </span>
                        </div>
                        <h3 class="font-extrabold text-slate-800 text-lg mb-2 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                            {{ $material->title }}
                        </h3>
                        @if($material->description)
                            <p class="text-xs font-medium text-slate-500 line-clamp-2 leading-relaxed">
                                {{ strip_tags($material->description) }}
                            </p>
                        @endif
                    </div>

                    <!-- Footer & Actions -->
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                        <div class="flex gap-2">
                             @if($material->file_path)
                                <a href="{{ Storage::url($material->file_path) }}" target="_blank" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-600 hover:bg-indigo-600 hover:text-white text-xs font-bold transition-all duration-300" title="Download">
                                    <i class="ph-bold ph-download-simple"></i>
                                    <span>Unduh</span>
                                </a>
                            @endif
                             @if($material->video_url)
                                <a href="{{ $material->video_url }}" target="_blank" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white text-xs font-bold transition-all duration-300" title="Tonton">
                                    <i class="ph-bold ph-play-circle"></i>
                                    <span>Tonton</span>
                                </a>
                            @endif
                        </div>

                        <div class="flex items-center gap-1">
                            <button wire:click="openEditModal({{ $material->id }})" 
                                class="w-8 h-8 rounded-lg text-slate-400 hover:bg-amber-50 hover:text-amber-500 transition-all flex items-center justify-center" title="Edit">
                                <i class="ph-bold ph-pencil-simple"></i>
                            </button>
                            <button wire:click="openDeleteModal({{ $material->id }})" 
                                class="w-8 h-8 rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all flex items-center justify-center" title="Hapus">
                                <i class="ph-bold ph-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                 <div class="col-span-full py-12 text-center text-slate-500">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ph-duotone ph-books text-3xl text-slate-400"></i>
                    </div>
                    <p class="font-bold text-slate-600">Belum ada materi</p>
                    <p class="text-sm text-slate-400">Upload materi pembelajaran pertama sekarang!</p>
                </div>
            @endforelse
        </div>

        @if($materials->hasPages())
            <div class="mt-6">
                {{ $materials->links() }}
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
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                        <i class="ph-fill ph-book-open-text text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ $editingId ? 'Edit Materi' : 'Tambah Materi' }}</h3>
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
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Judul Materi <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="title" placeholder="Contoh: Modul Matematika Dasar Bab 1"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                            @error('title') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Mata Pelajaran <span class="text-rose-500">*</span></label>
                                <select wire:model="subject_id"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                                    <option value="">Pilih Mapel</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Jenjang Kelas <span class="text-rose-500">*</span></label>
                                <select wire:model="class_level_id"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                                    <option value="">Pilih Jenjang</option>
                                    @foreach($classLevels as $classLevel)
                                        <option value="{{ $classLevel->id }}">{{ $classLevel->name }}</option>
                                    @endforeach
                                </select>
                                @error('class_level_id') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Deskripsi <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                            <textarea wire:model="description" rows="3" placeholder="Jelaskan isi materi secara singkat..."
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400"></textarea>
                        </div>
                    </div>

                    <!-- Content Upload -->
                    <div class="bg-white/50 rounded-[2rem] p-6 border border-white/60 space-y-6">
                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-2">
                            <i class="ph-fill ph-paperclip text-lg"></i> File & Media
                        </h4>
                        
                            <!-- Video URL -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Link Video Youtube <span class="text-slate-400 font-normal normal-case">(Jika ada)</span></label>
                            <div class="relative">
                                <i class="ph-fill ph-youtube-logo absolute left-4 top-1/2 -translate-y-1/2 text-red-500 text-xl"></i>
                                <input type="url" wire:model="video_url" placeholder="https://youtube.com/watch?v=..."
                                    class="w-full pl-12 pr-5 py-3 bg-white/70 border border-slate-200 focus:border-red-400 focus:ring-4 focus:ring-red-100 rounded-xl transition-all font-semibold placeholder-slate-400 text-slate-700">
                            </div>
                        </div>

                        <div class="border-t border-slate-200"></div>

                        <!-- File Upload -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Upload File Dokumen</label>
                            
                            <div class="relative group">
                                    <input type="file" wire:model="file" id="file-upload" class="hidden">
                                    <label for="file-upload" 
                                    class="flex flex-col items-center justify-center p-8 border-2 border-dashed border-slate-300 rounded-3xl hover:border-indigo-400 hover:bg-indigo-50/50 transition-all cursor-pointer group-hover:shadow-sm bg-white/50">
                                    
                                    <div class="w-16 h-16 bg-indigo-50 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                        <i class="ph-duotone ph-cloud-arrow-up text-3xl text-indigo-500"></i>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="text-sm font-bold text-indigo-600 mb-1">Klik untuk upload file</p>
                                        <p class="text-xs text-slate-400 font-medium">PDF, DOCX, XLSX, PPTX (Max 10MB)</p>
                                    </div>
                                </label>
                            </div>
                            
                            @if($file)
                                <div class="mt-3 flex items-center gap-3 p-3 bg-indigo-50 border border-indigo-100 rounded-2xl animate-fade-in-up">
                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-indigo-600 shadow-sm">
                                        <i class="ph-fill ph-file text-xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-indigo-900 truncate">{{ $file->getClientOriginalName() }}</p>
                                        <p class="text-[10px] text-indigo-500 font-semibold">Siap diupload</p>
                                    </div>
                                    <button type="button" wire:click="$set('file', null)" class="p-2 text-indigo-400 hover:text-rose-500"><i class="ph-bold ph-x"></i></button>
                                </div>
                            @elseif($file_path)
                                    <div class="mt-3 flex items-center gap-3 p-3 bg-slate-100 border border-slate-200 rounded-2xl">
                                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-slate-500 shadow-sm">
                                        <i class="ph-fill ph-check-circle text-xl text-emerald-500"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-slate-700">File Tersimpan</p>
                                        <a href="{{ Storage::url($file_path) }}" target="_blank" class="text-[10px] text-indigo-500 font-bold hover:underline truncate block">Lihat File Saat Ini</a>
                                    </div>
                                </div>
                            @endif
                            
                            @error('file') <span class="text-xs font-bold text-rose-500 mt-2 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-slate-200">
                        <button type="button" wire:click="closeModal" 
                            class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-indigo-500/40 disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center gap-2">
                            <span wire:loading.remove wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Upload Materi' }}</span>
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
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Materi?</h3>
            <p class="text-slate-500 font-medium mb-8">File yang dihapus tidak dapat dikembalikan.</p>
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
