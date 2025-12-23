@extends('layouts.tutor')

@section('title', 'Jurnal Mengajar')

@section('content')
    @php
        $tutor = auth()->user();
        $journals = \App\Models\BimbelJournal::where('tutor_id', $tutor->id)
            ->with(['schedule.student', 'schedule.subject'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(12);
    @endphp

    <div class="space-y-8 p-4 sm:p-8">
        <!-- Hero Section -->
        <div class="relative overflow-hidden rounded-[2.5rem] bg-indigo-600 p-8 text-white shadow-xl shadow-indigo-600/20">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-blue-600 to-sky-600"></div>
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
            <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-indigo-100 mb-4">
                        <i class="ph ph-notebook text-yellow-300 text-lg"></i>
                        <span>Tutor Dashboard</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Jurnal Mengajar</h1>
                    <p class="text-indigo-100 font-medium max-w-lg text-sm sm:text-base">
                        Catat aktivitas dan perkembangan siswa setiap pertemuan.
                    </p>
                </div>

                <button
                    class="group flex items-center gap-2 px-6 py-3 rounded-xl bg-white text-indigo-600 font-bold shadow-lg shadow-black/5 hover:bg-indigo-50 hover:-translate-y-1 transition-all duration-300">
                    <i class="ph-bold ph-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
                    <span>Jurnal Baru</span>
                </button>
            </div>
        </div>

        @if($journals->count() > 0)
            <!-- Journals List -->
            <div class="space-y-4">
                @foreach($journals as $journal)
                    <x-glass-card class="p-6 hover:scale-[1.01] transition-transform duration-300 bg-white/60">
                        <div class="flex flex-col sm:flex-row items-start justify-between gap-4">
                            <div class="flex-1 w-full">
                                <div class="flex items-start gap-4 mb-4">
                                    <div
                                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 flex items-center justify-center text-white shrink-0 shadow-lg shadow-indigo-500/20">
                                        <i class="ph-bold ph-student text-2xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <h3 class="text-xl font-bold text-slate-900">
                                                {{ $journal->schedule && $journal->schedule->student ? $journal->schedule->student->name : 'Siswa' }}
                                            </h3>
                                            @if($journal->schedule && $journal->schedule->subject)
                                                <span
                                                    class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-600 border border-indigo-100">
                                                    {{ $journal->schedule->subject->name }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-slate-500">
                                            <div class="flex items-center gap-1.5">
                                                <i class="ph-bold ph-calendar-blank text-indigo-400"></i>
                                                <span>{{ $journal->date->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <i class="ph-bold ph-clock text-indigo-400"></i>
                                                <span>{{ $journal->time }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($journal->material)
                                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 mb-4">
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Materi</p>
                                        <p class="text-slate-700 leading-relaxed font-medium">{{ $journal->material }}</p>
                                    </div>
                                @endif

                                @if($journal->documentation_path)
                                    <a href="{{ asset('storage/' . $journal->documentation_path) }}" target="_blank"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-50 text-blue-600 text-sm font-bold hover:bg-blue-100 transition-colors">
                                        <i class="ph-bold ph-image"></i>
                                        Lihat Dokumentasi
                                    </a>
                                @endif
                            </div>

                            <div
                                class="flex sm:flex-col gap-2 w-full sm:w-auto mt-4 sm:mt-0 pt-4 sm:pt-0 border-t sm:border-t-0 border-slate-100">
                                <button
                                    class="flex-1 sm:flex-none px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/30 transition-all">
                                    Edit
                                </button>
                                <button
                                    class="flex-1 sm:flex-none px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-bold text-sm hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </x-glass-card>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($journals->hasPages())
                <div class="mt-6">
                    {{ $journals->links() }}
                </div>
            @endif
        @else
            <div class="py-12">
                <x-empty-state icon="ph-notebook" title="Jurnal Kosong"
                    description="Belum ada jurnal mengajar yang tercatat. Klik tombol 'Jurnal Baru' untuk memulai." />
            </div>
        @endif
    </div>
@endsection