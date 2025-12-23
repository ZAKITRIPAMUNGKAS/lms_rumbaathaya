@props([
    'title' => '',
    'subtitle' => null,
    'highlight' => null,
    'action' => null,
    'className' => ''
])

<header 
    x-data="{ loaded: false }"
    x-init="setTimeout(() => loaded = true, 100)"
    x-show="loaded"
    x-transition:enter="transition ease-out duration-600"
    x-transition:enter-start="opacity-0 translate-y-5"
    x-transition:enter-end="opacity-100 translate-y-0"
    class="flex flex-col md:flex-row md:items-end justify-between gap-6 {{ $className }}"
>
    <div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-800 tracking-tight mb-2 sm:mb-3">
            {{ $title }}
            @if($highlight)
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-violet-600">
                    {{ $highlight }}
                </span>
            @endif
        </h1>
        @if($subtitle)
            <p class="text-sm sm:text-base md:text-lg text-slate-600 font-medium max-w-2xl">
                {{ $subtitle }}
            </p>
        @endif
    </div>
    @if($action)
        <div 
            x-data="{ loaded: false }"
            x-init="setTimeout(() => loaded = true, 200)"
            x-show="loaded"
            x-transition:enter="transition ease-out duration-400"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
        >
            {!! $action !!}
        </div>
    @endif
</header>

