@props([
    'delay' => 0,
    'hover' => true,
    'noAnimation' => false,
])

@if($noAnimation)
    <div class="{{ $attributes->get('class') }}">
        {{ $slot }}
    </div>
@else
    <div x-data="{ 
        loaded: true,
        hovered: false
    }"
         x-intersect="loaded = true"
         x-show="loaded"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         :style="'transition-delay: {{ $delay }}s'"
         @if($hover)
         @mouseenter="hovered = true"
         @mouseleave="hovered = false"
         :class="hovered ? '-translate-y-2' : ''"
         @endif
         class="transition-all duration-200 {{ $attributes->get('class') }}">
        {{ $slot }}
    </div>
@endif

