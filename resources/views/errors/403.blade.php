@extends('layouts.app')

@section('title', 'Akses Ditolak — Pasar Warga')

@section('content')
<div class="container">
    <div class="empty-state" style="padding-top:60px" role="status">
        <svg class="empty-state__icon" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
        </svg>
        <p class="empty-state__title">Akses Ditolak</p>
        <p class="empty-state__body">
            Halaman ini khusus untuk role tertentu. Kamu tidak punya izin untuk mengaksesnya.
        </p>
        <a href="{{ route('home') }}" class="btn-primary btn-sm" style="margin-top:4px">Kembali ke Beranda</a>
    </div>
</div>
@endsection