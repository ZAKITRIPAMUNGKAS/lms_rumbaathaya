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
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-fuchsia-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000">
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
                    <i class="ph-fill ph-student text-lg"></i>
                    <span>Manajemen Siswa</span>
                </div>
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Data Siswa
                </h1>
                <p class="text-indigo-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                    Kelola data siswa, informasi akademik, dan status keaktifan mereka dengan mudah.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-indigo-500/10 rounded-[2rem] p-6 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-indigo-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-indigo-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl shadow-sm">
                    <i class="ph-fill ph-student"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['total'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">Total Siswa</p>
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
                    <i class="ph-fill ph-user-check"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['active'] ?: $this->stats['total'] }}
                    </h3>
                    <p class="text-sm font-bold text-slate-500">Siswa Aktif</p>
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
                    <i class="ph-fill ph-sparkle"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-black text-slate-800">{{ $this->stats['new'] }}</h3>
                    <p class="text-sm font-bold text-slate-500">Siswa Baru</p>
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
                <h2 class="text-2xl font-black text-slate-800">Daftar Siswa</h2>
                <p class="text-slate-500 font-medium">Semua data siswa terdaftar.</p>
            </div>
            <button wire:click="openCreateModal"
                class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-indigo-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Tambah Siswa</span>
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <i
                    class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-indigo-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, email, atau sekolah..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>
            <div class="relative md:w-64">
                <i class="ph-bold ph-funnel absolute left-4 top-1/2 -translate-y-1/2 text-indigo-500 text-lg"></i>
                <select wire:model.live="classLevelFilter"
                    class="w-full pl-11 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-indigo-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                    <option value="">Semua Jenjang</option>
                    @foreach($classLevels as $classLevel)
                        <option value="{{ $classLevel->id }}">{{ $classLevel->name }}</option>
                    @endforeach
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
                        class="bg-indigo-50/50 border-b border-indigo-100/50 text-indigo-900 uppercase text-xs font-bold tracking-wider">
                        <th class="px-6 py-4 rounded-tl-3xl">Siswa</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Akademik</th>
                        <th class="px-6 py-4">Jenjang</th>
                        <th class="px-6 py-4 rounded-tr-3xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-indigo-50/50">
                    @forelse($students as $student)
                        <tr class="hover:bg-white/60 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        @if($student->profile_photo_path)
                                            <img src="{{ $student->profile_photo_path }}?v={{ time() }}"
                                                class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm border-2 border-white shadow-sm">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div
                                            class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white">
                                        </div>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                                            {{ $student->name }}
                                        </div>
                                        @if($student->nickname)
                                            <div class="text-xs text-slate-500">{{ $student->nickname }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                        <i class="ph-fill ph-envelope text-slate-400"></i>
                                        {{ $student->user?->email ?? '-' }}
                                    </span>
                                    <span class="text-xs font-semibold text-slate-600 flex items-center gap-1.5">
                                        <i class="ph-fill ph-whatsapp-logo text-emerald-500"></i>
                                        {{ $student->whatsapp_number ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-slate-700">{{ $student->school_origin }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-100/50">
                                    <i class="ph-fill ph-student text-amber-500"></i>
                                    {{ $student->classLevel?->name ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEditModal({{ $student->id }})"
                                        class="w-8 h-8 rounded-full bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-amber-500/30 group/btn"
                                        title="Edit">
                                        <i
                                            class="ph-bold ph-pencil-simple transition-transform group-hover/btn:rotate-12"></i>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $student->id }})"
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
                                    <i class="ph-duotone ph-student text-3xl text-slate-400"></i>
                                </div>
                                <p class="font-bold text-slate-600">Belum ada data siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
            <div class="mt-6">
                {{ $students->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div
            class="relative bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl rounded-[2.5rem] w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col animate-modal-pop">
            <div
                class="flex items-center justify-between p-6 border-b border-slate-100 bg-white/50 backdrop-blur-md z-10">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                        <i class="ph-fill ph-student text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">
                            {{ $editingId ? 'Edit Siswa' : 'Tambah Siswa' }}
                        </h3>
                    </div>
                </div>
                <button wire:click="closeModal"
                    class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-all flex items-center justify-center">
                    <i class="ph-bold ph-x text-lg"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-8">
                <form wire:submit.prevent="save" class="space-y-8">
                    <!-- Personal Info -->
                    <div class="space-y-4">
                        <h4 class="flex items-center gap-2 text-sm font-bold text-indigo-600 uppercase tracking-wider">
                            <i class="ph-fill ph-user-circle text-lg"></i> Informasi Pribadi
                        </h4>
                        <div
                            class="bg-white/50 rounded-[2rem] p-6 border border-white/60 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama
                                    Lengkap <span class="text-rose-500">*</span></label>
                                <input type="text" wire:model="name"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                                @error('name') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Nama
                                    Panggilan</label>
                                <input type="text" wire:model="nickname"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Email
                                    <span class="text-rose-500">*</span></label>
                                <input type="email" wire:model="email"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                                @error('email') <span class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Tempat
                                    Lahir</label>
                                <input type="text" wire:model="place_of_birth"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Tanggal
                                    Lahir</label>
                                <input type="date" wire:model="date_of_birth"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold text-slate-600">
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Alamat</label>
                                <textarea wire:model="address" rows="2"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-indigo-400 focus:ring-4 focus:ring-indigo-100 rounded-xl transition-all font-semibold placeholder-slate-400 resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Account & Academic -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <h4
                                class="flex items-center gap-2 text-sm font-bold text-amber-600 uppercase tracking-wider">
                                <i class="ph-fill ph-lock-key text-lg"></i> Password
                            </h4>
                            <div class="bg-white/50 rounded-[2rem] p-6 border border-white/60">
                                <label
                                    class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Password
                                    {{ $editingId ? '(Opsional)' : '*' }}</label>
                                <input type="password" wire:model="password" autocomplete="new-password"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-amber-400 focus:ring-4 focus:ring-amber-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                                @error('password') <span
                                    class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="space-y-4">
                            <h4
                                class="flex items-center gap-2 text-sm font-bold text-emerald-600 uppercase tracking-wider">
                                <i class="ph-fill ph-graduation-cap text-lg"></i> Data Sekolah
                            </h4>
                            <div class="bg-white/50 rounded-[2rem] p-6 border border-white/60 space-y-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Sekolah
                                        Asal <span class="text-rose-500">*</span></label>
                                    <input type="text" wire:model="school_origin"
                                        class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 rounded-xl transition-all font-semibold placeholder-slate-400">
                                    @error('school_origin') <span
                                    class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Jenjang
                                        <span class="text-rose-500">*</span></label>
                                    <select wire:model="class_level_id"
                                        class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100 rounded-xl transition-all font-semibold text-slate-600 cursor-pointer">
                                        <option value="">Pilih Jenjang</option>
                                        @foreach($classLevels as $classLevel)
                                            <option value="{{ $classLevel->id }}">{{ $classLevel->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('class_level_id') <span
                                    class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Photo -->
                    <div class="space-y-4">
                        <h4 class="flex items-center gap-2 text-sm font-bold text-indigo-600 uppercase tracking-wider">
                            <i class="ph-fill ph-image text-lg"></i> Foto Profil
                        </h4>
                        <div class="bg-white/50 rounded-[2rem] p-6 border border-white/60">
                            <div class="flex items-center gap-6">
                                <div class="shrink-0">
                                    @if($profile_photo)
                                        <img src="{{ $profile_photo->temporaryUrl() }}"
                                            class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-md">
                                    @elseif($profile_photo_path)
                                        <img src="{{ Storage::url($profile_photo_path) }}?v={{ time() }}"
                                            class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow-md">
                                    @else
                                        <div
                                            class="w-24 h-24 rounded-2xl bg-slate-200 flex items-center justify-center text-slate-400 border-4 border-white shadow-inner">
                                            <i class="ph-bold ph-user text-3xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="relative group flex-1">
                                    <input type="file" wire:model="profile_photo" id="upload-photo" class="hidden">
                                    <label for="upload-photo"
                                        class="block w-full border-2 border-dashed border-indigo-200 rounded-xl p-8 text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition-all">
                                        <i class="ph-bold ph-cloud-arrow-up text-3xl text-indigo-400 mb-2"></i>
                                        <p class="text-sm font-bold text-indigo-600">Klik untuk upload foto</p>
                                        <p class="text-xs text-slate-400 mt-1">PNG, JPG, up to 5MB</p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">
                        <button type="button" wire:click="closeModal"
                            class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">Batal</button>
                        <button type="submit"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:-translate-y-1 transition-all">
                            {{ $editingId ? 'Simpan Perubahan' : 'Tambah Siswa' }}
                        </button>
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
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Siswa?</h3>
            <p class="text-slate-500 font-medium mb-8">Data siswa yang dihapus tidak dapat dikembalikan.</p>
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