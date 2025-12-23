<nav x-data="{ 
    isOpen: false, 
    isProductsOpen: false, 
    isRegisterOpen: false
}"
    class="fixed top-0 left-0 right-0 w-full z-[100] bg-white/95 backdrop-blur-xl border-b border-gray-200/50 shadow-lg transition-premium">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-14 items-center gap-4">
            <!-- Logo & Brand -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group flex-shrink-0">
                <div class="relative w-8 h-8 flex items-center justify-center transition-all duration-200 rounded-lg bg-brand-orange p-1 flex-shrink-0 overflow-hidden"
                    style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; max-width: 32px; max-height: 32px;"
                    x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                    :style="hovered ? 'transform: scale(1.1) rotate(5deg)' : ''">
                    <img src="{{ asset('Logo.png') }}" alt="Rumba Athaya Logo" class="pointer-events-none"
                        style="width: 24px; height: 24px; max-width: 24px; max-height: 24px; object-fit: contain; object-position: center; display: block;"
                        onerror="this.onerror=null; this.src='{{ asset('LogoNavbar.png') }}';">
                </div>
                <div class="hidden sm:block min-w-0 flex-shrink">
                    <h1 class="font-bold text-sm leading-tight text-slate-900 tracking-tight truncate">Rumba Athaya</h1>
                    <p class="text-xs text-gray-500 font-normal leading-tight truncate">Rumah Belajar Athaya</p>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1 flex-1 justify-center">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('home') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-slate-900' }}"
                    x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false">
                    Beranda
                </a>

                <!-- Produk Dropdown -->
                <div class="relative group" @mouseenter="isProductsOpen = true" @mouseleave="isProductsOpen = false">
                    <button
                        class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 flex items-center gap-1.5 {{ request()->is('produk*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-slate-900' }}">
                        <span>Produk</span>
                        <i class="ph ph-caret-down text-xs transition-transform duration-200"
                            :class="isProductsOpen ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="isProductsOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-10"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-10"
                        class="absolute top-full left-0 mt-1 w-64 bg-white rounded-xl shadow-lg border border-gray-200 z-50"
                        style="display: none;">
                        <div class="p-2">
                            @php
                                $products = [
                                    ['href' => route('program.show', 'calistung-tk'), 'title' => 'Calistung TK', 'desc' => 'Baca Tulis Hitung', 'icon' => 'ph-book-open-text'],
                                    ['href' => route('program.show', 'sd-kelas-1-3'), 'title' => 'SD Kelas 1-3', 'desc' => 'Fondasi Juara', 'icon' => 'ph-graduation-cap'],
                                    ['href' => route('program.show', 'sd-kelas-4-6'), 'title' => 'SD Kelas 4-6', 'desc' => 'Persiapan SMP', 'icon' => 'ph-trophy'],
                                    ['href' => route('program.show', 'smp-kelas-7-9'), 'title' => 'SMP Kelas 7-9', 'desc' => 'Persiapan SMA', 'icon' => 'ph-student'],
                                    ['href' => route('program.show', 'kelas-tahfidz'), 'title' => 'Kelas Tahfidz', 'desc' => 'Hafalan & Tahsin', 'icon' => 'ph-book'],
                                ];
                            @endphp
                            @foreach($products as $index => $product)
                                <a href="{{ $product['href'] }}"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 transition-colors duration-150 group/item"
                                    style="animation-delay: {{ $index * 0.05 }}s;">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 group-hover/item:bg-brand-orange/10 group-hover/item:text-brand-orange transition-colors">
                                        <i class="ph {{ $product['icon'] }} text-base"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-sm text-gray-900">{{ $product['title'] }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $product['desc'] }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <a href="/tentang-kami"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is('tentang-kami*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-slate-900' }}">
                    Tentang Kami
                </a>

                <a href="{{ route('posts.index') }}"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is('sahabat-ra*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-slate-900' }}">
                    Sahabat RA
                </a>

                <a href="/dokumentasi"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is('dokumentasi*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-slate-900' }}">
                    Dokumentasi
                </a>

                <a href="/testimoni"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is('testimoni*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-slate-900' }}">
                    Testimoni
                </a>

                <a href="/kontak"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is('kontak*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-slate-900' }}">
                    Kontak
                </a>

                <!-- Daftar Sekarang Dropdown -->
                <div class="relative group ml-2 flex-shrink-0" @mouseenter="isRegisterOpen = true"
                    @mouseleave="isRegisterOpen = false">
                    <button
                        class="px-4 py-2 text-sm font-medium text-white bg-brand-orange rounded-lg hover:bg-orange-600 transition-all duration-150 flex items-center gap-1.5 shadow-lg shadow-orange-500/30"
                        x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false"
                        :style="hovered ? 'transform: scale(1.05)' : ''">
                        <span>Daftar Sekarang</span>
                        <i class="ph ph-caret-down text-xs transition-transform duration-200"
                            :class="isRegisterOpen ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="isRegisterOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-10"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-10"
                        class="absolute top-full right-0 mt-1 w-56 bg-white rounded-xl shadow-lg border border-gray-200 z-50"
                        style="display: none;">
                        <div class="p-2">
                            <a href="{{ route('register') }}"
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 transition-colors duration-150 group/item">
                                <div
                                    class="w-8 h-8 rounded-lg bg-brand-orange/10 flex items-center justify-center text-brand-orange group-hover/item:bg-brand-orange/20 transition-colors">
                                    <i class="ph ph-user-plus text-base"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-sm text-gray-900">Daftar Baru</div>
                                    <div class="text-xs text-gray-500 mt-0.5">Isi form pendaftaran</div>
                                </div>
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('login') }}"
                                class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 transition-colors duration-150 group/item">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 group-hover/item:bg-gray-200 transition-colors">
                                    <i class="ph ph-sign-in text-base"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-sm text-gray-900">Login</div>
                                    <div class="text-xs text-gray-500 mt-0.5">Masuk ke dashboard</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu Toggle -->
            <div class="lg:hidden flex items-center">
                <button @click="isOpen = !isOpen"
                    class="p-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-150 focus:outline-none"
                    aria-label="Toggle mobile menu" :aria-expanded="isOpen">
                    <i class="ph text-xl transition-transform duration-200"
                        :class="isOpen ? 'ph-x rotate-90' : 'ph-list'"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 height-0" x-transition:enter-end="opacity-100 height-auto"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 height-auto"
            x-transition:leave-end="opacity-0 height-0"
            class="lg:hidden bg-white border-t border-gray-200 shadow-lg overflow-hidden" style="display: none;">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('home') }}"
                    class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('home') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                    @click="isOpen = false">
                    Beranda
                </a>
                <a href="/produk"
                    class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('produk*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                    @click="isOpen = false">
                    Produk
                </a>
                <a href="/tentang-kami"
                    class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('tentang-kami*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                    @click="isOpen = false">
                    Tentang Kami
                </a>
                <a href="{{ route('posts.index') }}"
                    class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('sahabat-ra*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                    @click="isOpen = false">
                    Sahabat RA
                </a>
                <a href="/dokumentasi"
                    class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('dokumentasi*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                    @click="isOpen = false">
                    Dokumentasi
                </a>
                <a href="/testimoni"
                    class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('testimoni*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                    @click="isOpen = false">
                    Testimoni
                </a>
                <a href="/kontak"
                    class="block px-3 py-2.5 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->is('kontak*') ? 'bg-brand-orange/10 text-brand-orange font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                    @click="isOpen = false">
                    Kontak
                </a>
                <div class="border-t border-gray-200 pt-3 mt-3 space-y-2">
                    <a href="{{ route('register') }}"
                        class="block w-full px-4 py-2.5 text-sm font-medium text-white bg-brand-orange rounded-lg hover:bg-orange-600 transition-colors duration-150 text-center shadow-lg shadow-orange-500/30 flex items-center justify-center gap-2"
                        @click="isOpen = false">
                        <i class="ph ph-user-plus"></i>
                        Daftar Baru
                    </a>
                    <a href="{{ route('login') }}"
                        class="block w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-150 text-center flex items-center justify-center gap-2"
                        @click="isOpen = false">
                        <i class="ph ph-sign-in"></i>
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- Spacer untuk fixed navbar -->
<div class="h-14"></div>