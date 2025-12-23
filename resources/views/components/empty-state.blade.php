@props([
    'icon' => null,
    'title' => 'No data available',
    'description' => null,
    'action' => null,
])

<div 
    x-data="{ loaded: false }"
    x-init="setTimeout(() => loaded = true, 100)"
    x-show="loaded"
    x-transition:enter="transition ease-out duration-600"
    x-transition:enter-start="opacity-0 translate-y-5"
    x-transition:enter-end="opacity-100 translate-y-0"
    class="flex flex-col items-center justify-center py-20 px-6"
>
    <div class="relative mb-6">
        <!-- Dashed circle background -->
        <div class="absolute inset-0 w-24 h-24 border-2 border-dashed border-slate-300/50 rounded-full -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2"></div>
        
        <!-- Icon container -->
        <div class="relative w-16 h-16 rounded-full bg-slate-50/50 backdrop-blur-sm flex items-center justify-center">
            @if($icon)
                @if(is_string($icon))
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $icon !!}
                    </svg>
                @else
                    <div class="w-8 h-8 text-slate-400">
                        {!! $icon !!}
                    </div>
                @endif
            @else
                <!-- Default icon -->
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
            @endif
        </div>
    </div>
    
    <h3 class="text-lg font-bold text-slate-700 mb-2 tracking-tight">{{ $title }}</h3>
    @if($description)
        <p class="text-xs text-slate-500 text-center max-w-sm mb-6">{{ $description }}</p>
    @endif
    
    @if($action)
        <div class="mt-2">
            {!! $action !!}
        </div>
    @endif
</div>

