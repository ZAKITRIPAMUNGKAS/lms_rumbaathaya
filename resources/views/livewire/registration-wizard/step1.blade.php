<x-glass-card class="p-6 md:p-8" :noAnimation="true">
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-xl bg-brand-orange/10 flex items-center justify-center">
                <i class="ph ph-user text-brand-orange text-xl"></i>
            </div>
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900">Biodata</h2>
                <p class="text-gray-600 text-sm mt-0.5">Lengkapi informasi biodata Anda</p>
            </div>
        </div>
    </div>

    <div class="space-y-5">
        <!-- Nama Lengkap -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <x-premium-input type="text" wire:model.blur="name" placeholder="Masukkan nama lengkap"
                :error="$errors['name'][0] ?? null" icon='<i class="ph ph-user text-lg"></i>' />
        </div>

        <!-- Nama Panggilan -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Nama Panggilan <span class="text-red-500">*</span>
            </label>
            <x-premium-input type="text" wire:model.blur="nickname" placeholder="Masukkan nama panggilan"
                :error="$errors['nickname'][0] ?? null" icon='<i class="ph ph-smiley text-lg"></i>' />
        </div>

        <!-- Tanggal Lahir -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Tanggal Lahir <span class="text-red-500">*</span>
            </label>
            <x-premium-input type="date" wire:model.blur="dateOfBirth" :error="$errors['dateOfBirth'][0] ?? null"
                icon='<i class="ph ph-calendar text-lg"></i>' />
        </div>

        <!-- Email -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Email <span class="text-red-500">*</span>
            </label>
            <x-premium-input type="email" wire:model.blur="email" placeholder="nama@example.com"
                :error="$errors['email'][0] ?? null" icon='<i class="ph ph-envelope text-lg"></i>' />
        </div>

        <!-- Password -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Password <span class="text-red-500">*</span>
            </label>
            <x-premium-input type="password" wire:model.blur="password" placeholder="Minimal 8 karakter"
                :error="$errors['password'][0] ?? null" icon='<i class="ph ph-lock text-lg"></i>' />
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Konfirmasi Password <span class="text-red-500">*</span>
            </label>
            <x-premium-input type="password" wire:model.blur="password_confirmation" placeholder="Ulangi password"
                :error="$errors['password_confirmation'][0] ?? null" icon='<i class="ph ph-lock-key text-lg"></i>' />
        </div>

        <!-- Nomor WhatsApp (Opsional) -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Nomor WhatsApp <span class="text-gray-500 text-xs">(Opsional)</span>
            </label>
            <x-premium-input type="tel" wire:model.blur="whatsapp_number" placeholder="08xxxxxxxxxx"
                icon='<i class="ph ph-whatsapp-logo text-lg"></i>' />
        </div>

        <!-- Nomor Orang Tua/Wali -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">
                Nomor Orang Tua/Wali <span class="text-red-500">*</span>
            </label>
            <x-premium-input type="tel" wire:model.blur="parent_phone" placeholder="08xxxxxxxxxx"
                :error="$errors['parent_phone'][0] ?? null" icon='<i class="ph ph-phone text-lg"></i>' />
        </div>
    </div>

    <div class="mt-8 flex justify-end">
        <x-premium-button wire:click.prevent="nextStep" variant="orange" size="lg">
            <span>Lanjutkan</span>
            <i class="ph ph-arrow-right text-lg"></i>
        </x-premium-button>
    </div>
</x-glass-card>