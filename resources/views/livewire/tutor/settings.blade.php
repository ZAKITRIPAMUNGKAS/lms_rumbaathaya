<div class="space-y-8 p-4 sm:p-8">
    <!-- Hero Section -->
    <div class="relative overflow-hidden rounded-[2.5rem] bg-slate-800 p-8 text-white shadow-xl shadow-slate-800/20">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-700 to-slate-600"></div>
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mb-16"></div>
        <div class="absolute top-0 left-0 w-40 h-40 bg-white/5 rounded-full blur-2xl -ml-10 -mt-10"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-xs font-bold text-slate-200 mb-4">
                    <i class="ph ph-gear text-yellow-300 text-lg"></i>
                    <span>Tutor Dashboard</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-2 tracking-tight">Pengaturan Akun</h1>
                <p class="text-slate-300 font-medium max-w-lg text-sm sm:text-base">
                    Kelola informasi profil dan keamanan akun Anda.
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Profile Settings -->
        <x-glass-card class="p-6 sm:p-8 bg-white/60 relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-violet-100/50 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none">
            </div>

            <div class="flex items-center gap-4 mb-8">
                <div
                    class="w-12 h-12 rounded-2xl bg-violet-100 flex items-center justify-center text-violet-600 shadow-sm">
                    <i class="ph-bold ph-user-circle text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Profil Saya</h3>
                    <p class="text-sm text-slate-500 font-medium">Informasi pribadi Anda</p>
                </div>
            </div>

            <form wire:submit="updateProfile" class="space-y-5">
                <!-- Photo Upload -->
                <div
                    class="flex flex-col sm:flex-row items-center gap-6 p-4 rounded-2xl bg-white border border-slate-100 shadow-sm mb-6">
                    <div class="relative group cursor-pointer">
                        @if ($photo)
                            <img src="{{ $photo->temporaryUrl() }}"
                                class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                        @elseif (auth()->user()->avatar_url)
                            <img src="{{ auth()->user()->avatar_url }}"
                                class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md">
                        @else
                            <div
                                class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-slate-300 border-4 border-white shadow-md">
                                <i class="ph-bold ph-user text-4xl"></i>
                            </div>
                        @endif
                        <label for="photo"
                            class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer text-white font-bold text-xs backdrop-blur-sm">
                            Ubah Foto
                        </label>
                        <input type="file" id="photo" wire:model="photo" class="hidden">
                    </div>
                    <div class="text-center sm:text-left">
                        <h4 class="font-bold text-slate-700">Foto Profil</h4>
                        <p class="text-xs text-slate-500 mb-2">JPG, GIF atau PNG. Maks 1MB.</p>
                        @error('photo') <span class="text-red-500 text-xs font-bold block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Fields -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <x-input wire:model="name" type="text" class="w-full bg-white/80 backdrop-blur-sm" required
                            autofocus autocomplete="name" />
                        @error('name') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Email</label>
                        <x-input wire:model="email" type="email" class="w-full bg-white/80 backdrop-blur-sm" required
                            autocomplete="username" />
                        @error('email') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Nomor Telepon (WhatsApp)</label>
                        <x-input wire:model="phone_number" type="text" class="w-full bg-white/80 backdrop-blur-sm"
                            placeholder="Contoh: 08123456789" />
                        @error('phone_number') <span
                        class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit"
                        class="px-6 py-2.5 bg-violet-600 text-white font-bold rounded-xl shadow-lg shadow-violet-500/30 hover:bg-violet-700 hover:-translate-y-1 transition-all duration-300">
                        <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                        <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                    </button>

                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                            class="text-sm font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg flex items-center gap-2">
                            <i class="ph-bold ph-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </form>
        </x-glass-card>

        <!-- Security Settings -->
        <x-glass-card class="p-6 sm:p-8 bg-white/60 relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-rose-100/50 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none">
            </div>

            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-12 rounded-2xl bg-rose-100 flex items-center justify-center text-rose-600 shadow-sm">
                    <i class="ph-bold ph-shield-check text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-800">Keamanan</h3>
                    <p class="text-sm text-slate-500 font-medium">Update password akun Anda</p>
                </div>
            </div>

            <form wire:submit="updatePassword" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Password Saat Ini</label>
                    <x-input wire:model="current_password" type="password" class="w-full bg-white/80 backdrop-blur-sm"
                        required autocomplete="current-password" />
                    @error('current_password') <span
                    class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Password Baru</label>
                    <x-input wire:model="new_password" type="password" class="w-full bg-white/80 backdrop-blur-sm"
                        required autocomplete="new-password" />
                    @error('new_password') <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                    <x-input wire:model="new_password_confirmation" type="password"
                        class="w-full bg-white/80 backdrop-blur-sm" required autocomplete="new-password" />
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit"
                        class="px-6 py-2.5 bg-rose-600 text-white font-bold rounded-xl shadow-lg shadow-rose-500/30 hover:bg-rose-700 hover:-translate-y-1 transition-all duration-300">
                        <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                        <span wire:loading wire:target="updatePassword">Menyimpan...</span>
                    </button>

                    @if (session('success_password'))
                        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                            class="text-sm font-bold text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg flex items-center gap-2">
                            <i class="ph-bold ph-check-circle"></i>
                            {{ session('success_password') }}
                        </div>
                    @endif
                </div>
            </form>
        </x-glass-card>
    </div>
</div>