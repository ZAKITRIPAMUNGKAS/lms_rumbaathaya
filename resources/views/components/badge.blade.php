@props(['variant' => 'default', 'size' => 'md'])

@php
$baseClasses = 'inline-flex items-center font-semibold rounded-full';
$variants = [
    'default' => 'bg-slate-100 text-slate-700',
    'success' => 'bg-emerald-100 text-emerald-700',
    'warning' => 'bg-amber-100 text-amber-700',
    'danger' => 'bg-red-100 text-red-700',
    'info' => 'bg-blue-100 text-blue-700',
];
$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-3 py-1 text-sm',
    'lg' => 'px-4 py-1.5 text-base',
];
@endphp

<span {{ $attributes->merge(['class' => $baseClasses . ' ' . $variants[$variant] . ' ' . $sizes[$size]]) }}>
    {{ $slot }}
</span>

