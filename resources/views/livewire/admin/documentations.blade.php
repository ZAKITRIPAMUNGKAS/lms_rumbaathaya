<div class="relative min-h-screen space-y-8 p-4 sm:p-8 overflow-hidden font-sans">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-violet-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-purple-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-fuchsia-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000">
        </div>
    </div>

    <!-- Hero Section -->
    <div
        class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-violet-600 to-fuchsia-600 p-8 sm:p-12 text-white shadow-2xl shadow-violet-500/20 group">
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
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-violet-100 mb-6 shadow-sm cursor-default">
                    <i class="ph-fill ph-images text-lg"></i>
                    <span>Manajemen Dokumentasi</span>
                </div>
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Data Dokumentasi
                </h1>
                <p class="text-violet-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                    Kelola dokumentasi foto, video, dan quotes untuk ditampilkan di website.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-violet-500/10 rounded-[2rem] p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-violet-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-violet-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center text-2xl shadow-sm">
                    <i class="ph-fill ph-images"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['total'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">Total</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-emerald-500/10 rounded-[2rem] p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-emerald-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-emerald-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shadow-sm">
                    <i class="ph-fill ph-image"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['photos'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">Foto</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-rose-500/10 rounded-[2rem] p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-rose-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-rose-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-2xl shadow-sm">
                    <i class="ph-fill ph-video-camera"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['videos'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">Video</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-amber-500/10 rounded-[2rem] p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-amber-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-amber-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl shadow-sm">
                    <i class="ph-fill ph-quotes"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['quotes'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">Quotes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div
        class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-violet-500/10 rounded-[2.5rem] p-6 md:p-8 relative overflow-hidden">

        <!-- Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-800">Daftar Dokumentasi</h2>
                <p class="text-slate-500 font-medium">Semua dokumentasi yang tersimpan.</p>
            </div>
            <button wire:click="openCreateModal"
                class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-violet-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tambah Dokumentasi</span>
            </button>
        </div>

        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative">
                <i
                    class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-violet-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari judul atau deskripsi..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
            <div class="relative">
                <i class="ph-bold ph-funnel absolute left-4 top-1/2 -translate-y-1/2 text-violet-500 text-lg"></i>
                <select wire:model.live="typeFilter"
                    class="w-full pl-11 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                    <option value="">Semua Tipe</option>
                    <option value="photo">Foto</option>
                    <option value="video">Video</option>
                    <option value="quotes">Quotes</option>
                </select>
                <i
                    class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>
            <div class="relative">
                <i class="ph-bold ph-tag absolute left-4 top-1/2 -translate-y-1/2 text-violet-500 text-lg"></i>
                <select wire:model.live="categoryFilter"
                    class="w-full pl-11 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <option value="kegiatan_belajar">Kegiatan Belajar</option>
                    <option value="event">Event</option>
                    <option value="prestasi">Prestasi</option>
                    <option value="fasilitas">Fasilitas</option>
                    <option value="lainnya">Lainnya</option>
                </select>
                <i
                    class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-3xl border border-white/60 bg-white/30 backdrop-blur-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-violet-50/50 border-b border-violet-100/50 text-violet-900 uppercase text-xs font-bold tracking-wider">
                        <th class="px-6 py-4 rounded-tl-3xl">Preview</th>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 rounded-tr-3xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-violet-50/50">
                    @forelse($documentations as $doc)
                        <tr class="hover:bg-white/60 transition-colors group">
                            <td class="px-6 py-4">
                                @if($doc->type === 'photo' && $doc->file_path)
                                    <img src="{{ Storage::url($doc->file_path) }}"
                                        class="w-16 h-16 rounded-xl object-cover border-2 border-white shadow-sm">
                                @elseif($doc->type === 'video')
                                    <div
                                        class="w-16 h-16 rounded-xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center border-2 border-white shadow-sm">
                                        <i class="ph-fill ph-video-camera text-2xl text-white"></i>
                                    </div>
                                @else
                                    <div
                                        class="w-16 h-16 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center border-2 border-white shadow-sm">
                                        <i class="ph-fill ph-quotes text-2xl text-white"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-800 group-hover:text-violet-600 transition-colors">
                                    {{ $doc->title }}
                                </div>
                                @if($doc->description)
                                    <div class="text-xs text-slate-500 line-clamp-1">{{ $doc->description }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border
                                        {{ $doc->type === 'photo' ? 'bg-emerald-50 text-emerald-700 border-emerald-100/50' : '' }}
                                        {{ $doc->type === 'video' ? 'bg-rose-50 text-rose-700 border-rose-100/50' : '' }}
                                        {{ $doc->type === 'quotes' ? 'bg-amber-50 text-amber-700 border-amber-100/50' : '' }}">
                                    {{ ucfirst($doc->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($doc->category)
                                    <span class="text-sm text-slate-600">
                                        {{ str_replace('_', ' ', ucwords($doc->category, '_')) }}
                                    </span>
                                @else
                                    <span class="text-sm text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="togglePublish({{ $doc->id }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border transition-all
                                        {{ $doc->is_published ? 'bg-emerald-50 text-emerald-700 border-emerald-100/50 hover:bg-emerald-100' : 'bg-slate-50 text-slate-600 border-slate-100/50 hover:bg-slate-100' }}">
                                    <i class="ph-fill {{ $doc->is_published ? 'ph-check-circle' : 'ph-eye-slash' }}"></i>
                                    {{ $doc->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEditModal({{ $doc->id }})"
                                        class="w-8 h-8 rounded-full bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-amber-500/30 group/btn"
                                        title="Edit">
                                        <i
                                            class="ph-bold ph-pencil-simple transition-transform group-hover/btn:rotate-12"></i>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $doc->id }})"
                                        class="w-8 h-8 rounded-full bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-rose-500/30 group/btn"
                                        title="Hapus">
                                        <i class="ph-bold ph-trash transition-transform group-hover/btn:rotate-12"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div
                                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="ph-duotone ph-images text-3xl text-slate-400"></i>
                                </div>
                                <p class="font-bold text-slate-600">Belum ada dokumentasi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documentations->hasPages())
            <div class="mt-6">
                {{ $documentations->links() }}
            </div>
        @endif
    </div>

    {{-- Modals will be added in next update --}}

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