<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-amber-600 to-amber-900">
            Isi Absensi Siswa
        </h1>
        <p class="text-gray-500 mt-1">Lengkapi data pertemuan hari ini</p>
    </div>

    <!-- Student Info Card -->
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-start gap-4">
        <div
            class="h-12 w-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 text-xl font-bold">
            {{ substr($schedule->student->name, 0, 1) }}
        </div>
        <div>
            <h3 class="font-bold text-gray-800 text-lg">{{ $schedule->student->name }}</h3>
            <div class="text-sm text-gray-500 space-y-1">
                <p><i class="ph ph-graduation-cap mr-1"></i> {{ $schedule->student->classLevel->name }}</p>
                <p><i class="ph ph-book-open mr-1"></i> {{ $schedule->subject->name }}</p>
                <p><i class="ph ph-clock mr-1"></i> {{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }} -
                    {{ \Carbon\Carbon::parse($schedule->time_end)->format('H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Attendance Form -->
    <form wire:submit.prevent="save"
        class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 space-y-6 relative overflow-hidden">
        <!-- Decoration -->
        <div
            class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 rounded-full bg-amber-50 blur-2xl opacity-50 pointer-events-none">
        </div>

        <!-- Status -->
        <div class="space-y-3">
            <label class="block text-sm font-semibold text-gray-700">Status Kehadiran</label>
            <div class="grid grid-cols-3 gap-3">
                <label class="cursor-pointer relative">
                    <input type="radio" value="present" wire:model="status" class="peer sr-only">
                    <div
                        class="p-3 text-center rounded-xl border-2 border-transparent bg-gray-50 text-gray-500 hover:bg-emerald-50 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all">
                        <i class="ph-bold ph-check-circle text-xl mb-1 block"></i>
                        <span class="text-sm font-medium">Hadir</span>
                    </div>
                </label>
                <label class="cursor-pointer relative">
                    <input type="radio" value="permission" wire:model="status" class="peer sr-only">
                    <div
                        class="p-3 text-center rounded-xl border-2 border-transparent bg-gray-50 text-gray-500 hover:bg-blue-50 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:text-blue-700 transition-all">
                        <i class="ph-bold ph-info text-xl mb-1 block"></i>
                        <span class="text-sm font-medium">Izin</span>
                    </div>
                </label>
                <label class="cursor-pointer relative">
                    <input type="radio" value="absent" wire:model="status" class="peer sr-only">
                    <div
                        class="p-3 text-center rounded-xl border-2 border-transparent bg-gray-50 text-gray-500 hover:bg-red-50 peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:text-red-700 transition-all">
                        <i class="ph-bold ph-x-circle text-xl mb-1 block"></i>
                        <span class="text-sm font-medium">Alpha</span>
                    </div>
                </label>
            </div>
            @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Topic Taught -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Materi yang Diajarkan <span
                    class="text-red-500">*</span></label>
            <x-input wire:model="topic_taught" placeholder="Contoh: Bab 1 - Aljabar Dasar" />
            @error('topic_taught') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Progress Note -->
        <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">Catatan Perkembangan Siswa</label>
            <textarea wire:model="student_progress_note" rows="3"
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 placeholder-gray-400 transition-colors"
                placeholder="Bagaimana pemahaman siswa terhadap materi hari ini?"></textarea>
            @error('student_progress_note') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-4 flex items-center justify-end gap-3">
            <a href="{{ route('tutor.schedules.index') }}"
                class="px-5 py-2.5 text-gray-500 hover:text-gray-700 font-medium transition-colors">
                Batal
            </a>
            <button type="submit"
                class="flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                <i class="ph-bold ph-floppy-disk"></i>
                Simpan Data
            </button>
        </div>
    </form>
</div>