@php
    $produkFoto = $produk->foto
        ? \Illuminate\Support\Facades\Storage::url($produk->foto)
        : null;
    $badge = ($produk->kategori?->nama) ?? null;
@endphp
<article class="product-card" role="listitem"
         onclick="window.location.href='{{ route('produks.show', $produk) }}'"
         style="cursor:pointer" aria-label="{{ $produk->nama_produk }}, {{ $produk->formatHarga() }}">
    <div class="product-card__img">
        @if($produkFoto)
            <img src="{{ $produkFoto }}" alt="{{ $produk->nama_produk }}" loading="lazy">
        @else
            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--color-input-bg);">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            </div>
        @endif
        @if($badge)
            <span class="product-card__badge">{{ $badge }}</span>
        @endif
    </div>
    <div class="product-card__body">
        <p class="product-card__name">{{ $produk->nama_produk }}</p>
        <p class="product-card__shop">{{ $produk->toko?->nama_toko }}</p>
        <p class="product-card__price">{{ $produk->formatHarga() }}</p>
        <p class="product-card__stock">Stok: {{ $produk->stok }}</p>
        <button class="btn-tambah" data-add-to-cart data-produk-id="{{ $produk->id }}"
                aria-label="Tambah {{ $produk->nama_produk }} ke keranjang"
                onclick="event.stopPropagation()">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Tambah
        </button>
    </div>
</article>