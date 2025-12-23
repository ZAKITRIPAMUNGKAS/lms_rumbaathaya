@php
    $currentRoute = request()->route()->getName() ?? '';
    $menuItems = [
        ['icon' => 'chart-bar', 'label' => 'Dashboard', 'route' => 'student.dashboard'],
        ['icon' => 'book-open', 'label' => 'Materi Belajar', 'route' => 'student.materials.index'],
        ['icon' => 'calendar', 'label' => 'Jadwal Kelas', 'route' => 'student.schedules.index'],
        ['icon' => 'trophy', 'label' => 'Prestasi', 'route' => 'student.achievements.index'],
        ['icon' => 'quiz', 'label' => 'Quiz & Ujian', 'route' => 'student.quiz.index'],
        ['icon' => 'settings', 'label' => 'Pengaturan', 'route' => 'student.settings.index'],
    ];
@endphp

@foreach($menuItems as $item)
    @php
        $isActive = str_starts_with($currentRoute, str_replace('.index', '', $item['route']));
    @endphp
    <a href="{{ route($item['route']) }}"
        class="group w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all duration-300 {{ $isActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }}">
        @if($item['icon'] === 'chart-bar')
            <i
                class="ph ph-squares-four text-xl {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
        @elseif($item['icon'] === 'book-open')
            <i
                class="ph ph-book-open-text text-xl {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
        @elseif($item['icon'] === 'calendar')
            <i
                class="ph ph-calendar-check text-xl {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
        @elseif($item['icon'] === 'trophy')
            <i class="ph ph-trophy text-xl {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
        @elseif($item['icon'] === 'settings')
            <i class="ph ph-gear text-xl {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
        @elseif($item['icon'] === 'quiz')
            <i
                class="ph ph-pencil-circle text-xl {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
        @endif
        {{ $item['label'] }}
    </a>
@endforeach