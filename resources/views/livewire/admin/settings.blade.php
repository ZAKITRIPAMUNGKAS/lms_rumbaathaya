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

    <!-- Hero Section -->
    <div
        class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-violet-600 to-fuchsia-600 p-8 sm:p-12 text-white shadow-2xl shadow-violet-500/20 group">
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
                    Profil Admin
                </h1>
                <p class="text-violet-100 font-medium max-w-2xl text-sm sm:text-lg leading-relaxed mx-auto md:mx-0">
                    Atur informasi pribadi dan keamanan akun admin disini.
                </p>
            </div>

            <div class="relative group/avatar shrink-0">
                <div
                    class="w-32 h-32 md:w-40 md:h-40 rounded-full p-1.5 bg-gradient-to-br from-white/50 to-white/20 backdrop-blur-md border border-white/30 shadow-[0_0_40px_rgba(255,255,255,0.3)] hover:scale-105 transition-transform duration-300">
                    <div class="w-full h-full rounded-full overflow-hidden border-4 border-white/50 bg-white relative">
                        @if ($photo)
                            <div class="w-full h-full bg-cover bg-center"
                                style="background-image: url('{{ $photo->temporaryUrl() }}')"></div>
                        @elseif (Auth::user()->profile_photo_url)
                            <img src="{{ Auth::user()->profile_photo_url }}" class="w-full h-full object-cover">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-violet-400 to-fuchsia-500 flex items-center justify-center text-4xl font-black text-white">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                </div>
                <label for="photo-upload"
                    class="absolute bottom-2 right-2 w-10 h-10 md:w-12 md:h-12 bg-fuchsia-500 hover:bg-fuchsia-400 text-white rounded-full flex items-center justify-center shadow-lg cursor-pointer transition-all hover:scale-110 hover:rotate-12 border-4 border-white/20 z-20">
                    <i class="ph-bold ph-camera text-lg md:text-xl"></i>
                </label>
                <input type="file" id="photo-upload" wire:model="photo" class="hidden">
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar -->
        <div class="space-y-6">
            <div
                class="bg-white/40 p-1.5 rounded-[1.5rem] backdrop-blur-md border border-white/40 shadow-sm flex flex-col gap-1 sticky top-8">
                <button @click="activeTab = 'profile'"
                    :class="activeTab === 'profile' ? 'bg-white shadow-md text-violet-600' : 'text-slate-500 hover:text-violet-500 hover:bg-white/30'"
                    class="flex items-center gap-3 px-5 py-3.5 rounded-2xl font-bold transition-all duration-300 w-full text-left">
                    <i class="ph-duotone ph-user-circle text-xl"
                        :class="activeTab === 'profile' ? 'text-violet-600' : 'text-slate-400'"></i>
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

        <!-- Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Form -->
            <div x-show="activeTab === 'profile'" x-transition
                class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-violet-500/10 rounded-[2.5rem] p-8 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-violet-100/50 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none">
                </div>

                <h3 class="text-xl font-black text-slate-800 mb-6 relative z-10">Edit Profil</h3>

                <form wire:submit.prevent="updateProfile" class="space-y-6 relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Nama Lengkap</label>
                            <input type="text" wire:model="name"
                                class="w-full px-5 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-400/20 focus:border-violet-400 transition-all font-semibold text-slate-700">
                            @error('name') <span
                            class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Email</label>
                            <input type="email" wire:model="email"
                                class="w-full px-5 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-400/20 focus:border-violet-400 transition-all font-semibold text-slate-700">
                            @error('email') <span
                            class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">No. Telepon</label>
                            <input type="text" wire:model="phone_number"
                                class="w-full px-5 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-violet-400/20 focus:border-violet-400 transition-all font-semibold text-slate-700">
                            @error('phone_number') <span
                            class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                        @if (session()->has('success'))
                            <div
                                class="flex items-center gap-2 text-emerald-600 text-sm font-bold bg-emerald-50 px-4 py-2 rounded-xl">
                                <i class="ph-bold ph-check-circle"></i> {{ session('success') }}
                            </div>
                        @else
                            <div></div>
                        @endif
                        <button type="submit"
                            class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Form -->
            <div x-show="activeTab === 'security'" style="display: none;" x-transition
                class="bg-white/70 backdrop-blur-xl border border-white/60 shadow-xl shadow-pink-500/10 rounded-[2.5rem] p-8 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-pink-50/50 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none">
                </div>

                <h3 class="text-xl font-black text-slate-800 mb-6 relative z-10">Ubah Password</h3>

                <form wire:submit.prevent="updatePassword" class="space-y-6 relative z-10">
                    <div class="group">
                        <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Password Saat Ini</label>
                        <input type="password" wire:model="current_password"
                            class="w-full px-5 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-pink-400/20 focus:border-pink-400 transition-all font-semibold text-slate-700">
                        @error('current_password') <span
                        class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Password Baru</label>
                            <input type="password" wire:model="new_password"
                                class="w-full px-5 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-pink-400/20 focus:border-pink-400 transition-all font-semibold text-slate-700">
                            @error('new_password') <span
                            class="text-xs text-rose-500 font-bold mt-1 ml-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="group">
                            <label class="block text-slate-600 font-bold text-sm mb-2 ml-1">Konfirmasi Password</label>
                            <input type="password" wire:model="new_password_confirmation"
                                class="w-full px-5 py-3 bg-white/50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-pink-400/20 focus:border-pink-400 transition-all font-semibold text-slate-700">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                        @if (session()->has('success_password'))
                            <div
                                class="flex items-center gap-2 text-emerald-600 text-sm font-bold bg-emerald-50 px-4 py-2 rounded-xl">
                                <i class="ph-bold ph-check-circle"></i> {{ session('success_password') }}
                            </div>
                        @else
                            <div></div>
                        @endif
                        <button type="submit"
                            class="px-8 py-2.5 rounded-xl bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold shadow-lg shadow-pink-500/30 hover:shadow-xl hover:-translate-y-1 transition-all">
                            Ubah Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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