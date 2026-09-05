@extends('layouts.app')

@section('title', 'Dashboard Admin — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Dashboard Admin</h1>
        <p class="page-heading__sub">Kelola toko, kategori, dan pengguna platform.</p>
    </div>

    {{-- Stats --}}
    <div class="stat-row">
        <div class="stat-card">
            <p class="stat-card__value">{{ $statTokos }}</p>
            <p class="stat-card__label">Total Toko</p>
        </div>
        <div class="stat-card">
            <p class="stat-card__value">{{ $statPending }}</p>
            <p class="stat-card__label">Menunggu Persetujuan</p>
        </div>
        <div class="stat-card">
            <p class="stat-card__value">{{ $statProduks }}</p>
            <p class="stat-card__label">Total Produk</p>
        </div>
        <div class="stat-card">
            <p class="stat-card__value">{{ $statUsers }}</p>
            <p class="stat-card__label">Total Pengguna</p>
        </div>
    </div>

    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px">
        <a href="{{ route('admin.users.index') }}" class="btn-secondary btn-sm">Kelola Pengguna</a>
        <a href="{{ route('admin.kategoris.index') }}" class="btn-secondary btn-sm">Kelola Kategori</a>
    </div>

    {{-- Pending shops --}}
    <div class="card-panel">
        <p class="card-panel__title">Toko Menunggu Persetujuan</p>

        @if($pendingTokos->count() > 0)
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Toko</th>
                        <th>Lokasi</th>
                        <th>Pemilik</th>
                        <th class="sr-only">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingTokos as $toko)
                    <tr>
                        <td style="font-weight:700">{{ $toko->nama_toko }}</td>
                        <td>{{ $toko->lokasi }}</td>
                        <td>{{ $toko->user?->name }}</td>
                        <td>
                            <div class="table-actions">
                                <form method="POST" action="{{ route('admin.tokos.approve', $toko) }}">
                                    @csrf
                                    <button class="btn-primary btn-sm">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.tokos.reject', $toko) }}">
                                    @csrf
                                    <button class="btn-danger btn-sm">Reject</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state" style="padding:24px">
            <p class="empty-state__body">Tidak ada toko yang menunggu persetujuan.</p>
        </div>
        @endif
    </div>

</div>
@endsection