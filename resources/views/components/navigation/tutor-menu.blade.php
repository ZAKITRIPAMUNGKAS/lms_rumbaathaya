@php
    $currentRoute = request()->route()->getName() ?? '';
    // Mapping route to active state prefix if needed, or exact match logic
    $menuItems = [
        ['icon' => 'chart-bar', 'label' => 'Dashboard', 'route' => 'tutor.dashboard'],
        ['icon' => 'clipboard-text', 'label' => 'Absensi', 'route' => 'tutor.attendance.index'],
        ['icon' => 'upload-simple', 'label' => 'Materi', 'route' => 'tutor.materials.index'],
        ['icon' => 'calendar', 'label' => 'Jadwal', 'route' => 'tutor.schedules.index'],
        ['icon' => 'exam', 'label' => 'Kuis', 'route' => 'tutor.quiz.index'],
        ['icon' => 'notebook', 'label' => 'Jurnal', 'route' => 'tutor.journals.index'],
        ['icon' => 'file-text', 'label' => 'Laporan', 'route' => 'tutor.reports.index'],
        ['icon' => 'gear', 'label' => 'Pengaturan', 'route' => 'tutor.settings'],
    ];
@endphp

@foreach($menuItems as $item)
    @php
        // Simple active check: if current route starts with the item route base (removing .index for resource routes)
        $routeBase = str_replace('.index', '', $item['route']);
        $isActive = ($item['route'] !== '#' && str_starts_with($currentRoute, $routeBase));
    @endphp
    <a href="{{ $item['route'] === '#' ? '#' : route($item['route']) }}"
        class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-300 {{ $isActive ? 'bg-violet-600 text-white shadow-lg shadow-violet-500/30' : 'text-slate-500 hover:bg-violet-50 hover:text-violet-600' }}">
        <i class="ph ph-{{ $item['icon'] }} text-xl {{ $isActive ? 'text-white' : 'text-slate-400' }}"></i>
        {{ $item['label'] }}
    </a>
@endforeach