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
                    <i class="ph-fill ph-chat-circle-text text-lg"></i>
                    <span>Manajemen Testimoni</span>
                </div>
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Data Testimoni
                </h1>
                <p class="text-violet-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                    Kelola testimoni dari siswa, orang tua, dan alumni untuk ditampilkan di website.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-violet-500/10 rounded-[2rem] p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-violet-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-violet-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center text-2xl shadow-sm">
                    <i class="ph-fill ph-chat-circle-text"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['total'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">Total Testimoni</p>
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
                    <i class="ph-fill ph-check-circle"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['published'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">Dipublikasikan</p>
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
                    <i class="ph-fill ph-eye-slash"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['unpublished'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">Draft</p>
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
                <p class="text-slate-500 font-medium">Semua testimoni yang tersimpan.</p>
            </div>
            <button wire:click="openCreateModal"
                class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-violet-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tambah Testimoni</span>
            </button>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <div class="relative">
                <i
                    class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-violet-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, peran, atau isi testimoni..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-3xl border border-white/60 bg-white/30 backdrop-blur-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-violet-50/50 border-b border-violet-100/50 text-violet-900 uppercase text-xs font-bold tracking-wider">
                        <th class="px-6 py-4 rounded-tl-3xl">Pemberi Testimoni</th>
                        <th class="px-6 py-4">Isi Testimoni</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 rounded-tr-3xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-violet-50/50">
                    @forelse($testimonials as $testimonial)
                        <tr class="hover:bg-white/60 transition-colors group">
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
                                <div class="text-sm text-slate-700 line-clamp-2">{{ $testimonial->content }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-amber-500">
                                    @for($i = 0; $i < $testimonial->rating; $i++)
                                        ⭐
                                    @endfor
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="togglePublish({{ $testimonial->id }})"
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border transition-all
                                                                    {{ $testimonial->is_published ? 'bg-emerald-50 text-emerald-700 border-emerald-100/50 hover:bg-emerald-100' : 'bg-slate-50 text-slate-600 border-slate-100/50 hover:bg-slate-100' }}">
                                    <i
                                        class="ph-fill {{ $testimonial->is_published ? 'ph-check-circle' : 'ph-eye-slash' }}"></i>
                                    {{ $testimonial->is_published ? 'Published' : 'Draft' }}
                                </button>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEditModal({{ $testimonial->id }})"
                                        class="w-8 h-8 rounded-full bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-amber-500/30 group/btn"
                                        title="Edit">
                                        <i
                                            class="ph-bold ph-pencil-simple transition-transform group-hover/btn:rotate-12"></i>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $testimonial->id }})"
                                        class="w-8 h-8 rounded-full bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-rose-500/30 group/btn"
                                        title="Hapus">
                                        <i class="ph-bold ph-trash transition-transform group-hover/btn:rotate-12"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div
                                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="ph-duotone ph-chat-circle-text text-3xl text-slate-400"></i>
                                </div>
                                <p class="font-bold text-slate-600">Belum ada testimoni</p>
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
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-data="{ show: @entangle('showModal') }"
            x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 backdrop-blur-sm"
                    @click="$wire.closeModal()"></div>

                <div
                    class="inline-block w-full max-w-2xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
                    <!-- Modal Header -->
                    <div
                        class="bg-gradient-to-r from-violet-600 to-fuchsia-600 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center gap-2">
                            <i class="ph-fill ph-{{ $editingId ? 'pencil' : 'plus-circle' }} text-2xl"></i>
                            {{ $editingId ? 'Edit Testimoni' : 'Tambah Testimoni' }}
                        </h3>
                        <button wire:click="closeModal"
                            class="text-white hover:bg-white/20 rounded-full p-2 transition-colors">
                            <i class="ph-bold ph-x text-xl"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form wire:submit.prevent="save" class="p-6">
                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Nama <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" wire:model="name"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-400 focus:border-transparent transition-all"
                                    placeholder="Nama pemberi testimoni">
                                @error('name')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Peran/Jabatan</label>
                                <input type="text" wire:model="role"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-400 focus:border-transparent transition-all"
                                    placeholder="Contoh: Siswa, Orang Tua, Alumni">
                            </div>

                            <!-- Content -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Isi Testimoni <span class="text-rose-500">*</span>
                                </label>
                                <textarea wire:model="content" rows="4"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-400 focus:border-transparent transition-all"
                                    placeholder="Tulis testimoni di sini..."></textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-slate-500">Maksimal 1000 karakter</p>
                            </div>

                            <!-- Rating & Photo -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">
                                        Rating <span class="text-rose-500">*</span>
                                    </label>
                                    <select wire:model="rating"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-400 focus:border-transparent transition-all">
                                        <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                                        <option value="4">⭐⭐⭐⭐ (4)</option>
                                        <option value="3">⭐⭐⭐ (3)</option>
                                        <option value="2">⭐⭐ (2)</option>
                                        <option value="1">⭐ (1)</option>
                                    </select>
                                    @error('rating')
                                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Urutan Tampil</label>
                                    <input type="number" wire:model="sort_order"
                                        class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-400 focus:border-transparent transition-all"
                                        placeholder="0">
                                </div>
                            </div>

                            <!-- Photo Upload -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Foto (Opsional)</label>
                                <input type="file" wire:model="photo" accept="image/*"
                                    class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-violet-400 focus:border-transparent transition-all">
                                @if($photo)
                                    <p class="mt-2 text-sm text-emerald-600">✓ File dipilih:
                                        {{ $photo->getClientOriginalName() }}
                                    </p>
                                @elseif($photo_path)
                                    <p class="mt-2 text-sm text-slate-600">File saat ini: {{ basename($photo_path) }}</p>
                                @endif
                                @error('photo')
                                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
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
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-slate-200">
                            <button type="button" wire:click="closeModal"
                                class="px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white rounded-xl font-bold hover:shadow-lg hover:-translate-y-0.5 transition-all flex items-center gap-2">
                                <i class="ph-bold ph-check-circle"></i>
                                {{ $editingId ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
            x-data="{ show: @entangle('showDeleteModal') }" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75 backdrop-blur-sm"
                    @click="$wire.closeDeleteModal()"></div>

                <div
                    class="inline-block w-full max-w-md my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
                    <div class="p-6">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-rose-100 rounded-full">
                            <i class="ph-fill ph-warning text-3xl text-rose-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-center text-slate-900 mb-2">Hapus Testimoni?</h3>
                        <p class="text-center text-slate-600 mb-6">
                            Data yang dihapus tidak dapat dikembalikan. Apakah Anda yakin?
                        </p>
                        <div class="flex items-center gap-3">
                            <button wire:click="closeDeleteModal"
                                class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition-colors">
                                Batal
                            </button>
                            <button wire:click="delete"
                                class="flex-1 px-6 py-3 bg-rose-600 text-white rounded-xl font-bold hover:bg-rose-700 transition-colors flex items-center justify-center gap-2">
                                <i class="ph-bold ph-trash"></i>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


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