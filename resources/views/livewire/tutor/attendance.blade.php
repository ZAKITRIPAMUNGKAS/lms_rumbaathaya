<div class="space-y-8 p-4 sm:p-8">
    <!-- Hero Section -->
    <div
        class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-violet-500 via-purple-600 to-fuchsia-600 p-6 sm:p-8 text-white shadow-xl shadow-violet-600/20">
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-pink-500/20 rounded-full blur-2xl -ml-10 -mt-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-violet-100 mb-4">
                    <i class="ph ph-calendar-check text-yellow-300 text-sm"></i>
                    <span>{{ now()->format('l, d F Y') }}</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight leading-tight">
                    Absensi Hari Ini ✓
                </h1>
                <p class="text-violet-100 font-medium max-w-md text-sm sm:text-base">
                    Isi absensi untuk <span class="text-white font-bold">{{ $schedules->count() }} kelas</span> hari ini
                </p>
            </div>
            <div
                class="hidden md:flex w-32 h-32 bg-white/10 backdrop-blur-md rounded-full border border-white/20 items-center justify-center shadow-inner text-5xl">
                📝
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session()->has('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3 shadow-sm">
            <i class="ph-fill ph-check-circle text-2xl text-emerald-600"></i>
            <p class="text-emerald-800 font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Schedule List -->
    @if($schedules->isEmpty())
        <div class="bg-white/80 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-12 text-center shadow-sm">
            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-violet-50 flex items-center justify-center">
                <i class="ph ph-calendar-x text-5xl text-violet-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Jadwal Hari Ini</h3>
            <p class="text-gray-500">Anda tidak memiliki jadwal mengajar untuk hari ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($schedules as $schedule)
                @php
                    $hasAttendance = $schedule->has_attendance_today;
                    $isSelected = $selectedSchedule === $schedule->id;
                @endphp

                <div wire:key="schedule-{{ $schedule->id }}"
                    class="relative bg-white/80 backdrop-blur-xl border {{ $hasAttendance ? 'border-emerald-200 bg-emerald-50/50' : ($isSelected ? 'border-violet-300 bg-violet-50/30' : 'border-white/60') }} rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all">

                    <!-- Status Strip -->
                    <div
                        class="absolute left-0 top-0 bottom-0 w-1.5 {{ $hasAttendance ? 'bg-gradient-to-b from-emerald-400 to-emerald-600' : 'bg-gradient-to-b from-violet-400 to-violet-600' }}">
                    </div>

                    <div class="p-6 pl-8">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $schedule->student->name }}</h3>
                                <div class="flex items-center gap-2 text-sm">
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-gray-100 text-gray-700 font-medium border border-gray-200">
                                        <i class="ph ph-graduation-cap"></i>
                                        {{ $schedule->student->classLevel->name }}
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-violet-100 text-violet-700 font-medium border border-violet-200">
                                        <i class="ph ph-book-open"></i>
                                        {{ $schedule->subject->name }}
                                    </span>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-2 text-violet-700 font-bold bg-violet-50 px-3 py-1.5 rounded-xl border border-violet-200 text-sm">
                                <i class="ph-bold ph-clock"></i>
                                <span>{{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }}</span>
                            </div>
                        </div>

                        @if($hasAttendance)
                            <!-- Already Attended -->
                            <div class="bg-emerald-100 border border-emerald-200 rounded-xl p-4 flex items-center gap-3">
                                <i class="ph-fill ph-check-circle text-3xl text-emerald-600"></i>
                                <div>
                                    <p class="font-bold text-emerald-800">Absensi Sudah Diisi</p>
                                    <p class="text-sm text-emerald-600">Terima kasih telah mengisi absensi</p>
                                </div>
                            </div>
                        @elseif($isSelected)
                            <!-- Attendance Form -->
                            <form wire:submit.prevent="saveAttendance" class="space-y-4">
                                <!-- Status -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Status Kehadiran</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <label class="cursor-pointer">
                                            <input type="radio" value="present" wire:model="status" class="peer sr-only">
                                            <div
                                                class="p-2 text-center rounded-lg border-2 border-transparent bg-gray-50 text-gray-500 hover:bg-emerald-50 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all text-xs font-medium">
                                                <i class="ph-bold ph-check-circle text-lg block mb-1"></i>
                                                Hadir
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" value="permission" wire:model="status" class="peer sr-only">
                                            <div
                                                class="p-2 text-center rounded-lg border-2 border-transparent bg-gray-50 text-gray-500 hover:bg-blue-50 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 transition-all text-xs font-medium">
                                                <i class="ph-bold ph-info text-lg block mb-1"></i>
                                                Izin
                                            </div>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" value="absent" wire:model="status" class="peer sr-only">
                                            <div
                                                class="p-2 text-center rounded-lg border-2 border-transparent bg-gray-50 text-gray-500 hover:bg-red-50 peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-700 transition-all text-xs font-medium">
                                                <i class="ph-bold ph-x-circle text-lg block mb-1"></i>
                                                Alpha
                                            </div>
                                        </label>
                                    </div>
                                    @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Topic -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Materi Diajarkan <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" wire:model="topic_taught"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500 text-sm"
                                        placeholder="Contoh: Bab 1 - Aljabar Dasar">
                                    @error('topic_taught') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Notes -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700">Catatan Perkembangan</label>
                                    <textarea wire:model="student_progress_note" rows="2"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-violet-500 focus:ring-violet-500 text-sm"
                                        placeholder="Bagaimana pemahaman siswa?"></textarea>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2 pt-2">
                                    <button type="button" wire:click="cancelForm"
                                        class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-colors text-sm">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="flex-1 px-4 py-2 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg transition-all text-sm">
                                        <i class="ph-bold ph-floppy-disk mr-1"></i>
                                        Simpan
                                    </button>
                                </div>
                            </form>
                        @else
                            <!-- Show Form Button -->
                            <button wire:click="selectSchedule({{ $schedule->id }})"
                                class="w-full px-4 py-3 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                                <i class="ph-bold ph-check-square-offset mr-2"></i>
                                Isi Absensi
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>