@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="bg-white/70 backdrop-blur-xl border border-white/60 rounded-[2.5rem] shadow-2xl shadow-orange-500/10 p-8 sm:p-10 w-full max-w-lg">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-orange-500 to-amber-500 mb-6 shadow-lg shadow-orange-500/30">
                <span class="text-3xl font-extrabold text-white">R</span>
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight mb-2">
                <span class="text-slate-800">Mulai</span> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-amber-500">Perjalananmu</span> 🚀
            </h1>
            <p class="text-slate-500">Buat akun baru dalam hitungan detik.</p>
        </div>

    <!-- Register Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name & Nickname Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Name -->
            <x-premium-input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}"
                required 
                autofocus
                label="Nama Lengkap"
                placeholder="Nama Lengkap"
                :error="$errors->first('name')"
            />

            <!-- Nickname (Optional) -->
            <x-premium-input 
                type="text" 
                id="nickname" 
                name="nickname" 
                value="{{ old('nickname') }}"
                label="Nama Panggilan"
                placeholder="Nama Panggilan"
                :error="$errors->first('nickname')"
            />
        </div>

        <!-- Email -->
        <x-premium-input 
            type="email" 
            id="email" 
            name="email" 
            value="{{ old('email') }}"
            required
            label="Email"
            placeholder="nama@email.com"
            :error="$errors->first('email')"
        />

        <!-- Password -->
        <x-premium-input 
            type="password" 
            id="password" 
            name="password" 
            required
            label="Password"
            placeholder="••••••••"
            :error="$errors->first('password')"
        />

        <!-- Password Confirmation -->
        <x-premium-input 
            type="password" 
            id="password_confirmation" 
            name="password_confirmation" 
            required
            label="Konfirmasi Password"
            placeholder="••••••••"
        />

        <!-- Submit Button -->
        <x-premium-button 
            type="submit" 
            variant="orange"
            size="lg"
            class="w-full"
        >
            Daftar Sekarang
        </x-premium-button>
    </form>

    <!-- Footer -->
    <div class="mt-8 text-center">
        <p class="text-sm text-slate-500">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-semibold text-orange-600 hover:text-orange-700 hover:underline">
                Masuk
            </a>
        </p>
    </div>
    </div>
</div>
@endsection

