<div class="relative min-h-screen space-y-8 p-4 sm:p-8 overflow-hidden font-sans">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-violet-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-fuchsia-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-purple-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000">
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
                    <i class="ph-fill ph-calendar-check text-lg"></i>
                    <span>Manajemen Jadwal</span>
                </div>
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Jadwal Kelas
                </h1>
                <p class="text-violet-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                    Kelola jadwal pembelajaran, sesi tutor, dan kegiatan akademik lainnya.
                </p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-3 gap-3 sm:gap-6">
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-violet-500/10 rounded-2xl sm:rounded-[2rem] p-4 sm:p-6 relative overflow-hidden group hover:-translate-y-0.5 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-violet-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-violet-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-center text-center sm:text-left gap-2 sm:gap-4">
                <div
                    class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
                    <i class="ph-fill ph-calendar-check"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="text-xl sm:text-3xl font-black text-slate-800 leading-none">{{ $this->stats['total'] }}</h3>
                    <p class="text-[10px] sm:text-sm font-bold text-slate-500 mt-1 leading-none">Total Jadwal</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-fuchsia-500/10 rounded-2xl sm:rounded-[2rem] p-4 sm:p-6 relative overflow-hidden group hover:-translate-y-0.5 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-fuchsia-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-fuchsia-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-center text-center sm:text-left gap-2 sm:gap-4">
                <div
                    class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-fuchsia-100 text-fuchsia-600 flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
                    <i class="ph-fill ph-lightning"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="text-xl sm:text-3xl font-black text-slate-800 leading-none">{{ $this->stats['active'] }}</h3>
                    <p class="text-[10px] sm:text-sm font-bold text-slate-500 mt-1 leading-none">Jadwal Aktif</p>
                </div>
            </div>
        </div>
        <div
            class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-lg shadow-purple-500/10 rounded-2xl sm:rounded-[2rem] p-4 sm:p-6 relative overflow-hidden group hover:-translate-y-0.5 transition-all duration-300">
            <div
                class="absolute right-0 top-0 w-32 h-32 bg-purple-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none group-hover:bg-purple-200/50 transition-colors">
            </div>
            <div class="relative z-10 flex flex-col sm:flex-row items-center sm:items-center text-center sm:text-left gap-2 sm:gap-4">
                <div
                    class="w-10 h-10 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl sm:text-2xl shadow-sm flex-shrink-0">
                    <i class="ph-fill ph-sun"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="text-xl sm:text-3xl font-black text-slate-800 leading-none">{{ $this->stats['today'] }}</h3>
                    <p class="text-[10px] sm:text-sm font-bold text-slate-500 mt-1 leading-none">Kelas Hari Ini</p>
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
                <h2 class="text-2xl font-black text-slate-800">Daftar Jadwal</h2>
                <p class="text-slate-500 font-medium">Semua jadwal pelajaran terdaftar.</p>
            </div>
            <button wire:click="openCreateModal"
                class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-violet-500/40 transition-all duration-300">
                <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                <span>Buat Jadwal</span>
            </button>
        </div>

        <!-- Filters -->
        <div class="flex flex-col xl:flex-row gap-4 mb-6">
            <div class="relative flex-1">
                <i
                    class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-violet-500 text-lg"></i>
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari mapel, tutor, atau siswa..."
                    class="w-full pl-11 pr-4 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 placeholder-slate-400">
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 w-full xl:w-auto">
                <div class="relative w-full">
                    <select wire:model.live="dayFilter"
                        class="w-full pl-4 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                        <option value="">Semua Hari</option>
                        @foreach($days as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <i
                        class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>
                <div class="relative w-full">
                    <select wire:model.live="tutorFilter"
                        class="w-full pl-4 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                        <option value="">Semua Tutor</option>
                        @foreach($tutors as $tutor)
                            <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                        @endforeach
                    </select>
                    <i
                        class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>
                <div class="relative w-full">
                    <select wire:model.live="studentFilter"
                        class="w-full pl-4 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                        <option value="">Semua Siswa</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                    <i
                        class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>
                <div class="relative w-full">
                    <select wire:model.live="isActiveFilter"
                        class="w-full pl-4 pr-10 py-3 bg-white/50 border border-white focus:bg-white focus:ring-2 focus:ring-violet-400 rounded-xl transition-all font-semibold text-slate-700 appearance-none cursor-pointer">
                        <option value="">Status</option>
                        <option value="1">Aktif</option>
                        <option value="0">Non-Aktif</option>
                    </select>
                    <i
                        class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <!-- Table (Visible on Desktop, hidden on Mobile) -->
        <div class="hidden md:block overflow-x-auto rounded-3xl border border-white/60 bg-white/30 backdrop-blur-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-violet-50/50 border-b border-violet-100/50 text-violet-900 uppercase text-xs font-bold tracking-wider">
                        <th class="px-6 py-4 rounded-tl-3xl">Waktu & Hari</th>
                        <th class="px-6 py-4">Mata Pelajaran</th>
                        <th class="px-6 py-4">Partisipan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 rounded-tr-3xl text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-violet-50/50">
                    @forelse($schedules as $schedule)
                        <tr class="hover:bg-white/60 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex flex-col items-center justify-center shadow-sm">
                                        <span
                                            class="text-[9px] font-black uppercase tracking-wider leading-none">{{ strtoupper(substr($days[$schedule->day_of_week] ?? '', 0, 3)) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-800">{{ $days[$schedule->day_of_week] ?? '-' }}
                                        </div>
                                        <div class="text-xs font-semibold text-slate-500 flex items-center gap-1">
                                            <i class="ph-fill ph-clock text-violet-500"></i>
                                            {{ substr($schedule->time_start, 0, 5) }} -
                                            {{ substr($schedule->time_end, 0, 5) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-700">{{ $schedule->subject->name ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1.5">
                                    <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                        <i class="ph-fill ph-chalkboard-teacher text-indigo-400 text-sm"></i>
                                        <span>{{ $schedule->tutor->name ?? '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs font-semibold text-slate-600">
                                        <i class="ph-fill ph-student text-fuchsia-400 text-sm"></i>
                                        <span>{{ $schedule->student->name ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($schedule->is_active)
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100/50">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        AKTIF
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold border border-slate-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        NON-AKTIF
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="openEditModal({{ $schedule->id }})"
                                        class="w-8 h-8 rounded-full bg-violet-50 text-violet-600 hover:bg-violet-500 hover:text-white transition-all flex items-center justify-center shadow-sm hover:shadow-violet-500/30 group/btn"
                                        title="Edit">
                                        <i
                                            class="ph-bold ph-pencil-simple transition-transform group-hover/btn:rotate-12"></i>
                                    </button>
                                    <button wire:click="openDeleteModal({{ $schedule->id }})"
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
                                    <i class="ph-duotone ph-calendar-x text-3xl text-slate-400"></i>
                                </div>
                                <p class="font-bold text-slate-600">Jadwal tidak ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card List View (Visible on Mobile, hidden on Desktop) -->
        <div class="md:hidden space-y-4">
            @forelse($schedules as $schedule)
                <div class="group relative bg-white/50 border border-white/60 hover:bg-white/80 transition-all duration-300 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex flex-col items-center justify-center shadow-sm">
                                <span class="text-[9px] font-black uppercase tracking-wider leading-none">{{ strtoupper(substr($days[$schedule->day_of_week] ?? '', 0, 3)) }}</span>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 text-sm">{{ $days[$schedule->day_of_week] ?? '-' }}</div>
                                <div class="text-xs font-semibold text-slate-500 flex items-center gap-1 mt-0.5">
                                    <i class="ph-fill ph-clock text-violet-500"></i>
                                    {{ substr($schedule->time_start, 0, 5) }} - {{ substr($schedule->time_end, 0, 5) }}
                                </div>
                            </div>
                        </div>
                        
                        @if($schedule->is_active)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100/50">
                                AKTIF
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold border border-slate-200">
                                NON-AKTIF
                            </span>
                        @endif
                    </div>
                    
                    <div class="h-px bg-slate-100/70 my-2"></div>
                    
                    <div class="flex justify-between items-center gap-4">
                        <div class="space-y-1">
                            <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Mata Pelajaran</div>
                            <div class="text-sm font-bold text-slate-700">{{ $schedule->subject->name ?? '-' }}</div>
                        </div>
                        <div class="space-y-1 text-right">
                            <div class="text-[10px] font-semibold text-slate-400 uppercase tracking-wide">Partisipan</div>
                            <div class="text-xs font-bold text-slate-700 flex items-center gap-1 justify-end">
                                <i class="ph-fill ph-chalkboard-teacher text-indigo-400"></i>
                                <span>{{ $schedule->tutor->name ?? '-' }}</span>
                            </div>
                            <div class="text-xs font-bold text-slate-700 flex items-center gap-1 justify-end mt-0.5">
                                <i class="ph-fill ph-student text-fuchsia-400"></i>
                                <span>{{ $schedule->student->name ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h-px bg-slate-100/70 my-2"></div>
                    
                    <div class="flex justify-end gap-2">
                        <button wire:click="openEditModal({{ $schedule->id }})"
                            class="w-9 h-9 rounded-lg bg-violet-50 text-violet-600 hover:bg-violet-500 hover:text-white transition-all flex items-center justify-center shadow-sm"
                            title="Edit">
                            <i class="ph-bold ph-pencil-simple text-sm"></i>
                        </button>
                        <button wire:click="openDeleteModal({{ $schedule->id }})"
                            class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center shadow-sm"
                            title="Hapus">
                            <i class="ph-bold ph-trash text-sm"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-500 bg-white/50 border border-white/60 rounded-2xl">
                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ph-duotone ph-calendar-x text-3xl text-slate-400"></i>
                    </div>
                    <p class="font-bold text-slate-600">Jadwal tidak ditemukan</p>
                </div>
            @endforelse
        </div>

        @if($schedules->hasPages())
            <div class="mt-6">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>

    <!-- Create/Edit Modal -->
    <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition
        class="fixed inset-0 z-50 flex items-center justify-center px-4 py-6" style="display: none;">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="show = false"></div>
        <div
            class="relative bg-white/90 backdrop-blur-2xl border border-white/50 shadow-2xl rounded-[2.5rem] w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col animate-modal-pop">
            <!-- Header -->
            <div
                class="flex items-center justify-between p-6 border-b border-slate-100 bg-white/50 backdrop-blur-md z-10">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-600 flex items-center justify-center text-white shadow-lg shadow-violet-500/20">
                        <i class="ph-fill ph-calendar-plus text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">
                            {{ $editingId ? 'Edit Jadwal' : 'Buat Jadwal' }}</h3>
                    </div>
                </div>
                <button wire:click="closeModal"
                    class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 hover:bg-rose-100 hover:text-rose-600 transition-all flex items-center justify-center">
                    <i class="ph-bold ph-x text-lg"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 md:p-8">
                <form wire:submit.prevent="save" class="space-y-8">
                    <!-- Main Info -->
                    <div class="space-y-4">
                        <h4 class="flex items-center gap-2 text-sm font-bold text-violet-600 uppercase tracking-wider">
                            <i class="ph-fill ph-identification-card text-lg"></i> Detail Kelas
                        </h4>
                        <div
                            class="bg-white/50 rounded-[2rem] p-6 border border-white/60 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Tutor
                                    Pengajar <span class="text-rose-500">*</span></label>
                                <select wire:model="tutor_id"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-violet-400 focus:ring-4 focus:ring-violet-100 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                                    <option value="">Pilih Tutor</option>
                                    @foreach($tutors as $tutor)
                                        <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                                    @endforeach
                                </select>
                                @error('tutor_id') <span
                                class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Siswa
                                    <span class="text-rose-500">*</span></label>
                                <select wire:model="student_id"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-violet-400 focus:ring-4 focus:ring-violet-100 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                                    <option value="">Pilih Siswa</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                                @error('student_id') <span
                                class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Mata
                                    Pelajaran <span class="text-rose-500">*</span></label>
                                <select wire:model="subject_id"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-violet-400 focus:ring-4 focus:ring-violet-100 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                                    <option value="">Pilih Mapel</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select>
                                @error('subject_id') <span
                                class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Time Info -->
                    <div class="space-y-4">
                        <h4 class="flex items-center gap-2 text-sm font-bold text-fuchsia-600 uppercase tracking-wider">
                            <i class="ph-fill ph-clock text-lg"></i> Waktu & Tanggal
                        </h4>
                        <div
                            class="bg-white/50 rounded-[2rem] p-6 border border-white/60 grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Hari
                                    <span class="text-rose-500">*</span></label>
                                <select wire:model="day_of_week"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-fuchsia-400 focus:ring-4 focus:ring-fuchsia-100 rounded-xl transition-all font-semibold text-slate-700 cursor-pointer">
                                    <option value="">Pilih Hari</option>
                                    @foreach($days as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('day_of_week') <span
                                class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Jam
                                    Mulai <span class="text-rose-500">*</span></label>
                                <input type="time" wire:model="time_start"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-fuchsia-400 focus:ring-4 focus:ring-fuchsia-100 rounded-xl transition-all font-semibold text-slate-700">
                                @error('time_start') <span
                                class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Jam
                                    Selesai <span class="text-rose-500">*</span></label>
                                <input type="time" wire:model="time_end"
                                    class="w-full px-5 py-3 bg-white/70 border border-slate-200 focus:border-fuchsia-400 focus:ring-4 focus:ring-fuchsia-100 rounded-xl transition-all font-semibold text-slate-700">
                                @error('time_end') <span
                                class="text-xs text-rose-500 font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Status Checkbox -->
                    <div class="bg-white/50 rounded-[2rem] p-6 border border-white/60">
                        <label class="flex items-center gap-3 cursor-pointer group select-none">
                            <div class="relative">
                                <input type="checkbox" wire:model="is_active" class="peer sr-only">
                                <div
                                    class="w-14 h-8 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-violet-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-7 after:w-7 after:transition-all peer-checked:bg-violet-500">
                                </div>
                            </div>
                            <span class="font-bold text-slate-700 group-hover:text-violet-600 transition-colors">Jadwal
                                Aktif</span>
                        </label>
                    </div>

                    <!-- Footer Action -->
                    <div class="pt-6 border-t border-slate-200 flex justify-end gap-3">
                        <button type="button" wire:click="closeModal"
                            class="px-6 py-3 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-all">Batal</button>
                        <button type="submit" wire:loading.attr="disabled"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 transition-all flex items-center gap-2">
                            <span wire:loading.remove>{{ $editingId ? 'Simpan Perubahan' : 'Buat Jadwal' }}</span>
                            <span wire:loading><i class="ph-bold ph-spinner animate-spin"></i> Menyimpan...</span>
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
            <h3 class="text-2xl font-black text-slate-800 mb-2">Hapus Jadwal?</h3>
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