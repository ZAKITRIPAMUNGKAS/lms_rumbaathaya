<x-glass-card class="p-6 md:p-8" :noAnimation="true">
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-xl bg-brand-orange/10 flex items-center justify-center">
                <i class="ph ph-graduation-cap text-brand-orange text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Pilih Program</h2>
                <p class="text-gray-600 text-sm mt-0.5">Pilih program yang ingin Anda ikuti</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        @foreach($this::PROGRAMS as $id => $program)
            <button wire:click="$set('selectedProgram', '{{ $id }}')"
                class="p-5 rounded-xl border-2 cursor-pointer transition-all duration-200 bg-white text-left {{ $selectedProgram === $id ? 'border-brand-orange bg-orange-50 shadow-lg shadow-orange-500/20' : 'border-gray-200 hover:border-orange-200 hover:bg-orange-50/50' }} hover:scale-[1.02] hover:-translate-y-0.5">
                <div class="flex items-center gap-4">
                    <div class="text-3xl transition-transform {{ $selectedProgram === $id ? 'scale-110' : '' }}">
                        {{ $program['icon'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-base text-slate-900 truncate">{{ $program['name'] }}</h3>
                        <p class="text-xs text-gray-600 mt-0.5">{{ $program['description'] }}</p>
                    </div>
                    @if($selectedProgram === $id)
                        <div
                            class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-orange to-orange-600 flex items-center justify-center text-white shadow-md flex-shrink-0">
                            <i class="ph ph-check text-sm font-bold"></i>
                        </div>
                    @endif
                </div>
            </button>
        @endforeach
    </div>

    @error('selectedProgram')
        <p class="mt-4 text-sm text-red-600 flex items-center gap-1">
            <i class="ph ph-warning text-base"></i>
            {{ $message }}
        </p>
    @enderror

    <div class="mt-8 flex justify-between">
        <x-premium-button wire:click="previousStep" variant="secondary" size="lg">
            Kembali
        </x-premium-button>
        <x-premium-button wire:click="nextStep" variant="orange" size="lg">
            <span>Lanjutkan</span>
            <i class="ph ph-arrow-right text-lg"></i>
        </x-premium-button>
    </div>
</x-glass-card>