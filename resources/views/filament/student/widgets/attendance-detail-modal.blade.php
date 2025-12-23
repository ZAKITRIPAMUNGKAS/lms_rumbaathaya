<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Tanggal</h3>
            <p class="text-gray-900">{{ $attendance->date->format('d M Y') }}</p>
        </div>
        
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Status</h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                @if($attendance->status === 'present') bg-green-100 text-green-800
                @elseif($attendance->status === 'absent') bg-red-100 text-red-800
                @elseif($attendance->status === 'permission') bg-yellow-100 text-yellow-800
                @else bg-gray-100 text-gray-800
                @endif">
                @if($attendance->status === 'present') Hadir
                @elseif($attendance->status === 'absent') Tidak Hadir
                @elseif($attendance->status === 'permission') Izin
                @else {{ $attendance->status }}
                @endif
            </span>
        </div>
    </div>

    <div>
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Tutor</h3>
        <p class="text-gray-900">{{ $attendance->tutor->name ?? '-' }}</p>
    </div>

    <div>
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Materi yang Diajarkan</h3>
        <p class="text-gray-900 whitespace-pre-wrap">{{ $attendance->topic_taught ?? '-' }}</p>
    </div>

    @if($attendance->student_progress_note)
    <div>
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Catatan Perkembangan</h3>
        <p class="text-gray-900 whitespace-pre-wrap">{{ $attendance->student_progress_note }}</p>
    </div>
    @endif

    @if($attendance->photo_evidence_path)
    <div>
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Foto Bukti</h3>
        <div class="mt-2">
            <img 
                src="{{ Storage::disk('public')->url($attendance->photo_evidence_path) }}" 
                alt="Foto Bukti" 
                class="max-w-full h-auto rounded-lg shadow-md"
                style="max-height: 400px;"
            />
        </div>
    </div>
    @endif
</div>
