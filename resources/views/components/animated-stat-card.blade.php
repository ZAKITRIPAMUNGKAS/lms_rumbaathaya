@props([
    'title' => '',
    'value' => '',
    'icon' => null,
    'gradient' => 'from-indigo-500 to-purple-500',
    'delay' => 0,
    'change' => null,
    'trend' => 'stable', // 'up', 'down', 'stable'
    'color' => 'bg-indigo-600', // For progress bar
])

@php
    $trendColors = [
        'up' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
        'down' => 'bg-rose-50 text-rose-600 border-rose-100',
        'stable' => 'bg-slate-100 text-slate-500 border-slate-200',
    ];
    $trendColor = $trendColors[$trend] ?? $trendColors['stable'];
@endphp

<x-glass-card :hover="true" :className="$attributes->get('class', '')">
    <div class="p-6">
        <div class="flex justify-between items-start mb-4">
            @if($icon)
                <div class="p-3 rounded-2xl bg-gradient-to-br {{ $gradient }} text-white shadow-lg">
                    @if(is_string($icon))
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $icon !!}
                        </svg>
                    @else
                        {!! $icon !!}
                    @endif
                </div>
            @endif
            @if($change || $trend !== 'stable')
                <div class="flex items-center gap-1 text-xs font-bold px-2.5 py-1.5 rounded-full border {{ $trendColor }}">
                    @if($trend === 'up')
                        <span>↑</span>
                    @elseif($trend === 'down')
                        <span>↓</span>
                    @endif
                    {{ $change ?? ($trend === 'up' ? '+12%' : ($trend === 'down' ? '-5%' : 'Stable')) }}
                </div>
            @endif
        </div>
        
        <div>
            <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">
                {{ $value }}
            </h3>
            <p class="text-sm font-semibold text-slate-500 tracking-wide">
                {{ $title }}
            </p>
        </div>
    </div>
</x-glass-card>

