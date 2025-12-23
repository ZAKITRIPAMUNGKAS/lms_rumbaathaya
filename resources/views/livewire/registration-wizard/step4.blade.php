<x-glass-card class="p-6 md:p-8" :noAnimation="true">
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-xl bg-brand-orange/10 flex items-center justify-center">
                <i class="ph ph-clipboard-text text-brand-orange text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Review & Submit</h2>
                <p class="text-gray-600 text-sm mt-0.5">Periksa kembali data Anda sebelum submit</p>
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <!-- Biodata Review -->
        <div class="bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl p-5 border border-orange-100">
            <div class="flex items-center gap-2 mb-4">
                <i class="ph ph-user text-brand-orange text-lg"></i>
                <h3 class="font-bold text-base text-slate-900">Biodata</h3>
            </div>
            <div class="space-y-2.5 text-gray-700 text-sm">
                <div class="flex items-start gap-3">
                    <span class="font-semibold text-slate-900 min-w-[120px]">Nama:</span>
                    <span>{{ $name }}</span>
                </div>
                <div class="flex items-start gap-3">
                    <span class="font-semibold text-slate-900 min-w-[120px]">Panggilan:</span>
                    <span>{{ $nickname }}</span>
                </div>
                <div class="flex items-start gap-3">
                    <span class="font-semibold text-slate-900 min-w-[120px]">Tanggal Lahir:</span>
                    <span>{{ \Carbon\Carbon::parse($dateOfBirth)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
                <div class="flex items-start gap-3">
                    <span class="font-semibold text-slate-900 min-w-[120px]">Email:</span>
                    <span>{{ $email }}</span>
                </div>
                @if($whatsapp_number)
                    <div class="flex items-start gap-3">
                        <span class="font-semibold text-slate-900 min-w-[120px]">WhatsApp:</span>
                        <span>{{ $whatsapp_number }}</span>
                    </div>
                @endif
                <div class="flex items-start gap-3">
                    <span class="font-semibold text-slate-900 min-w-[120px]">Orang Tua/Wali:</span>
                    <span>{{ $parent_phone }}</span>
                </div>
            </div>
        </div>

        <!-- Program Review -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100">
            <div class="flex items-center gap-2 mb-4">
                <i class="ph ph-graduation-cap text-blue-600 text-lg"></i>
                <h3 class="font-bold text-base text-slate-900">Program</h3>
            </div>
            <p class="text-gray-700 font-medium text-sm">
                {{ $this::PROGRAMS[$selectedProgram]['name'] ?? $selectedProgram }}
            </p>
            <p class="text-xs text-gray-600 mt-1">
                {{ $this::PROGRAMS[$selectedProgram]['description'] ?? '' }}
            </p>
        </div>

        <!-- Photo Review -->
        @if($photoPreview)
            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-5 border border-purple-100">
                <div class="flex items-center gap-2 mb-4">
                    <i class="ph ph-camera text-purple-600 text-lg"></i>
                    <h3 class="font-bold text-base text-slate-900">Foto</h3>
                </div>
                <img src="{{ $photoPreview }}" alt="Preview" class="w-32 h-32 rounded-xl object-cover shadow-md" />
            </div>
        @endif
    </div>

    @if($submitError)
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm flex items-center gap-2">
            <i class="ph ph-warning text-lg"></i>
            <span>{{ $submitError }}</span>
        </div>
    @endif

    <div class="mt-8 flex justify-between">
        <x-premium-button wire:click.prevent="previousStep" variant="secondary" size="lg">
            Kembali
        </x-premium-button>
        <x-premium-button wire:click.prevent="submit" variant="orange" size="lg" :disabled="$isSubmitting">
            @if($isSubmitting)
                <div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                <span>Mengirim...</span>
            @else
                <i class="ph ph-check text-lg"></i>
                <span>Submit Pendaftaran</span>
            @endif
        </x-premium-button>
    </div>
</x-glass-card>