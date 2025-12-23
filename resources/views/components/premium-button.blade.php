@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'icon' => null])

@php
$baseClasses = 'inline-flex items-center justify-center gap-2 font-bold rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed relative overflow-hidden';
$variants = [
    'primary' => 'bg-gradient-to-r from-indigo-600 to-violet-600 text-white hover:from-indigo-700 hover:to-violet-700 focus:ring-indigo-500 shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 hover:scale-105 active:scale-95',
    'secondary' => 'bg-white/70 backdrop-blur-xl border border-white/60 text-slate-700 hover:bg-white/90 hover:border-white/80 focus:ring-slate-500 shadow-sm hover:scale-105 active:scale-95',
    'danger' => 'bg-gradient-to-r from-red-600 to-rose-600 text-white hover:from-red-700 hover:to-rose-700 focus:ring-red-500 shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40 hover:scale-105 active:scale-95',
    'ghost' => 'text-slate-600 hover:bg-slate-100/50 focus:ring-slate-500 hover:scale-105 active:scale-95',
    'orange' => 'bg-gradient-to-r from-orange-500 to-orange-600 text-white hover:from-orange-600 hover:to-orange-700 focus:ring-orange-500 shadow-lg shadow-orange-500/30 hover:shadow-xl hover:shadow-orange-500/40 hover:scale-105 active:scale-95',
];
$sizes = [
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
];
@endphp

<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size]]) }}
    x-data="{ ripple: false }"
    @click="ripple = true; setTimeout(() => ripple = false, 600)"
>
    <!-- Ripple effect -->
    <span 
        x-show="ripple"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-0"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-0"
        class="absolute inset-0 bg-white/30 rounded-full transform scale-0"
        style="animation: ripple 0.6s ease-out;"
    ></span>
    
    @if($icon)
        <span class="relative z-10">
            {!! $icon !!}
        </span>
    @endif
    <span class="relative z-10">
        {{ $slot }}
    </span>
</button>

<style>
@keyframes ripple {
    0% {
        transform: scale(0);
        opacity: 1;
    }
    100% {
        transform: scale(4);
        opacity: 0;
    }
}
</style>

