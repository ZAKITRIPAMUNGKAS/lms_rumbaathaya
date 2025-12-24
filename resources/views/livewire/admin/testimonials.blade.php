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
                    <i class="ph-fill ph-star text-lg"></i>
                    <span>Testimoni</span>
                </div>
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Manajemen Testimoni
                </h1>
                <p class="text-violet-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                    Kelola testimoni dan ulasan dari siswa, orang tua, dan alumni.
                </p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-violet-500/10 rounded-[2rem] p-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center text-white shadow-lg">
                    <i class="ph-fill ph-star text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Total</p>
                    <p class="text-3xl font-black text-slate-800">{{ $this->stats['total'] }}</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-emerald-500/10 rounded-[2rem] p-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white shadow-lg">
                    <i class="ph-fill ph-check-circle text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Dipublikasikan</p>
                    <p class="text-3xl font-black text-slate-800">{{ $this->stats['published'] }}</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-amber-500/10 rounded-[2rem] p-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-white shadow-lg">
                    <i class="ph-fill ph-clock text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Draft</p>
                    <p class="text-3xl font-black text-slate-800">{{ $this->stats['unpublished'] }}</p>
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
                <h2 class="text-2xl font-black text-slate-800">Daftar Testimoni</h2>
                <p class="text-slate-500 font-medium">Semua testimoni dari siswa dan orang tua.</p>
            </div>
            <button wire:click="openCreateModal"
                class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-violet-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tambah Testimoni</span>
            </button>
        </div>

        <!-- Search -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <i
                    class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-violet-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau isi testimoni..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-2xl border border-slate-200">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Testimoni</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($testimonials as $testimonial)
                        <tr class="hover:bg-violet-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        @if($testimonial->photo_path)
                                            <img src="{{ Storage::url($testimonial->photo_path) }}"
                                                class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-fuchsia-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm border-2 border-white shadow-sm">
                                                {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div
                                            class="font-bold text-slate-800 group-hover:text-fuchsia-600 transition-colors">
                                            {{ $testimonial->name }}
                                        </div>
                                        @if($testimonial->role)
                                            <div class="text-xs text-slate-500">{{ $testimonial->role }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600 line-clamp-2">{{ $testimonial->content }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-0.5">
                                    @for($i = 0; $i < 5; $i++)
                                        <i
                                            class="ph-star {{ $i < $testimonial->rating ? 'ph-fill text-amber-400' : 'text-slate-300' }}"></i>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="togglePublish({{ $testimonial->id }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold transition-all {{ $testimonial->is_published ? 'bg-emerald-100 text-emerald-700 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                    <i
                                        class="ph-fill {{ $testimonial->is_published ? 'ph-check-circle' : 'ph-clock' }}"></i>
                                    {{ $testimonial->is_published ? 'Publik' : 'Draft' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEditModal({{ $testimonial->id }})"
                                        class="w-8 h-8 rounded-lg text-slate-400 hover:bg-amber-50 hover:text-amber-500 transition-all flex items-center justify-center"
                                        title="Edit">
                                        <i class="ph-bold ph-pencil-simple"></i>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $testimonial->id }})"
                                        class="w-8 h-8 rounded-lg text-slate-400 hover:bg-rose-50 hover:text-rose-500 transition-all flex items-center justify-center"
                                        title="Hapus">
                                        <i class="ph-bold ph-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div
                                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="ph-duotone ph-star text-3xl text-slate-400"></i>
                                </div>
                                <p class="font-bold text-slate-600">Belum ada testimoni</p>
                                <p class="text-sm text-slate-400">Tambahkan testimoni pertama sekarang!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($testimonials->hasPages())
            <div class="mt-6">
                {{ $testimonials->links() }}
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
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center text-white shadow-lg shadow-violet-500/20">
                        <i class="ph-fill ph-star text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">
                            {{ $editingId ? 'Edit Testimoni' : 'Tambah Testimoni' }}</h3>
                    </div>
                </div>
                <button wire:click="closeModal"
                    class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-all flex items-center justify-center">
                    <i class="ph-bold ph-x text-lg"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-8">
                <form wire:submit.prevent="save" class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                            Nama <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" wire:model="name"
                            class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-violet-400 focus:ring-4 focus:ring-violet-100 rounded-xl transition-all font-semibold placeholder-slate-400"
                            placeholder="Nama pemberi testimoni">
                        @error('name')
                            <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Peran/Jabatan</label>
                        <input type="text" wire:model="role"
                            class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-violet-400 focus:ring-4 focus:ring-violet-100 rounded-xl transition-all font-semibold placeholder-slate-400"
                            placeholder="Contoh: Siswa, Orang Tua, Alumni">
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                            Isi Testimoni <span class="text-rose-500">*</span>
                        </label>
                        <textarea wire:model="content" rows="4"
                            class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-violet-400 focus:ring-4 focus:ring-violet-100 rounded-xl transition-all font-semibold placeholder-slate-400"
                            placeholder="Tulis testimoni di sini..."></textarea>
                        @error('content')
                            <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Maksimal 1000 karakter</p>
                    </div>

                    <!-- Rating & Sort Order -->
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">
                                Rating <span class="text-rose-500">*</span>
                            </label>
                            <select wire:model="rating"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-violet-400 focus:ring-4 focus:ring-violet-100 rounded-xl transition-all font-semibold text-slate-700">
                                <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                                <option value="4">⭐⭐⭐⭐ (4)</option>
                                <option value="3">⭐⭐⭐ (3)</option>
                                <option value="2">⭐⭐ (2)</option>
                                <option value="1">⭐ (1)</option>
                            </select>
                            @error('rating')
                                <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Urutan
                                Tampil</label>
                            <input type="number" wire:model="sort_order"
                                class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-violet-400 focus:ring-4 focus:ring-violet-100 rounded-xl transition-all font-semibold"
                                placeholder="0">
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Foto
                            (Opsional)</label>
                        <input type="file" wire:model="photo" accept="image/*"
                            class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-violet-400 focus:ring-4 focus:ring-violet-100 rounded-xl transition-all">
                        @if($photo)
                            <p class="mt-2 text-sm text-emerald-600">✓ File dipilih: {{ $photo->getClientOriginalName() }}
                            </p>
                        @elseif($photo_path)
                            <p class="mt-2 text-sm text-slate-600">File saat ini: {{ basename($photo_path) }}</p>
                        @endif
                        @error('photo')
                            <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG, WEBP. Maksimal 2MB</p>
                    </div>

                    <!-- Publish Toggle -->
                    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl">
                        <input type="checkbox" wire:model="is_published" id="is_published_testi"
                            class="w-5 h-5 text-violet-600 border-slate-300 rounded focus:ring-violet-500">
                        <label for="is_published_testi" class="text-sm font-bold text-slate-700 cursor-pointer">
                            Publikasikan testimoni
                        </label>
                    </div>

                    <!-- Footer -->
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-slate-200">
                        <button type="button" wire:click="closeModal"
                            class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">
                            Batal
                        </button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 disabled:opacity-50 transition-all flex items-center gap-2">
                            <span wire:loading.remove
                                wire:target="save">{{ $editingId ? 'Simpan Perubahan' : 'Tambah Testimoni' }}</span>
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
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Testimoni?</h3>
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