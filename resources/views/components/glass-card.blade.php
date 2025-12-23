@props(['hover' => true, 'className' => '', 'onClick' => null, 'noAnimation' => false])

@if($noAnimation)
    <div {{ $attributes->merge([
            'class' => 'relative isolate overflow-hidden bg-white/70 backdrop-blur-xl border border-white/60 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-500 ' . ($hover ? 'cursor-pointer group hover:-translate-y-1' : '') . ' ' . $className,
            'onclick' => $onClick,
        ]) }}>
@else
        <div {{ $attributes->merge([
            'class' => 'relative isolate overflow-hidden bg-white/70 backdrop-blur-xl border border-white/60 rounded-[2rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-500 ' . ($hover ? 'cursor-pointer group hover:-translate-y-1' : '') . ' ' . $className,
            'x-data' => '{ loaded: true }',
            'x-init' => 'loaded = true',
            'x-transition:enter' => 'transition ease-out duration-600',
            'x-transition:enter-start' => 'opacity-0 translate-y-5',
            'x-transition:enter-end' => 'opacity-100 translate-y-0',
            'onclick' => $onClick,
        ]) }}>
    @endif
        <!-- Gradient overlay on hover - EXACT from Next.js GlassCard -->
        @if($hover)
            <div
                class="absolute inset-0 bg-gradient-to-br from-white/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none z-0">
            </div>
        @endif
        <div class="relative z-10">
            {{ $slot }}
        </div>
    </div>