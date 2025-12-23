<div class="relative min-h-screen space-y-8 p-4 sm:p-8 overflow-hidden font-sans" x-data="{ activeTab: 'profile' }">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-violet-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-fuchsia-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-amber-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000">
        </div>
    </div>

    <!-- Hero Section (Gradient Header) -->
    <div
        class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-violet-600 to-fuchsia-600 p-8 sm:p-12 text-white shadow-2xl shadow-violet-500/20 group">
        <!-- Background Decor -->
        <div
            class="absolute right-0 bottom-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mb-16 group-hover:bg-white/20 transition-all duration-500">
        </div>
        <div
            class="absolute top-0 left-0 w-40 h-40 bg-amber-400/30 rounded-full blur-2xl -ml-10 -mt-10 group-hover:scale-110 transition-transform duration-500">
        </div>

        <div
            class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8 text-center md:text-left">
            <div class="flex-1">
                <div
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/20 text-xs font-bold text-violet-100 mb-6 shadow-sm cursor-default">
                    <i class="ph-fill ph-gear-six text-lg"></i>
                    <span>Pengaturan Akun</span>
                </div>
                <h1
                    class="text-3xl sm:text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight drop-shadow-sm">
                    Profil Saya
                </h1>
                <p class="text-violet-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                    Atur informasi pribadi dan keamanan akunmu disini. Klik foto di samping untuk menggantinya! ✨
                </p>
            </div>

            <!-- Profile Photo Uploader (Main Visual) -->
            <div class="relative group/avatar shrink-0">
                <div
                    class="w-32 h-32 md:w-40 md:h-40 rounded-full p-1.5 bg-gradient-to-br from-white/50 to-white/20 backdrop-blur-md border border-white/30 shadow-[0_0_40px_rgba(255,255,255,0.3)] hover:scale-105 transition-transform duration-300">
                    <div class="w-full h-full rounded-full overflow-hidden border-4 border-white/50 bg-white relative">
                        @if ($photo)
                            <div class="w-full h-full bg-cover bg-center"
                                style="background-image: url('{{ $photo->temporaryUrl() }}')"></div>
                        @elseif (Auth::user()->avatar_url)
                            <img src="{{ Auth::user()->avatar_url }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-violet-400 to-fuchsia-500 flex items-center justify-center text-4xl font-black text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Floating Upload Button -->
                <label for="photo-upload"
                    class="absolute bottom-2 right-2 w-10 h-10 md:w-12 md:h-12 bg-fuchsia-500 hover:bg-fuchsia-400 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer transition-all hover:scale-110 hover:rotate-12 border-4 border-white/20 z-20">
                    <i class="ph-bold ph-camera text-lg md:text-xl"></i>
                </label>
                <input type="file" id="photo-upload" wire:model="photo" class="hidden">

                <!-- Validation Error for Photo -->
                @error('photo')
                    <div
                        class="absolute -bottom-12 left-1/2 -translate-x-1/2 w-48 bg-rose-100 text-rose-600 text-xs font-bold px-3 py-2 rounded-xl border border-rose-200 shadow-lg text-center animate-bounce z-30">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Navigation & Quick Info (1/3) -->
        <div class="space-y-6">
            <!-- Quick Stats Card (Replacing the old Profile Card) -->
            <div
                class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-indigo-500/10 rounded-[2.5rem] p-6 relative overflow-hidden group">
                <!-- Decor -->
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-violet-100/50 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
                </div>

                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-6">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                            <i class="ph-fill ph-identification-card text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">Info Akun</h3>
                            <p class="text-xs text-slate-500 font-medium">Data terdaftar</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div
                            class="flex items-center justify-between p-3 rounded-xl bg-white/50 border border-white/50">
                            <span class="text-xs font-bold text-slate-500 uppercase">Nama</span>
                            <span
                                class="text-sm font-bold text-slate-700 truncate max-w-[150px]">{{ Auth::user()->name }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-3 rounded-xl bg-white/50 border border-white/50">
                            <span class="text-xs font-bold text-slate-500 uppercase">Email</span>
                            <span
                                class="text-sm font-bold text-slate-700 truncate max-w-[150px]">{{ Auth::user()->email }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between p-3 rounded-xl bg-emerald-50/50 border border-emerald-100/50">
                            <span class="text-xs font-bold text-emerald-600 uppercase">Status</span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation (Pills) -->
            <div
                class="bg-white/40 p-1.5 rounded-[1.5rem] backdrop-blur-md border border-white/40 shadow-sm flex flex-col gap-1 sticky top-8">
                <button @click="activeTab = 'profile'"
                    :class="activeTab === 'profile' ? 'bg-white shadow-md text-indigo-600' : 'text-slate-500 hover:text-indigo-500 hover:bg-white/30'"
                    class="flex items-center gap-3 px-5 py-3.5 rounded-2xl font-bold transition-all duration-300 w-full text-left">
                    <i class="ph-duotone ph-user-circle text-xl"
                        :class="activeTab === 'profile' ? 'text-indigo-600' : 'text-slate-400'"></i>
                    Biodata Diri
                    <i class="ph-bold ph-caret-right ml-auto text-sm opacity-50"></i>
                </button>
                <button @click="activeTab = 'security'"
                    :class="activeTab === 'security' ? 'bg-white shadow-md text-pink-600' : 'text-slate-500 hover:text-pink-600 hover:bg-white/30'"
                    class="flex items-center gap-3 px-5 py-3.5 rounded-2xl font-bold transition-all duration-300 w-full text-left">
                    <i class="ph-duotone ph-lock-key text-xl"
                        :class="activeTab === 'security' ? 'text-pink-600' : 'text-slate-400'"></i>
                    Keamanan Akun
                    <i class="ph-bold ph-caret-right ml-auto text-sm opacity-50"></i>
                </button>
            </div>
        </div>

        <!-- Right Column: Forms (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Form -->
            <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-indigo-500/10 rounded-[2.5rem] p-8 relative overflow-hidden">

                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-indigo-50/50 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none">
                </div>

                <div class="relative z-10 flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Edit Profil</h3>
                        <p class="text-slate-500 text-sm font-medium mt-1">Perbarui informasi pribadimu.</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="ph-fill ph-pencil-simple text-xl"></i>
                    </div>
                </div>

                <form wire:submit.prevent="updateProfile" class="space-y-6 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Nama Lengkap</label>
                            <div class="relative">
                                <i
                                    class="ph-duotone ph-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-violet-500 transition-colors text-lg"></i>
                                <input type="text" wire:model="name"
                                    class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-400/20 focus:border-violet-400 transition-all font-semibold text-slate-700 placeholder:text-slate-400">
                            </div>
                            @error('name') <span
                            class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Nama Panggilan -->
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Nama Panggilan</label>
                            <div class="relative">
                                <i
                                    class="ph-duotone ph-smiley absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-violet-500 transition-colors text-lg"></i>
                                <input type="text" wire:model="nickname"
                                    class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-400/20 focus:border-violet-400 transition-all font-semibold text-slate-700 placeholder:text-slate-400">
                            </div>
                            @error('nickname') <span
                            class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="group">
                        <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Email Address</label>
                        <div class="relative">
                            <i
                                class="ph-duotone ph-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-violet-500 transition-colors text-lg"></i>
                            <input type="email" wire:model="email"
                                class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-400/20 focus:border-violet-400 transition-all font-semibold text-slate-700 placeholder:text-slate-400">
                        </div>
                        @error('email') <span
                        class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- WhatsApp -->
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Nomor WhatsApp</label>
                            <div class="relative">
                                <i
                                    class="ph-duotone ph-whatsapp-logo absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors text-lg"></i>
                                <input type="text" wire:model="whatsapp_number" placeholder="08..."
                                    class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-400/20 focus:border-violet-400 transition-all font-semibold text-slate-700 placeholder:text-slate-400">
                            </div>
                            @error('whatsapp_number') <span
                            class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Parent Phone -->
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">No. Telp Orang Tua</label>
                            <div class="relative">
                                <i
                                    class="ph-duotone ph-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors text-lg"></i>
                                <input type="text" wire:model="parent_phone" placeholder="08..."
                                    class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-400/20 focus:border-violet-400 transition-all font-semibold text-slate-700 placeholder:text-slate-400">
                            </div>
                            @error('parent_phone') <span
                            class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="group">
                        <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Alamat Rumah</label>
                        <div class="relative">
                            <i
                                class="ph-duotone ph-map-pin absolute left-4 top-4 text-slate-400 group-focus-within:text-rose-500 transition-colors text-lg"></i>
                            <textarea wire:model="address" rows="3" placeholder="Tulis alamat lengkapmu disini..."
                                class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-400/20 focus:border-violet-400 transition-all font-semibold text-slate-700 placeholder:text-slate-400 resize-none"></textarea>
                        </div>
                        @error('address') <span
                        class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                        @if (session()->has('success'))
                            <div
                                class="flex items-center gap-2 text-emerald-600 text-sm font-bold bg-emerald-50 px-4 py-2 rounded-xl animate-bounce-short">
                                <i class="ph-bold ph-check-circle"></i> {{ session('success') }}
                            </div>
                        @else
                            <div></div>
                        @endif

                        <div class="flex items-center gap-3">
                            <button type="button"
                                class="px-6 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-colors text-sm">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled"
                                class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-violet-500/40 transition-all duration-300 text-sm flex items-center gap-2">
                                <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                                <span wire:loading wire:target="updateProfile" class="flex items-center gap-2"><i
                                        class="ph-bold ph-spinner animate-spin"></i> Menyimpan...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Security Form -->
            <div x-show="activeTab === 'security'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                style="display: none;"
                class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-pink-500/10 rounded-[2.5rem] p-8 relative overflow-hidden">

                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-pink-50/50 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none">
                </div>

                <div class="relative z-10 flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Ubah Password</h3>
                        <p class="text-slate-500 text-sm font-medium mt-1">Pastikan passwordmu kuat dan aman.</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center text-pink-600">
                        <i class="ph-fill ph-lock-key text-xl"></i>
                    </div>
                </div>

                <form wire:submit.prevent="updatePassword" class="space-y-6 relative z-10">
                    <!-- Current Password -->
                    <div class="group">
                        <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Password Saat Ini</label>
                        <div class="relative">
                            <i
                                class="ph-duotone ph-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-pink-500 transition-colors text-lg"></i>
                            <input type="password" wire:model="current_password"
                                class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-pink-400/20 focus:border-pink-400 transition-all font-semibold text-slate-700 placeholder:text-slate-400">
                        </div>
                        @error('current_password') <span
                        class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Password Baru</label>
                            <div class="relative">
                                <i
                                    class="ph-duotone ph-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-pink-500 transition-colors text-lg"></i>
                                <input type="password" wire:model="new_password"
                                    class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-pink-400/20 focus:border-pink-400 transition-all font-semibold text-slate-700 placeholder:text-slate-400">
                            </div>
                            @error('new_password') <span
                            class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Konfirmasi Password</label>
                            <div class="relative">
                                <i
                                    class="ph-duotone ph-check-circle absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-pink-500 transition-colors text-lg"></i>
                                <input type="password" wire:model="new_password_confirmation"
                                    class="w-full pl-12 pr-4 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-pink-400/20 focus:border-pink-400 transition-all font-semibold text-slate-700 placeholder:text-slate-400">
                            </div>
                        </div>
                    </div>

                    <!-- Security Toggles (Visual Only for now based on request "E. Toggles & Checkbox") -->
                    <div class="pt-4 border-t border-slate-100">
                        <label class="flex items-center justify-between cursor-pointer group">
                            <div>
                                <h4 class="text-sm font-bold text-slate-700">Login Alert</h4>
                                <p class="text-xs text-slate-500">Dapatkan notifikasi jika ada login baru.</p>
                            </div>
                            <div class="relative">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-pink-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-pink-500 peer-checked:to-rose-500">
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                        @if (session()->has('success_password'))
                            <div
                                class="flex items-center gap-2 text-emerald-600 text-sm font-bold bg-emerald-50 px-4 py-2 rounded-xl animate-bounce-short">
                                <i class="ph-bold ph-check-circle"></i> {{ session('success_password') }}
                            </div>
                        @else
                            <div></div>
                        @endif

                        <div class="flex items-center gap-3">
                            <button type="button"
                                class="px-6 py-2.5 rounded-xl bg-slate-100 text-slate-600 font-bold hover:bg-slate-200 transition-colors text-sm">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled"
                                class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold shadow-lg shadow-pink-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-pink-500/40 transition-all duration-300 text-sm flex items-center gap-2">
                                <span wire:loading.remove wire:target="updatePassword">Ubah Password</span>
                                <span wire:loading wire:target="updatePassword" class="flex items-center gap-2"><i
                                        class="ph-bold ph-spinner animate-spin"></i> Menyimpan...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Blob Animation Style -->
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</div>