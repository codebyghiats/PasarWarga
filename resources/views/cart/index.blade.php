@extends('layouts.app')

@section('title', 'Keranjang — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Keranjang</h1>
        <p class="page-heading__sub">{{ $items->count() }} item di keranjangmu</p>
    </div>

    @if($items->count() > 0)
        <div class="cart-list">
            @foreach($items as $line)
                @php $produk = $line['produk']; @endphp
                <div class="cart-item">
                    <div class="cart-item__img">
                        @if($produk->foto)
                            <img src="{{ \Illuminate\Support\Facades\Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}">
                        @else
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.5" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        @endif
                    </div>
                    <div class="cart-item__body">
                        <p class="cart-item__name">{{ $produk->nama_produk }}</p>
                        <p class="cart-item__shop">{{ $produk->toko?->nama_toko }}</p>
                        <p class="cart-item__price">{{ $produk->formatHarga() }}</p>

                        <div style="display:flex;align-items:center;gap:6px;margin-top:8px">
                            <form method="POST" action="{{ route('cart.update', $produk->id) }}">
                                @csrf
                                <input type="hidden" name="qty" value="{{ max(1, $line['qty'] - 1) }}">
                                <button class="qty-btn" aria-label="Kurangi jumlah" {{ $line['qty'] <= 1 ? 'disabled' : '' }}>−</button>
                            </form>
                            <span class="qty-value">{{ $line['qty'] }}</span>
                            <form method="POST" action="{{ route('cart.update', $produk->id) }}">
                                @csrf
                                <input type="hidden" name="qty" value="{{ min($produk->stok, $line['qty'] + 1) }}">
                                <button class="qty-btn" aria-label="Tambah jumlah" {{ $line['qty'] >= $produk->stok ? 'disabled' : '' }}>+</button>
                            </form>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:8px">
                        <p style="font-size:14px;font-weight:700;color:var(--color-primary)">
                            {{ format_rupiah($line['subtotal']) }}
                        </p>
                        <form method="POST" action="{{ route('cart.remove', $produk->id) }}">
                            @csrf
                            <button class="cart-item__remove" aria-label="Hapus item">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Summary --}}
        <div class="card-panel" style="margin-top:20px">
            <div class="divider"></div>
            <div class="total-row">
                <span>Total</span>
                <span class="total-row__value">{{ format_rupiah($total) }}</span>
            </div>
            <a href="{{ route('pesanan.checkout') }}" class="btn-primary btn-primary--block">
                Lanjut ke Checkout
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
    @else
        <div class="empty-state" role="status">
            <svg class="empty-state__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            <p class="empty-state__title">Keranjang masih kosong</p>
            <p class="empty-state__body">Ayo mulai belanja dari toko-toko di sekitarmu.</p>
            <a href="{{ route('katalog.index') }}" class="btn-primary btn-sm" style="margin-top:4px">Lihat Katalog</a>
        </div>
    @endif

</div>
@endsection