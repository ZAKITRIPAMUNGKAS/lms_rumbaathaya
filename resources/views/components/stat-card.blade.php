@props([
    'title' => '',
    'value' => '',
    'icon' => null,
    'gradient' => 'from-indigo-500 to-purple-500',
    'delay' => 0,
    'change' => null,
    'trend' => 'stable' // 'up', 'down', 'stable'
])

@php
    $trendColors = [
        'up' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
        'down' => 'bg-rose-50 text-rose-600 border-rose-100',
        'stable' => 'bg-slate-100 text-slate-500 border-slate-200',
    ];
    $trendColor = $trendColors[$trend] ?? $trendColors['stable'];
@endphp

<div 
    x-data="{ loaded: false }"
    x-init="setTimeout(() => loaded = true, {{ $delay }})"
    x-show="loaded"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-y-5"
    x-transition:enter-end="opacity-100 translate-y-0"
    class="group relative overflow-hidden bg-white/70 backdrop-blur-xl border border-white/50 rounded-2xl sm:rounded-[2rem] lg:rounded-3xl p-4 sm:p-5 lg:p-6 shadow-lg shadow-indigo-500/10 hover:shadow-xl hover:shadow-indigo-500/20 transition-all duration-500 hover:-translate-y-1 hover:scale-[1.02]"
>
    <!-- Animated decorative blob -->
    <div class="absolute -right-6 -top-6 w-32 h-32 bg-gradient-to-br {{ $gradient }} opacity-[0.08] rounded-full blur-2xl animate-blob"></div>
    
    <div class="flex justify-between items-start mb-4 relative z-10">
        @if($icon)
            <div class="p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl bg-gradient-to-br {{ $gradient }} text-white shadow-lg shadow-indigo-500/10 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                @if(is_string($icon))
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $icon !!}
                    </svg>
                @else
                    {!! $icon !!}
                @endif
            </div>
        @endif
        @if($change || $trend !== 'stable')
            <div class="flex items-center gap-1 text-[10px] font-bold px-2.5 py-1.5 rounded-full border {{ $trendColor }}">
                @if($trend === 'up')
                    <span class="text-xs">↑</span>
                @elseif($trend === 'down')
                    <span class="text-xs">↓</span>
                @endif
                {{ $change ?? ($trend === 'up' ? '+12%' : ($trend === 'down' ? '-5%' : 'Stable')) }}
            </div>
        @endif
    </div>
    
    <div class="relative z-10">
        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight mb-1">
            {{ $value }}
        </h3>
        <p class="text-xs sm:text-sm font-semibold text-slate-500 tracking-wide">
            {{ $title }}
        </p>
    </div>
</div>

