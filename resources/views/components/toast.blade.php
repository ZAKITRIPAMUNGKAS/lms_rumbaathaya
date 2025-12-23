@props([
    'type' => 'info', // success, error, warning, info
    'message' => '',
    'duration' => 3000,
])

@php
    $configs = [
        'success' => [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'bg' => 'bg-emerald-50/90',
            'border' => 'border-emerald-200',
            'text' => 'text-emerald-800',
            'iconColor' => 'text-emerald-500',
            'progress' => 'bg-emerald-500',
            'glow' => 'shadow-emerald-500/10',
            'label' => 'Berhasil',
        ],
        'error' => [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'bg' => 'bg-rose-50/90',
            'border' => 'border-rose-200',
            'text' => 'text-rose-800',
            'iconColor' => 'text-rose-500',
            'progress' => 'bg-rose-500',
            'glow' => 'shadow-rose-500/10',
            'label' => 'Error',
        ],
        'warning' => [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
            'bg' => 'bg-amber-50/90',
            'border' => 'border-amber-200',
            'text' => 'text-amber-800',
            'iconColor' => 'text-amber-500',
            'progress' => 'bg-amber-500',
            'glow' => 'shadow-amber-500/10',
            'label' => 'Peringatan',
        ],
        'info' => [
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'bg' => 'bg-indigo-50/90',
            'border' => 'border-indigo-200',
            'text' => 'text-indigo-800',
            'iconColor' => 'text-indigo-500',
            'progress' => 'bg-indigo-500',
            'glow' => 'shadow-indigo-500/10',
            'label' => 'Informasi',
        ],
    ];
    $config = $configs[$type] ?? $configs['info'];
@endphp

<div 
    x-data="{ 
        show: true,
        init() {
            setTimeout(() => {
                this.show = false;
            }, {{ $duration }});
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-2 scale-95"
    class="relative w-full"
>
    <div class="relative w-full overflow-hidden rounded-2xl border {{ $config['border'] }} {{ $config['bg'] }} backdrop-blur-xl p-4 shadow-xl {{ $config['glow'] }}">
        <!-- Background Texture/Noise -->
        <div class="absolute inset-0 opacity-[0.02] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 400 400\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E'); background-size: 200px 200px;"></div>

        <div class="flex gap-4 relative z-10">
            <!-- Icon Box -->
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-white/80 flex items-center justify-center shadow-sm {{ $config['iconColor'] }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! $config['icon'] !!}
                </svg>
            </div>

            <!-- Content -->
            <div class="flex-1 pt-0.5">
                <h4 class="font-bold text-sm {{ $config['text'] }} capitalize">
                    {{ $config['label'] }}
                </h4>
                <p class="text-sm text-slate-600 mt-1 leading-relaxed font-medium">
                    {{ $message }}
                </p>
            </div>

            <!-- Close Button -->
            <button 
                @click="show = false"
                class="flex-shrink-0 text-slate-400 hover:text-slate-600 transition-colors p-1"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Progress Bar -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-200/50">
            <div 
                x-data="{ width: '100%' }"
                x-init="
                    setTimeout(() => {
                        width = '0%';
                    }, 50);
                "
                class="h-full {{ $config['progress'] }} transition-all duration-[{{ $duration }}ms] ease-linear"
                :style="'width: ' + width"
            ></div>
        </div>
    </div>
</div>

