@props([
    'badge' => null,
    'title' => '',
    'titleHighlight' => null,
    'description' => '',
])

<div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 pt-24 pb-32 overflow-hidden">
    <!-- Background Base -->
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
    
    <!-- Gradient Orbs -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-orange/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-blue-600/10 rounded-full blur-[100px] translate-y-1/3 -translate-x-1/3"></div>
    <div class="absolute top-1/2 left-1/2 w-[300px] h-[300px] bg-amber-500/5 rounded-full blur-[80px] -translate-x-1/2 -translate-y-1/2"></div>
    
    <!-- Pattern Overlay -->
    <div 
        class="absolute inset-0 opacity-[0.03]"
        style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 40px 40px;"
    ></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- Badge -->
        @if($badge)
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 backdrop-blur-md text-xs font-bold text-brand-orange mb-6">
                @if(isset($badge['icon']))
                    <i class="ph {{ $badge['icon'] }} text-sm"></i>
                @endif
                {{ $badge['text'] ?? '' }}
            </div>
        @endif
        
        <!-- Title -->
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 tracking-tight leading-tight">
            {{ $title }}
            @if($titleHighlight)
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-orange to-amber-500">
                    {{ $titleHighlight }}
                </span>
            @endif
        </h1>
        
        <!-- Description -->
        <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto leading-relaxed">
            {{ $description }}
        </p>

        <!-- Additional Content -->
        @if(isset($slot) && trim($slot))
            <div class="mt-10">
                {{ $slot }}
            </div>
        @endif
    </div>
</div>

