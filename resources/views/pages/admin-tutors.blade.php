@extends('layouts.app')

@section('page-title', 'Manajemen Tutor')
@section('page-description', 'Kelola data tutor dengan mudah')

@section('content')
    @livewire('admin.tutors')
@endsection

