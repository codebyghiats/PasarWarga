@extends('layouts.app')

@section('title', 'Pesanan #' . $pesanan->id . ' — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:wrap">
            <h1 class="page-heading__title">Pesanan #{{ $pesanan->id }}</h1>
            <span class="badge badge--{{ $pesanan->status }}">{{ ucfirst($pesanan->status) }}</span>
        </div>
        <p class="page-heading__sub">
            {{ $pesanan->created_at->translatedFormat('d M Y, H:i') }}
        </p>
    </div>

    @if($pesanan->status === 'menunggu')
    <div class="flash flash--success" style="margin-bottom:16px">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        Pesanan menunggu konfirmasi dari penjual.
    </div>
    @endif

    {{-- Items --}}
    <div class="card-panel">
        <p class="card-panel__title">Item Pesanan</p>
        @foreach($pesanan->items as $item)
        <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--color-border);font-size:14px">
            <div>
                <span style="font-weight:700">{{ $item->produk?->nama_produk }}</span>
                <span style="color:var(--color-text-secondary)"> × {{ $item->qty }}</span>
                <div style="font-size:12px;color:var(--color-text-secondary)">
                    {{ $item->produk?->toko?->nama_toko }}
                </div>
            </div>
            <span style="font-weight:700">{{ format_rupiah($item->subtotal) }}</span>
        </div>
        @endforeach

        <div class="divider"></div>
        <div class="total-row" style="padding-bottom:0">
            <span>Total</span>
            <span class="total-row__value">{{ $pesanan->formatTotal() }}</span>
        </div>
    </div>

    {{-- Delivery details --}}
    <div class="card-panel" style="margin-top:16px">
        <p class="card-panel__title">Detail Pengiriman</p>
        <p style="font-size:14px;font-weight:700">{{ $pesanan->nama_penerima }}</p>
        <p style="font-size:14px;color:var(--color-text-secondary);margin-top:2px">{{ $pesanan->alamat_pengiriman }}</p>
        @if($pesanan->catatan)
            <p style="font-size:14px;margin-top:8px">Catatan: {{ $pesanan->catatan }}</p>
        @endif
    </div>

    <a href="{{ route('pesanan.index') }}" class="btn-secondary btn-secondary--block" style="margin-top:20px">Kembali ke Pesanan</a>

</div>
@endsection