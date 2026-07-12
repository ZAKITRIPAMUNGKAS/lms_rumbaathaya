@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-b from-gray-50 to-gray-100">
        <!-- Background Decorations -->
        <div class="absolute inset-0 bg-dots opacity-5 pointer-events-none"></div>
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-brand-orange/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-brand-blue/10 rounded-full blur-3xl animate-pulse"></div>

        <div class="relative z-10 w-full max-w-md px-4" x-data="{ showPassword: false, loading: false }">
            <div
                class="bg-white/80 backdrop-blur-xl rounded-[2rem] shadow-lg shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <!-- Header -->
                <div
                    class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-8 text-center text-white relative overflow-hidden">
                    <!-- Background Base -->
                    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>

                    <!-- Gradient Orbs -->
                    <div
                        class="absolute top-0 right-0 w-[300px] h-[300px] bg-brand-orange/10 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/2">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-[250px] h-[250px] bg-blue-600/10 rounded-full blur-[80px] translate-y-1/3 -translate-x-1/3">
                    </div>

                    <!-- Pattern Overlay -->
                    <div class="absolute inset-0 opacity-[0.03]"
                        style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 40px 40px;">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="w-20 h-20 mx-auto mb-4 rounded-xl bg-white/10 backdrop-blur-md p-2 flex items-center justify-center border border-white/10 shadow-xl transition-transform hover:scale-105 duration-300">
                            <img src="{{ asset('Logo.png') }}" alt="{{ config('app.name') }}"
                                class="w-full h-full object-contain">
                        </div>
                    </div>
                    <h1 class="text-2xl font-extrabold mb-2 relative z-10 tracking-tight">Rumba Athaya LMS</h1>
                    <p class="text-white/80 text-sm relative z-10 font-medium">Masuk ke Dashboard</p>
                </div>

                <!-- Form -->
                <div class="p-8 bg-white/60 backdrop-blur-sm">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Validation Error Warning Box -->
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl flex items-start gap-3 animate-shake">
                            <i class="ph ph-warning-circle text-red-500 text-xl shrink-0 mt-0.5"></i>
                            <div>
                                <h4 class="font-bold text-red-800 text-sm">Gagal Masuk</h4>
                                <p class="text-xs text-red-600 mt-1">
                                    {{ $errors->first() }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6" @submit="if ($el.checkValidity()) loading = true">
                        @csrf

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-bold text-slate-700">
                                <i class="ph ph-envelope mr-2 text-brand-orange"></i>
                                Email
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="username"
                                class="w-full px-4 py-3 border-2 {{ $errors->has('email') ? 'border-red-300 bg-red-50/10' : 'border-gray-200/60 bg-white/80' }} rounded-xl focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 outline-none transition-all duration-200 backdrop-blur-sm font-medium text-slate-700 placeholder:text-slate-400"
                                placeholder="nama@example.com">
                            @if ($errors->has('email'))
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $errors->first('email') }}</p>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-bold text-slate-700">
                                <i class="ph ph-lock mr-2 text-brand-orange"></i>
                                Password
                            </label>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required
                                    autocomplete="current-password"
                                    class="w-full px-4 py-3 border-2 {{ $errors->has('password') || $errors->has('email') ? 'border-red-300 bg-red-50/10' : 'border-gray-200/60 bg-white/80' }} rounded-xl focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20 outline-none transition-all duration-200 pr-12 backdrop-blur-sm font-medium text-slate-700 placeholder:text-slate-400"
                                    placeholder="Masukkan password">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-brand-orange transition-colors">
                                    <i class="ph text-xl" :class="showPassword ? 'ph-eye-slash' : 'ph-eye'"></i>
                                </button>
                            </div>
                            @if ($errors->has('password'))
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $errors->first('password') }}</p>
                            @endif
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="flex items-center cursor-pointer">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="w-4 h-4 text-brand-orange border-gray-300 rounded focus:ring-brand-orange/20">
                                <span class="ml-2 text-sm text-slate-600 font-medium">Ingat saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-semibold text-brand-orange hover:text-orange-600 transition-colors">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        <!-- Message for backend error handling -->

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-brand-blue via-blue-600 to-brand-orange text-white py-3.5 rounded-xl font-bold text-base shadow-lg shadow-orange-500/30 hover:shadow-xl hover:shadow-orange-500/40 transition-all duration-200 flex items-center justify-center gap-2 transform active:scale-95">
                            <i class="ph ph-sign-in text-xl"></i>
                            <span>Masuk</span>
                        </button>

                        <div class="text-center pt-2">
                            <a href="{{ route('home') }}"
                                class="inline-flex items-center gap-2 text-sm text-slate-600 hover:text-brand-orange transition-colors font-medium">
                                <i class="ph ph-arrow-left"></i>
                                <span>Kembali ke Beranda</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Full-screen Loading Overlay -->
            <div x-show="loading" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 class="fixed inset-0 z-[10000] bg-slate-950/80 backdrop-blur-md flex flex-col items-center justify-center text-white text-center p-6" 
                 style="display: none;">
                <div class="w-16 h-16 rounded-2xl bg-white shadow-xl flex items-center justify-center mb-6 border border-slate-200 animate-bounce">
                    <img src="{{ asset('Logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                </div>
                <div class="w-10 h-10 border-4 border-orange-500/20 border-t-orange-500 rounded-full animate-spin mb-4" style="border-top-color: #F59E0B"></div>
                <h3 class="text-lg font-bold text-white tracking-tight">Memverifikasi Akun...</h3>
                <p class="text-xs text-slate-400 mt-1">Mohon tunggu sebentar, kami sedang menghubungkan Anda</p>
            </div>
        </div>
    </div>
@endsection