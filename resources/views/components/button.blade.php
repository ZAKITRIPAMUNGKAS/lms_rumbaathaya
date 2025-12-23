@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button'])

@php
$baseClasses = 'inline-flex items-center justify-center font-semibold rounded-full transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
$variants = [
    'primary' => 'bg-gradient-to-r from-indigo-600 to-violet-600 text-white hover:from-indigo-700 hover:to-violet-700 focus:ring-indigo-500 shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40',
    'secondary' => 'bg-white/70 backdrop-blur-xl border border-white/60 text-slate-700 hover:bg-white/90 hover:border-white/80 focus:ring-slate-500 shadow-sm',
    'danger' => 'bg-gradient-to-r from-red-600 to-rose-600 text-white hover:from-red-700 hover:to-rose-700 focus:ring-red-500 shadow-lg shadow-red-500/30 hover:shadow-xl hover:shadow-red-500/40',
    'ghost' => 'text-slate-600 hover:bg-slate-100/50 focus:ring-slate-500',
];
$sizes = [
    'sm' => 'px-4 py-2 text-sm',
    'md' => 'px-6 py-3 text-base',
    'lg' => 'px-8 py-4 text-lg',
];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
    {{ $slot }}
</button>

