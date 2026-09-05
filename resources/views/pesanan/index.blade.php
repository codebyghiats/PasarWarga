@extends('layouts.app')

@section('title', 'Pesanan Saya — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Pesanan Saya</h1>
        <p class="page-heading__sub">Pantau status pesananmu.</p>
    </div>

    @if($pesanans->count() > 0)
        <div class="order-list">
            @foreach($pesanans as $pesanan)
            <div class="order-card">
                <div class="order-card__head">
                    <span class="order-card__id">Pesanan #{{ $pesanan->id }}</span>
                    <span class="badge badge--{{ $pesanan->status }}">{{ ucfirst($pesanan->status) }}</span>
                </div>
                <p class="order-card__meta">
                    Dipesan {{ $pesanan->created_at->translatedFormat('d M Y, H:i') }} ·
                    {{ $pesanan->items->count() }} item
                </p>
                <div class="order-card__total">{{ $pesanan->formatTotal() }}</div>
                <div class="order-card__actions">
                    <a href="{{ route('pesanan.show', $pesanan) }}" class="btn-secondary btn-sm">Detail</a>
                </div>
            </div>
            @endforeach
        </div>

        <div style="margin-top:24px">
            {{ $pesanans->links() }}
        </div>
    @else
        <div class="empty-state" role="status">
            <svg class="empty-state__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            <p class="empty-state__title">Belum ada pesanan</p>
            <p class="empty-state__body">Pesan sesuatu dari tetanggamu untuk melihat riwayat pesanan di sini.</p>
            <a href="{{ route('katalog.index') }}" class="btn-primary btn-sm" style="margin-top:4px">Cari Produk</a>
        </div>
    @endif

</div>
@endsection