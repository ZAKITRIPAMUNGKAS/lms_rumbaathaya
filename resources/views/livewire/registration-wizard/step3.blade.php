<x-glass-card class="p-6 md:p-8" :noAnimation="true">
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-xl bg-brand-orange/10 flex items-center justify-center">
                <i class="ph ph-camera text-brand-orange text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Upload Foto</h2>
                <p class="text-gray-600 text-sm mt-0.5">Upload foto terbaru Anda</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        @if($photoPreview)
            <div class="relative">
                <img
                    src="{{ $photoPreview }}"
                    alt="Preview"
                    class="w-full max-w-md mx-auto rounded-2xl shadow-lg"
                />
                <button
                    wire:click="removePhoto"
                    class="absolute top-4 right-4 w-10 h-10 rounded-full bg-red-500 text-white flex items-center justify-center shadow-lg hover:bg-red-600 transition-colors"
                >
                    <i class="ph ph-x text-lg"></i>
                </button>
            </div>
        @else
            <label
                for="photo-upload"
                class="block p-10 border-2 border-dashed border-gray-300 rounded-2xl text-center cursor-pointer hover:border-brand-orange hover:bg-orange-50/50 transition-all duration-200 bg-gray-50/50"
            >
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-brand-orange/10 flex items-center justify-center">
                    <i class="ph ph-cloud-arrow-up text-4xl text-brand-orange"></i>
                </div>
                <p class="text-gray-700 font-semibold mb-2 text-base">Klik atau drag foto ke sini</p>
                <p class="text-sm text-gray-500">Format: JPG, PNG (Maks. 5MB)</p>
                <input
                    id="photo-upload"
                    type="file"
                    accept="image/*"
                    wire:model="photo"
                    class="hidden"
                />
            </label>
        @endif
    </div>

    @error('photo')
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

