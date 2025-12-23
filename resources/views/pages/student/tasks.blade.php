@extends('layouts.app')

@section('page-title', 'Tugas & Latihan')
@section('page-description', 'Lihat dan kerjakan tugas serta latihan Anda')

@section('content')
@php
    // For now, tasks are represented by materials that have assignments
    // In the future, this could be a separate Task/Assignment model
    $student = auth()->user()->student;
    $tasks = collect(); // Placeholder - will be implemented when Task model is created
@endphp

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Tugas & Latihan</h1>
            <p class="text-slate-600">Lihat dan kerjakan tugas serta latihan yang diberikan</p>
        </div>
        <div class="flex items-center gap-2">
            <select class="px-4 py-2 rounded-xl border border-slate-200 bg-white text-sm font-medium text-slate-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="all">Semua Tugas</option>
                <option value="pending">Belum Dikerjakan</option>
                <option value="completed">Selesai</option>
                <option value="overdue">Terlambat</option>
            </select>
        </div>
    </div>

    @if($tasks->count() > 0)
        <!-- Tasks List -->
        <div class="space-y-4">
            @foreach($tasks as $task)
                <x-glass-card class="p-6 hover:scale-[1.01] transition-transform duration-300">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white font-bold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-slate-900 mb-1">{{ $task->title ?? 'Tugas' }}</h3>
                                    <p class="text-sm text-slate-600">{{ $task->description ?? 'Deskripsi tugas' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 text-sm text-slate-600 mb-4">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Deadline: {{ $task->deadline ?? 'Tidak ada' }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>{{ $task->subject ?? 'Umum' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-lg text-xs font-bold {{ $task->status === 'completed' ? 'bg-green-100 text-green-700' : ($task->status === 'overdue' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $task->status === 'completed' ? 'Selesai' : ($task->status === 'overdue' ? 'Terlambat' : 'Belum Dikerjakan') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <button class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold text-sm hover:bg-indigo-700 transition-colors">
                                Kerjakan
                            </button>
                            @if($task->status === 'completed')
                                <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold text-sm hover:bg-slate-50 transition-colors">
                                    Lihat Hasil
                                </button>
                            @endif
                        </div>
                    </div>
                </x-glass-card>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <x-empty-state 
            icon="ph-clipboard-check"
            title="Belum Ada Tugas"
            description="Belum ada tugas atau latihan yang diberikan saat ini."
        />
    @endif
</div>
@endsection
