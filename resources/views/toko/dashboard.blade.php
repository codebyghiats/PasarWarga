@extends('layouts.app')

@section('title', 'Dashboard Toko — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Dashboard Toko</h1>
        <p class="page-heading__sub">{{ $toko->nama_toko }}</p>
    </div>

    {{-- Status banner --}}
    @if($toko->status === 'pending')
    <div class="status-banner status-banner--pending">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        <div>
            <p class="status-banner__title">Menunggu persetujuan admin</p>
            <p class="status-banner__body">Tokomu belum muncul di katalog publik. Admin akan menyetujui sebentar lagi.</p>
        </div>
    </div>
    @elseif($toko->status === 'approved')
    <div class="status-banner status-banner--approved">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
        <div>
            <p class="status-banner__title">Tokomu aktif!</p>
            <p class="status-banner__body">Produkmu terlihat di katalog publik.</p>
        </div>
    </div>
    @else
    <div class="status-banner status-banner--rejected">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        <div>
            <p class="status-banner__title">Tokomu ditolak</p>
            <p class="status-banner__body">Hubungi admin untuk informasi lebih lanjut.</p>
        </div>
    </div>
    @endif

    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px">
        <a href="{{ route('toko.pendaftaran') }}" class="btn-secondary btn-sm">Edit Profil Toko</a>
        <a href="{{ route('toko.produks.create') }}" class="btn-primary btn-sm">+ Tambah Produk</a>
    </div>

    {{-- Stats --}}
    <div class="stat-row">
        <div class="stat-card">
            <p class="stat-card__value">{{ $statProduk }}</p>
            <p class="stat-card__label">Jumlah Produk</p>
        </div>
        <div class="stat-card">
            <p class="stat-card__value">{{ $pesananMasuk->count() }}</p>
            <p class="stat-card__label">Pesanan Masuk</p>
        </div>
    </div>

    {{-- Incoming orders --}}
    <div class="card-panel">
        <p class="card-panel__title">Pesanan Masuk</p>

        @if($pesananMasuk->count() > 0)
        <div class="order-list">
            @foreach($pesananMasuk as $pesanan)
            <div class="order-card">
                <div class="order-card__head">
                    <span class="order-card__id">Pesanan #{{ $pesanan->id }}</span>
                    <span class="badge badge--menunggu">Menunggu</span>
                </div>
                <p class="order-card__meta">
                    {{ $pesanan->user?->name }} ·
                    {{ $pesanan->created_at->translatedFormat('d M Y, H:i') }}
                </p>
                <p style="font-size:13px;color:var(--color-text-secondary)">
                    {{ $pesanan->items->map(fn ($i) => $i->produk?->nama_produk . ' ×' . $i->qty)->implode(', ') }}
                </p>
                <div class="order-card__total">{{ $pesanan->formatTotal() }}</div>
                <div class="order-card__actions">
                    <form method="POST" action="{{ route('toko.pesanans.konfirmasi', $pesanan) }}">
                        @csrf
                        <button class="btn-primary btn-sm">Konfirmasi</button>
                    </form>
                    <form method="POST" action="{{ route('toko.pesanans.tolak', $pesanan) }}">
                        @csrf
                        <button class="btn-danger btn-sm">Tolak</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state" style="padding:24px">
            <p class="empty-state__body">Belum ada pesanan masuk.</p>
        </div>
        @endif
    </div>

    {{-- Recent products --}}
    <div class="card-panel" style="margin-top:16px">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px">
            <p class="card-panel__title" style="margin-bottom:0">Produk Terbaru</p>
            <a href="{{ route('toko.produks.index') }}" class="section-link">Semua</a>
        </div>

        @if($produks->count() > 0)
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr>
                        <td style="font-weight:700">{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->formatHarga() }}</td>
                        <td>{{ $produk->stok }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state" style="padding:24px">
            <p class="empty-state__body">Belum ada produk. Tambahkan produk pertamamu!</p>
        </div>
        @endif
    </div>

</div>
@endsection