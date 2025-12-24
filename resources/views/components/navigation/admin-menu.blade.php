@php
    $currentRoute = request()->route()->getName() ?? '';
    // Mapping route to active state prefix if needed, or exact match logic
    $menuItems = [
        ['icon' => 'chart-bar', 'label' => 'Dashboard', 'route' => 'admin.dashboard'],
        ['icon' => 'users', 'label' => 'Siswa', 'route' => 'admin.students.index'],
        ['icon' => 'graduation-cap', 'label' => 'Tutor', 'route' => 'admin.tutors.index'],
        ['icon' => 'calendar', 'label' => 'Jadwal', 'route' => 'admin.schedules.index'],
        ['icon' => 'book-open', 'label' => 'Materi', 'route' => 'admin.materials.index'],
        ['icon' => 'clipboard-text', 'label' => 'Absensi', 'route' => 'admin.attendances.index'],
        ['icon' => 'article', 'label' => 'Jurnal', 'route' => 'admin.journals.index'],
        ['icon' => 'stack', 'label' => 'Jenjang', 'route' => 'admin.class-levels.index'],
        ['icon' => 'bookmark', 'label' => 'Mapel', 'route' => 'admin.subjects.index'],
        ['icon' => 'newspaper', 'label' => 'Artikel', 'route' => 'admin.posts.index'],
        ['icon' => 'chat-circle-text', 'label' => 'Testimoni', 'route' => 'filament.admin.resources.testimonials.testimonial-resource.index'],
        ['icon' => 'images', 'label' => 'Dokumentasi', 'route' => 'filament.admin.resources.documentations.documentation-resource.index'],
        ['icon' => 'gear', 'label' => 'Pengaturan', 'route' => 'admin.settings'],
    ];
@endphp

@foreach($menuItems as $item)
    @php
        // Simple active check: if current route starts with the item route base (removing .index for resource routes)
        $routeBase = str_replace('.index', '', $item['route']);
        $isActive = ($item['route'] !== '#' && str_starts_with($currentRoute, $routeBase));
    @endphp
    <a href="{{ $item['route'] === '#' ? '#' : route($item['route']) }}"
        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-300 {{ $isActive ? 'bg-gradient-to-r from-sky-600 to-blue-600 text-white shadow-lg shadow-sky-500/20' : 'text-slate-500 hover:bg-slate-50 hover:text-sky-600' }}">
        <i
            class="ph ph-{{ $item['icon'] }} text-lg {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-sky-600' }}"></i>
        {{ $item['label'] }}
    </a>
@endforeach