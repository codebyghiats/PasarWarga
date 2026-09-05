@extends('layouts.app')

@section('title', $produk->nama_produk . ' — Pasar Warga')

@section('content')
<div class="container">

    <section style="margin-top:20px">
        {{-- Product main image --}}
        <div class="produk-hero__img"
             style="width:100%;aspect-ratio:4/3;border-radius:var(--radius-card);overflow:hidden;background:var(--color-input-bg);display:flex;align-items:center;justify-content:center;box-shadow:var(--shadow-card)">
            @if($produk->foto)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($produk->foto) }}" alt="{{ $produk->nama_produk }}" style="width:100%;height:100%;object-fit:cover">
            @else
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.5" aria-hidden="true"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            @endif
        </div>

        {{-- Product info --}}
        <div class="produk-info" style="margin-top:16px">
            <p style="font-size:13px;color:var(--color-text-secondary)">
                {{ $produk->kategori?->nama }}
            </p>
            <h1 class="page-heading__title" style="font-size:22px;margin-top:2px">{{ $produk->nama_produk }}</h1>
            <p class="produk-info__price" style="font-size:24px;font-weight:700;color:var(--color-primary);margin-top:4px">
                {{ $produk->formatHarga() }}
            </p>
            <p style="font-size:13px;color:var(--color-text-secondary);margin-top:2px">
                Stok: {{ $produk->stok }}
            </p>
        </div>

        {{-- Actions --}}
        <div style="display:flex;gap:10px;margin-top:20px;flex-wrap:wrap">
            <form method="POST" action="{{ route('cart.add') }}" style="flex:1;min-width:180px">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="btn-primary btn-primary--block"
                        {{ $produk->stok < 1 ? 'disabled' : '' }}>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    {{ $produk->stok < 1 ? 'Stok Habis' : 'Tambah ke Keranjang' }}
                </button>
            </form>
            @if($produk->toko?->no_wa)
            <a href="{{ $produk->toko->waUrl() }}?text={{ urlencode('Halo, saya mau tanya soal ' . $produk->nama_produk . '.') }}"
               target="_blank" rel="noopener" class="wa-btn" style="flex:1;min-width:180px">
                Hubungi via WhatsApp
            </a>
            @endif
        </div>

        {{-- Shop summary --}}
        <a href="{{ route('tokos.show', $produk->toko) }}" class="card-panel"
           style="margin-top:20px;display:flex;gap:12px;align-items:center">
            <div style="width:44px;height:44px;border-radius:50%;overflow:hidden;background:var(--color-page);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                @if($produk->toko?->foto)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($produk->toko->foto) }}" alt="{{ $produk->toko->nama_toko }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.5" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                @endif
            </div>
            <div style="flex:1">
                <p style="font-size:12px;color:var(--color-text-secondary)">Dijual oleh</p>
                <p style="font-size:15px;font-weight:700">{{ $produk->toko?->nama_toko }}</p>
            </div>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--color-text-secondary)" stroke-width="2.5" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        {{-- Description --}}
        @if($produk->deskripsi)
        <div class="card-panel" style="margin-top:20px">
            <p class="card-panel__title">Deskripsi</p>
            <p style="font-size:14px;color:var(--color-text);white-space:pre-line">{{ $produk->deskripsi }}</p>
        </div>
        @endif
    </section>

    {{-- Related products --}}
    @if($related->count() > 0)
    <section class="section" style="margin-top:28px" aria-labelledby="heading-related">
        <div class="section-header">
            <h2 class="section-title" id="heading-related">Produk Serupa</h2>
        </div>
        <div class="product-grid" role="list">
            @foreach($related as $rel)
                @include('components.product-card', ['produk' => $rel])
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection