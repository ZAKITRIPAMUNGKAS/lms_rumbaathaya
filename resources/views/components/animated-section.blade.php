@props([
    'delay' => 0,
    'noAnimation' => false,
])

@if($noAnimation)
    <div class="{{ $attributes->get('class') }}">
        {{ $slot }}
    </div>
@else
    <div x-data="{ loaded: true }"
         x-intersect="loaded = true"
         x-show="loaded"
         x-transition:enter="transition ease-out duration-600"
         x-transition:enter-start="opacity-0 translate-y-8"
         x-transition:enter-end="opacity-100 translate-y-0"
         :style="'transition-delay: {{ $delay }}s'"
         class="{{ $attributes->get('class') }}">
        {{ $slot }}
    </div>
@endif

