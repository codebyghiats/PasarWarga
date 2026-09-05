@extends('layouts.app')

@section('title', 'Katalog Produk — Pasar Warga')

@section('location-strip')
    @include('components.location-strip', ['lokasi' => $filters['lokasi'] ?: null])
@endsection

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Katalog Produk</h1>
        <p class="page-heading__sub">Temukan produk dari UMKM di sekitarmu.</p>
    </div>

    {{-- Search --}}
    <form class="search-wrap" role="search" action="{{ route('katalog.index') }}" method="GET">
        @if($filters['kategori'])
            <input type="hidden" name="kategori" value="{{ $filters['kategori'] }}">
        @endif
        <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <label for="search-katalog" class="sr-only">Cari produk atau toko</label>
        <input type="search" id="search-katalog" name="q" class="search-input"
               value="{{ $filters['q'] }}" placeholder="Cari produk atau toko...">
    </form>

    {{-- Category pills --}}
    <nav class="pills-row" aria-label="Filter kategori" id="category-filter">
        <a class="pill {{ !$filters['kategori'] ? 'pill--active' : '' }}"
           href="{{ route('katalog.index', array_merge(request()->except(['kategori', 'page']))) }}">Semua</a>
        @foreach($kategoris as $kat)
        <a class="pill {{ (string) $filters['kategori'] === (string) $kat->id ? 'pill--active' : '' }}"
           href="{{ route('katalog.index', array_merge(request()->except(['kategori', 'page']), ['kategori' => $kat->id])) }}">
            <span style="display:inline-flex;color:inherit">
                @include('components.category-icon', ['icon' => $kat->icon])
            </span>
            {{ $kat->nama }}
        </a>
        @endforeach
    </nav>

    {{-- Price range filter --}}
    <form class="price-filter" action="{{ route('katalog.index') }}" method="GET"
          style="display:flex;gap:8px;align-items:center;margin-bottom:16px">
        @if($filters['q'])
            <input type="hidden" name="q" value="{{ $filters['q'] }}">
        @endif
        @if($filters['kategori'])
            <input type="hidden" name="kategori" value="{{ $filters['kategori'] }}">
        @endif
        @if($filters['lokasi'])
            <input type="hidden" name="lokasi" value="{{ $filters['lokasi'] }}">
        @endif
        <label for="min_harga" class="sr-only">Harga minimum</label>
        <input type="number" id="min_harga" name="min_harga" class="form-input"
               style="width:110px" placeholder="Min" value="{{ $filters['min'] }}">
        <span style="color:var(--color-text-secondary)">–</span>
        <label for="max_harga" class="sr-only">Harga maksimum</label>
        <input type="number" id="max_harga" name="max_harga" class="form-input"
               style="width:110px" placeholder="Max" value="{{ $filters['max'] }}">
        <button type="submit" class="btn-primary btn-sm">Filter</button>
    </form>

    {{-- Product grid --}}
    @if($produks->count() > 0)
    <div class="product-grid" role="list">
        @foreach($produks as $produk)
            @include('components.product-card', ['produk' => $produk])
        @endforeach
    </div>

    <div style="margin-top:24px">
        {{ $produks->links() }}
    </div>
    @else
    <div class="empty-state" role="status" aria-live="polite">
        <svg class="empty-state__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        <p class="empty-state__title">Tidak ada produk ditemukan</p>
        <p class="empty-state__body">Coba ubah kata kunci atau filter yang kamu pilih.</p>
    </div>
    @endif

</div>
@endsection