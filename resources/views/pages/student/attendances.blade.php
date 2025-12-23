@extends('layouts.app')

@section('page-title', 'Absensi')
@section('page-description', 'Lihat riwayat kehadiran Anda')

@section('content')
<script>
    // Redirect to Next.js frontend
    window.location.href = '{{ env("NEXT_PUBLIC_APP_URL", "http://localhost:3002") }}/attendance';
</script>

<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-gray-50 to-gray-100">
    <div class="text-center">
        <div class="w-16 h-16 border-4 border-brand-orange border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-slate-600 font-medium">Mengarahkan ke halaman absensi...</p>
        <p class="text-sm text-slate-500 mt-2">
            Jika tidak otomatis redirect, 
            <a href="{{ env('NEXT_PUBLIC_APP_URL', 'http://localhost:3002') }}/attendance" class="text-brand-orange hover:underline">
                klik di sini
            </a>
        </p>
    </div>
</div>
@endsection

