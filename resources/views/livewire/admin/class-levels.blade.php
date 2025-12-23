<div class="relative min-h-screen space-y-8 p-4 sm:p-8 overflow-hidden font-sans">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-cyan-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-blue-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-sky-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000">
        </div>
    </div>

    <!-- Hero Section -->
    <div
        class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-cyan-500 to-blue-600 p-8 sm:p-12 text-white shadow-2xl shadow-cyan-500/20 group">
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
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-cyan-100 mb-6 shadow-sm cursor-default">
                    <i class="ph-fill ph-stack text-lg"></i>
                    <span>Manajemen Akademik</span>
                </div>
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Jenjang Kelas
                </h1>
                <p class="text-cyan-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                    Atur tingkatan kelas untuk pengelompokan siswa dan materi pembelajaran.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-cyan-500/10 rounded-[2rem] p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-cyan-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-cyan-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-cyan-100 text-cyan-600 flex items-center justify-center text-2xl shadow-sm">
                    <i class="ph-fill ph-stack"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $classLevels->total() }}</h3>
                    <p class="text-sm font-bold text-slate-500">Total Jenjang</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div
        class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-cyan-500/10 rounded-[2.5rem] p-6 md:p-8 relative overflow-hidden">

        <!-- Header -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-800">Daftar Jenjang</h2>
                <p class="text-slate-500 font-medium">Semua data jenjang yang aktif.</p>
            </div>
            <button wire:click="openCreateModal"
                class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-bold shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-cyan-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tambah Jenjang</span>
            </button>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <div class="relative">
                <i
                    class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-cyan-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari jenjang kelas..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-cyan-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-3xl border border-white/60 bg-white/30 backdrop-blur-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-cyan-50/50 border-b border-cyan-100/50 text-cyan-900 uppercase text-xs font-bold tracking-wider">
                        <th class="px-6 py-4 rounded-tl-3xl">Nama Jenjang</th>
                        <th class="px-6 py-4 rounded-tr-3xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cyan-50/50">
                    @forelse($classLevels as $classLevel)
                        <tr class="hover:bg-white/60 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-700 group-hover:text-cyan-600 transition-colors">
                                    {{ $classLevel->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEditModal({{ $classLevel->id }})"
                                        class="w-8 h-8 rounded-full bg-cyan-50 text-cyan-600 hover:bg-cyan-500 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-cyan-500/30 group/btn"
                                        title="Edit">
                                        <i
                                            class="ph-bold ph-pencil-simple transition-transform group-hover/btn:rotate-12"></i>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $classLevel->id }})"
                                        class="w-8 h-8 rounded-full bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-rose-500/30 group/btn"
                                        title="Hapus">
                                        <i class="ph-bold ph-trash transition-transform group-hover/btn:rotate-12"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-12 text-center text-slate-500">
                                <div
                                    class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="ph-duotone ph-stack text-3xl text-slate-400"></i>
                                </div>
                                <p class="font-bold text-slate-600">Belum ada data jenjang</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($classLevels->hasPages())
            <div class="mt-6">
                {{ $classLevels->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div
            class="relative bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl rounded-[2.5rem] w-full max-w-md overflow-hidden flex flex-col animate-modal-pop">
            <div
                class="flex items-center justify-between p-6 border-b border-slate-100 bg-white/50 backdrop-blur-md z-10">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-cyan-500/20">
                        <i class="ph-fill ph-stack text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">
                            {{ $editingId ? 'Edit Jenjang' : 'Tambah Jenjang' }}</h3>
                    </div>
                </div>
                <button wire:click="closeModal"
                    class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-all flex items-center justify-center">
                    <i class="ph-bold ph-x text-lg"></i>
                </button>
            </div>

            <div class="p-6">
                <form wire:submit.prevent="save" class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama Jenjang
                            <span class="text-rose-500">*</span></label>
                        <input type="text" wire:model="name"
                            class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-cyan-400 focus:ring-4 focus:ring-cyan-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                        @error('name') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" wire:click="closeModal"
                            class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">Batal</button>
                        <button type="submit"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-bold shadow-lg shadow-cyan-500/30 hover:shadow-xl hover:-translate-y-1 transition-all">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div x-data="{ show: @entangle('showDeleteModal') }" x-show="show" style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div
            class="relative bg-white/90 backdrop-blur-2xl border border-white/60 shadow-2xl rounded-[2.5rem] p-10 max-w-sm w-full text-center">
            <div
                class="mx-auto flex items-center justify-center w-20 h-20 rounded-3xl bg-rose-50 text-rose-500 mb-6 shadow-sm">
                <i class="ph-duotone ph-trash text-4xl"></i>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Jenjang?</h3>
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