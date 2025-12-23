@extends('layouts.tutor')

@section('title', 'Kuis & Ujian')

@section('content')
    <div class="space-y-8 p-4 sm:p-8 h-full flex flex-col">
        <!-- Hero Section -->
        <div class="relative overflow-hidden rounded-[2.5rem] bg-cyan-600 p-8 text-white shadow-xl shadow-cyan-600/20">
            <div class="absolute inset-0 bg-gradient-to-br from-cyan-600 via-sky-600 to-blue-600"></div>
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16"></div>
            <div class="absolute top-0 left-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -ml-10 -mt-10"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-cyan-100 mb-4">
                        <i class="ph ph-exam text-yellow-300 text-lg"></i>
                        <span>Tutor Dashboard</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Kuis & Ujian</h1>
                    <p class="text-cyan-100 font-medium max-w-lg text-sm sm:text-base">
                        Kelola evaluasi pembelajaran siswa (Segera Hadir).
                    </p>
                </div>
            </div>
        </div>

        <!-- Coming Soon Content -->
        <div class="flex-1 flex items-center justify-center">
            <x-glass-card class="max-w-xl w-full p-12 text-center bg-white/60 relative overflow-hidden group">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                </div>

                <div class="relative z-10">
                    <div
                        class="w-24 h-24 rounded-3xl bg-cyan-50 mx-auto mb-6 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform duration-300">
                        <i class="ph-duotone ph-rocket-launch text-5xl text-cyan-600"></i>
                    </div>

                    <h2 class="text-3xl font-black text-slate-800 mb-3 tracking-tight">Segera Hadir!</h2>
                    <p class="text-slate-500 leading-relaxed mb-8">
                        Fitur <span class="font-bold text-cyan-600">Kuis & Ujian</span> sedang dalam tahap pengembangan.
                        Anda akan segera dapat membuat soal, mengatur jadwal ujian, dan melihat hasil evaluasi siswa secara
                        otomatis.
                    </p>

                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 text-slate-500 font-bold text-sm">
                        <i class="ph-bold ph-hourglass"></i>
                        <span>Dalam Pengembangan</span>
                    </div>
                </div>
            </x-glass-card>
        </div>
    </div>
@endsection