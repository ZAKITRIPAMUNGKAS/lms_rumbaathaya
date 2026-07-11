<div class="relative min-h-screen space-y-8 p-4 sm:p-8 overflow-hidden font-sans">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-purple-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000">
        </div>
    </div>

    <!-- Hero Section -->
    <div
        class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-indigo-600 to-purple-600 p-8 sm:p-12 text-white shadow-2xl shadow-indigo-500/20 group">
        <div
            class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16 group-hover:bg-white/20 transition-all duration-500">
        </div>
        <div
            class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10 group-hover:scale-110 transition-transform duration-500">
        </div>

        <div
            class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="flex-1">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-indigo-100 mb-6 shadow-sm cursor-default">
                    <i class="ph-fill ph-image text-lg"></i>
                    <span>Galeri & Dokumentasi</span>
                </div>
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Manajemen Dokumentasi
                </h1>
                <p class="text-indigo-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                    Kelola foto, video, dan dokumentasi kegiatan pembelajaran dan event.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-indigo-500/10 rounded-[2rem] p-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg">
                    <i class="ph-fill ph-files text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Total</p>
                    <p class="text-2xl font-black text-slate-800">{{ $this->stats['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-sky-500/10 rounded-[2rem] p-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white shadow-lg">
                    <i class="ph-fill ph-image text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Foto</p>
                    <p class="text-2xl font-black text-slate-800">{{ $this->stats['photos'] }}</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-rose-500/10 rounded-[2rem] p-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center text-white shadow-lg">
                    <i class="ph-fill ph-film-strip text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Video</p>
                    <p class="text-2xl font-black text-slate-800">{{ $this->stats['videos'] }}</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-amber-500/10 rounded-[2rem] p-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg">
                    <i class="ph-fill ph-quotes text-2xl"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Quotes</p>
                    <p class="text-2xl font-black text-slate-800">{{ $this->stats['quotes'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div
        class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-indigo-500/10 rounded-[2.5rem] p-6 md:p-8 relative overflow-hidden">

        <!-- Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-800">Daftar Dokumentasi</h2>
                <p class="text-slate-500 font-medium">Semua dokumentasi kegiatan dan event.</p>
            </div>
            <button wire:click="openCreateModal"
                class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-indigo-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tambah Dokumentasi</span>
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <i
                    class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-indigo-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul atau deskripsi..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
            <div class="relative md:w-48">
                <select wire:model.live="typeFilter"
                    class="w-full px-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                    <option value="">Semua Tipe</option>
                    <option value="photo">Foto</option>
                    <option value="video">Video</option>
                    <option value="quotes">Quotes</option>
                </select>
            </div>
            <div class="relative md:w-48">
                <select wire:model.live="categoryFilter"
                    class="w-full px-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option value="Kegiatan Belajar">Kegiatan Belajar</option>
                    <option value="Event">Event</option>
                    <option value="Prestasi">Prestasi</option>
                    <option value="Fasilitas">Fasilitas</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
        </div>

        <!-- Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($documentations as $doc)
                <div
                    class="group relative bg-white/50 border border-white/60 hover:bg-white/80 transition-all duration-300 rounded-[2rem] p-5 shadow-sm hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 flex flex-col h-full">
                    <!-- Media Section -->
                    <div class="relative mb-4 shrink-0 overflow-hidden rounded-2xl aspect-video bg-slate-100">
                        @if($doc->type === 'video' && $doc->video_url)
                            <!-- You would typically embed or show a thumbnail for video here. For simplicity, showing an icon or thumbnail if available -->
                            <div
                                class="w-full h-full flex items-center justify-center bg-slate-900 text-white group-hover:scale-105 transition-transform duration-500">
                                <i class="ph-fill ph-youtube-logo text-5xl text-red-500"></i>
                            </div>
                        @elseif($doc->file_path)
                            <img src="{{ Storage::url($doc->file_path) }}" alt="{{ $doc->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                <i class="ph-fill ph-image text-4xl"></i>
                            </div>
                        @endif

                        <!-- Type Badge -->
                        <div
                            class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-white/90 backdrop-blur-sm text-xs font-bold uppercase tracking-wider shadow-sm flex items-center gap-1.5
                                {{ $doc->type === 'video' ? 'text-rose-600' : ($doc->type === 'quotes' ? 'text-amber-600' : 'text-sky-600') }}">
                            <i
                                class="ph-bold {{ $doc->type === 'video' ? 'ph-film-strip' : ($doc->type === 'quotes' ? 'ph-quotes' : 'ph-image') }}"></i>
                            {{ ucfirst($doc->type) }}
                        </div>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 flex flex-col mb-4">
                        <div class="flex items-start justify-between gap-2 mb-2">
                            <span class="text-xs font-bold text-slate-400">
                                <i class="ph-bold ph-calendar-blank mr-1"></i>
                                {{ $doc->event_date ? \Carbon\Carbon::parse($doc->event_date)->translatedFormat('d M Y') : '-' }}
                            </span>
                            <span
                                class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-bold uppercase tracking-wider border border-indigo-100">
                                {{ $doc->category ?? 'Lainnya' }}
                            </span>
                        </div>
                        <h3
                            class="font-extrabold text-slate-800 text-lg mb-2 leading-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                            {{ $doc->title }}
                        </h3>
                        @if($doc->description)
                            <p class="text-xs font-medium text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $doc->description }}
                            </p>
                        @endif
                    </div>

                    <!-- Footer & Actions -->
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                        <button wire:click="togglePublish({{ $doc->id }})"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all {{ $doc->is_published ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                            <i class="ph-fill {{ $doc->is_published ? 'ph-check-circle' : 'ph-clock' }}"></i>
                            {{ $doc->is_published ? 'Publik' : 'Draft' }}
                        </button>

                        <div class="flex items-center gap-1">
                            <button wire:click="openEditModal({{ $doc->id }})"
                                class="w-8 h-8 rounded-lg text-slate-400 hover:bg-amber-50 hover:text-amber-500 transition-all flex items-center justify-center"
                                title="Edit">
                                <i class="ph-bold ph-pencil-simple"></i>
                            </button>
                            <button wire:click="openDeleteModal({{ $doc->id }})"
                                class="w-8 h-8 rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all flex items-center justify-center"
                                title="Hapus">
                                <i class="ph-bold ph-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-500">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ph-duotone ph-image text-3xl text-slate-400"></i>
                    </div>
                    <p class="font-bold text-slate-600">Belum ada dokumentasi</p>
                    <p class="text-sm text-slate-400">Tambahkan dokumentasi kegiatan sekarang!</p>
                </div>
            @endforelse
        </div>

        @if($documentations->hasPages())
            <div class="mt-6">
                {{ $documentations->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div
            class="relative bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl rounded-[2.5rem] w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col">

            <!-- Header -->
            <div
                class="flex items-center justify-between p-6 border-b border-slate-100 bg-white/50 backdrop-blur-md z-10">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                        <i class="ph-fill ph-image text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">
                            {{ $editingId ? 'Edit Dokumentasi' : 'Tambah Dokumentasi' }}</h3>
                    </div>
                </div>
                <button wire:click="closeModal"
                    class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-all flex items-center justify-center">
                    <i class="ph-bold ph-x text-lg"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-8">
                <form wire:submit.prevent="save" class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                            Judul <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" wire:model="title"
                            class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400"
                            placeholder="Judul dokumentasi...">
                        @error('title') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Type & Category -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                                Tipe <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model.live="type"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold text-slate-700">
                                <option value="photo">Foto</option>
                                <option value="video">Video (Youtube)</option>
                                <option value="quotes">Quotes</option>
                            </select>
                            @error('type') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                                Kategori <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model="category"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold text-slate-700">
                                <option value="">Pilih Kategori</option>
                                <option value="Kegiatan Belajar">Kegiatan Belajar</option>
                                <option value="Event">Event</option>
                                <option value="Prestasi">Prestasi</option>
                                <option value="Fasilitas">Fasilitas</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            @error('category') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Specific Fields based on Type -->
                    @if($type === 'video')
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                                Link Video Youtube <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <i
                                    class="ph-fill ph-youtube-logo absolute left-4 top-1/2 -translate-y-1/2 text-red-500 text-xl"></i>
                                <input type="url" wire:model="video_url"
                                    class="w-full pl-12 pr-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400"
                                    placeholder="https://youtube.com/watch?v=...">
                            </div>
                            @error('video_url') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                                Upload File ({{ $type === 'quotes' ? 'Foto/Gambar Background' : 'Foto' }})
                            </label>
                            <input type="file" wire:model="file" accept="image/*"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all">
                            @if($file)
                                <p class="mt-2 text-sm text-emerald-600">✓ File dipilih: {{ $file->getClientOriginalName() }}
                                </p>
                            @elseif($file_path)
                                <p class="mt-2 text-sm text-slate-600">File saat ini: <a href="{{ Storage::url($file_path) }}"
                                        target="_blank" class="text-indigo-500 hover:underline">Lihat</a></p>
                            @endif
                            @error('file') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <!-- Date & Description -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                                Tanggal Event
                            </label>
                            <input type="date" wire:model="event_date"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold text-slate-700">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                                Urutan Tampil
                            </label>
                            <input type="number" wire:model="sort_order"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold"
                                placeholder="0">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                            Deskripsi
                        </label>
                        <textarea wire:model="description" rows="3"
                            class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400"
                            placeholder="Deskripsi singkat..."></textarea>
                    </div>

                    <!-- Publish Toggle -->
                    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                        <input type="checkbox" wire:model="is_published" id="is_published_doc"
                            class="w-5 h-5 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500">
                        <label for="is_published_doc" class="text-sm font-bold text-slate-700 cursor-pointer">
                            Publikasikan dokumentasi
                        </label>
                    </div>

                    <!-- Footer -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-slate-200">
                        <button type="button" wire:click="closeModal"
                            class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-indigo-500/40 disabled:opacity-50 disabled:cursor-not-allowed transition-all flex items-center gap-2">
                            <span wire:loading.remove
                                wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Tambah Dokumentasi' }}</span>
                            <span wire:loading wire:target="save"><i class="ph-bold ph-spinner animate-spin"></i>
                                Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div
            class="relative bg-white/90 backdrop-blur-2xl border border-white/60 shadow-2xl rounded-[2.5rem] p-10 max-w-sm w-full text-center">
            <div
                class="mx-auto flex items-center justify-center w-20 h-20 rounded-3xl bg-rose-50 text-rose-500 mb-6 shadow-sm">
                <i class="ph-duotone ph-trash text-4xl"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Dokumentasi?</h3>
            <p class="text-slate-500 font-medium mb-8">Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="flex gap-3">
                <button wire:click="closeDeleteModal"
                    class="flex-1 px-5 py-3 rounded-xl border border-slate-200 text-slate-700 font-bold hover:bg-slate-50 transition-all">Batal</button>
                <button wire:click="delete"
                    class="flex-1 px-5 py-3 rounded-xl bg-rose-500 text-white font-bold shadow-lg shadow-rose-500/30 hover:bg-rose-600 transition-all">Hapus</button>
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
    </style>
</div>