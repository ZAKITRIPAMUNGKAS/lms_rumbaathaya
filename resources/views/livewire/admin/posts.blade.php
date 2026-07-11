<div class="relative min-h-screen space-y-8 p-4 sm:p-8 font-sans">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-sky-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-blue-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-indigo-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-sky-500 to-blue-600 p-8 sm:p-12 text-white shadow-2xl shadow-sky-500/20 group">
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16 group-hover:bg-white/20 transition-all duration-500"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10 group-hover:scale-110 transition-transform duration-500"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-sky-100 mb-6 shadow-sm cursor-default">
                    <i class="ph-fill ph-newspaper text-lg"></i>
                    <span>Konten & Informasi</span>
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Manajemen Artikel
                </h1>
                <p class="text-sky-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                   Kelola artikel, berita, dan pengumuman untuk ditampilkan di Mading Digital.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
         <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-sky-500/10 rounded-[2rem] p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute right-0 top-0 w-32 h-32 bg-sky-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-sky-200/50 transition-colors"></div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-2xl shadow-sm">
                    <i class="ph-fill ph-newspaper"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $posts->total() }}</h3>
                    <p class="text-sm font-bold text-slate-500">Total Artikel</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-sky-500/10 rounded-[2.5rem] p-6 md:p-8 relative overflow-hidden">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div>
                 <h2 class="text-2xl font-black text-slate-800">Daftar Artikel</h2>
                <p class="text-slate-500 font-medium">Semua artikel yang telah dibuat.</p>
            </div>
            <button wire:click="openCreateModal" class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 text-white font-bold shadow-lg shadow-sky-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-sky-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tambah Artikel</span>
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <i class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-sky-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari artikel..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-sky-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
            <div class="relative md:w-56">
                <select wire:model.live="categoryFilter" class="w-full px-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-sky-400 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative md:w-56">
                <select wire:model.live="statusFilter" class="w-full px-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-sky-400 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="1">Published</option>
                    <option value="0">Draft</option>
                </select>
            </div>
        </div>

        <!-- Grid Layout for Posts -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
                <div class="bg-white/50 border border-white/60 rounded-[2rem] p-5 hover:bg-white/80 transition-all duration-300 group hover:-translate-y-1 hover:shadow-lg hover:shadow-sky-500/5 flex flex-col h-full">
                    @if($post->thumbnail)
                        <div class="relative h-48 rounded-2xl overflow-hidden mb-4 shrink-0">
                            <img src="{{ Storage::url($post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 md:hidden"></div>
                        </div>
                    @else
                         <div class="h-48 rounded-2xl bg-sky-50 flex items-center justify-center mb-4 border border-sky-100 shrink-0">
                            <i class="ph-duotone ph-image text-4xl text-sky-200"></i>
                        </div>
                    @endif

                    <div class="flex-1 flex flex-col">
                        <div class="flex items-start justify-between mb-2 gap-2">
                             @if($post->category)
                                <span class="text-[10px] font-bold text-sky-600 bg-sky-100 px-2 py-1 rounded-full border border-sky-100 mb-2 inline-block">
                                    {{ $post->category }}
                                </span>
                            @endif
                        </div>
                         <h3 class="font-bold text-slate-800 leading-tight line-clamp-2 group-hover:text-sky-600 transition-colors mb-2">{{ $post->title }}</h3>
                        
                        <p class="text-xs font-medium text-slate-500 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($post->content), 100) }}
                        </p>
                        
                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-2">
                                 @if($post->is_published)
                                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                                    <span class="text-xs font-bold text-emerald-600">Published</span>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                    <span class="text-xs font-bold text-amber-600">Draft</span>
                                @endif
                            </div>
                            
                            <div class="flex gap-1">
                                <button wire:click="openEditModal({{ $post->id }})" class="p-2 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-500 hover:text-white transition-all">
                                    <i class="ph-bold ph-pencil-simple"></i>
                                </button>
                                <button wire:click="openDeleteModal({{ $post->id }})" class="p-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all">
                                    <i class="ph-bold ph-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-500">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ph-duotone ph-newspaper text-3xl text-slate-400"></i>
                    </div>
                    <p class="font-bold text-slate-600">Tidak ada artikel ditemukan</p>
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6" style="display: none;">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div class="relative bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col animate-modal-pop">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-100 bg-white/50 backdrop-blur-md z-10">
                <div class="flex items-center gap-4">
                     <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-sky-500/20">
                        <i class="ph-fill ph-newspaper text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">{{ $editingId ? 'Edit Artikel' : 'Tambah Artikel' }}</h3>
                    </div>
                </div>
                <button wire:click="closeModal" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-all flex items-center justify-center">
                    <i class="ph-bold ph-x text-lg"></i>
                </button>
            </div>
                    <!-- Modal Body -->
            <div class="flex-1 overflow-y-auto p-6 md:p-8">
                <form id="articleForm" wire:submit.prevent="save" class="space-y-6">
                    @if (session()->has('error'))
                        <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 text-sm font-bold flex items-center gap-2">
                            <i class="ph-bold ph-warning-circle text-lg shrink-0"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm font-bold flex items-center gap-2">
                            <i class="ph-bold ph-check-circle text-lg shrink-0"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Judul Artikel <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="title" class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-sky-400 focus:ring-4 focus:ring-sky-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                            @error('title') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Slug <span class="text-rose-500">*</span></label>
                            <input type="text" wire:model="slug" class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-sky-400 focus:ring-4 focus:ring-sky-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                            @error('slug') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Kategori <span class="text-rose-500">*</span></label>
                                <select wire:model="category" class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-sky-400 focus:ring-4 focus:ring-sky-100 rounded-xl transition-all font-semibold text-slate-600">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Kabar Rumba">Kabar Rumba</option>
                                    <option value="Karya Siswa">Karya Siswa</option>
                                    <option value="Info">Info</option>
                                </select>
                                @error('category') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Tanggal Publikasi</label>
                                <input type="datetime-local" wire:model="published_at" class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-sky-400 focus:ring-4 focus:ring-sky-100 rounded-xl transition-all font-semibold text-slate-600">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Konten <span class="text-rose-500">*</span></label>
                            <div wire:ignore>
                                <div id="summernote-editor">{!! $content !!}</div>
                            </div>
                            @error('content') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Thumbnail</label>
                            <div class="bg-white/50 rounded-[2rem] p-6 border border-white/60">
                                @if($thumbnail)
                                    <div class="mb-4">
                                        <p class="text-xs font-bold text-slate-500 mb-2">Preview:</p>
                                        <img src="{{ $thumbnail->temporaryUrl() }}" class="h-32 rounded-xl object-cover border-4 border-white shadow-sm">
                                    </div>
                                @elseif($thumbnail_path)
                                    <div class="mb-4">
                                        <p class="text-xs font-bold text-slate-500 mb-2">Saat ini:</p>
                                        <img src="{{ Storage::url($thumbnail_path) }}" class="h-32 rounded-xl object-cover border-4 border-white shadow-sm">
                                    </div>
                                @endif
                                
                                <div class="relative group">
                                    <input type="file" wire:model="thumbnail" id="thumb-upload" class="hidden">
                                    <label for="thumb-upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-sky-200 rounded-xl cursor-pointer hover:bg-sky-50 hover:border-sky-400 transition-all">
                                        <i class="ph-bold ph-image text-2xl text-sky-400 mb-2"></i>
                                        <span class="text-xs font-bold text-sky-600">Upload Thumbnail</span>
                                    </label>
                                </div>
                                @error('thumbnail') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                         <div class="flex items-center gap-3 bg-white/50 rounded-xl p-4 border border-white/60">
                             <div class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input type="checkbox" wire:model="is_published" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer left-0 top-0 transition-all duration-300 {{ $is_published ? 'translate-x-6 border-emerald-500' : 'border-slate-300' }}"/>
                                <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full cursor-pointer {{ $is_published ? 'bg-emerald-500' : 'bg-slate-300' }}"></label>
                            </div>
                            <label for="toggle" class="text-sm font-bold text-slate-700 cursor-pointer">Publikasikan Artikel Ini</label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer (Fixed at the bottom) -->
            <div class="flex justify-end gap-3 px-10 py-6 border-t border-slate-100 bg-white/50 backdrop-blur-md z-10 shrink-0">
                <button type="button" wire:click="closeModal" class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">Batal</button>
                <button type="submit" form="articleForm" wire:loading.attr="disabled" class="px-8 py-3 rounded-xl bg-gradient-to-r from-sky-600 to-blue-600 text-white font-bold shadow-lg shadow-sky-500/30 hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-2">
                    <span wire:loading.remove>{{ $editingId ? 'Simpan Perubahan' : 'Buat Artikel' }}</span>
                    <span wire:loading style="display: none;"><i class="ph-bold ph-spinner animate-spin animate-infinite"></i> Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Delete Modal -->
     <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div class="relative bg-white/90 backdrop-blur-2xl border border-white/60 shadow-2xl rounded-[2.5rem] p-10 max-w-sm w-full text-center">
             <div class="mx-auto flex items-center justify-center w-20 h-20 rounded-3xl bg-rose-50 text-rose-500 mb-6 shadow-sm">
                <i class="ph-duotone ph-trash text-4xl"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Artikel?</h3>
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

@include('livewire.admin.posts-scripts')