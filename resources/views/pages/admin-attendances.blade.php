@extends('layouts.app')

@section('page-title', 'Manajemen Absensi')
@section('page-description', 'Kelola data kehadiran siswa')

@section('content')
    @livewire('admin.attendances')
@endsection

