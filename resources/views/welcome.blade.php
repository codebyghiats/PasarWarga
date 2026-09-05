@extends('layouts.app')

@section('title', 'Pasar Warga — Belanja dari Tetanggamu')

@section('location-strip')
    @include('components.location-strip', ['lokasi' => $lokasi ?? null])
@endsection

@section('content')
<div class="container">

    {{-- Hero --}}
    <section class="hero" aria-labelledby="hero-heading">
        <h1 class="hero__headline" id="hero-heading">
            Belanja dari<br><span>tetanggamu</span>
        </h1>
        <p class="hero__subtitle">Produk segar UMKM lokal, langsung pesan dari sini.</p>

        {{-- Search --}}
        <form class="search-wrap" role="search" action="{{ route('katalog.index') }}" method="GET">
            <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <label for="search-input" class="sr-only">Cari produk atau toko</label>
            <input
                type="search"
                id="search-input"
                name="q"
                class="search-input"
                placeholder="Cari produk atau toko..."
                autocomplete="off"
                aria-label="Cari produk atau toko"
            >
        </form>

        {{-- Category pills --}}
        <nav class="pills-row" aria-label="Filter kategori" id="category-filter" role="tablist">
            <a class="pill {{ !request('kategori') ? 'pill--active' : '' }}" role="tab" aria-selected="{{ !request('kategori') ? 'true' : 'false' }}"
               href="{{ route('katalog.index') }}">
                Semua
            </a>
            @foreach($kategoris ?? [] as $kat)
            <a class="pill {{ (string) request('kategori') === (string) $kat->id ? 'pill--active' : '' }}" role="tab"
               aria-selected="{{ (string) request('kategori') === (string) $kat->id ? 'true' : 'false' }}"
               href="{{ route('katalog.index', ['kategori' => $kat->id]) }}">
                <span style="display:inline-flex;color:inherit">
                    @include('components.category-icon', ['icon' => $kat->icon])
                </span>
                {{ $kat->nama }}
            </a>
            @endforeach
        </nav>
    </section>

    {{-- Guest CTA banner --}}
    @if($showGuestCta ?? true)
        @include('components.guest-cta')
    @endif

    {{-- Toko Dekatmu --}}
    <section class="section" aria-labelledby="heading-toko">
        <div class="section-header">
            <h2 class="section-title" id="heading-toko">Toko Dekatmu</h2>
            <a href="{{ route('tokos.index') }}" class="section-link">
                Lihat semua
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        @if(count($tokos ?? []) > 0)
        <div class="shops-scroll" role="list">
            @foreach($tokos as $toko)
                @include('components.shop-card', ['toko' => $toko])
            @endforeach
        </div>
        @else
        <div class="empty-state" role="status">
            <svg class="empty-state__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <p class="empty-state__title">Belum ada toko</p>
            <p class="empty-state__body">Belum ada toko terdaftar di lokasimu. Coba pilih lokasi lain atau cek lagi nanti.</p>
        </div>
        @endif
    </section>

    {{-- Produk Terbaru --}}
    <section class="section" aria-labelledby="heading-produk">
        <div class="section-header">
            <h2 class="section-title" id="heading-produk">Produk Terbaru</h2>
            <a href="{{ route('katalog.index') }}" class="section-link">
                Lihat semua
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>

        @if(count($produks ?? []) > 0)
        <div class="product-grid" role="list">
            @foreach($produks as $produk)
                @include('components.product-card', ['produk' => $produk])
            @endforeach
        </div>
        @else
        <div class="empty-state" role="status" aria-live="polite">
            <svg class="empty-state__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <p class="empty-state__title">Belum ada produk</p>
            <p class="empty-state__body">Belum ada produk tersedia di lokasimu. Coba pilih lokasi lain atau cek lagi nanti.</p>
        </div>
        @endif
    </section>

</div>{{-- /.container --}}
@endsection

@push('scripts')
<script>
(() => {
    'use strict';

    /* ── Animate sections on scroll ──────────────────────── */
    const observer = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.style.opacity = '1';
                e.target.style.transform = 'translateY(0)';
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });

    document.querySelectorAll('.section').forEach(sec => {
        sec.style.opacity = '0';
        sec.style.transform = 'translateY(16px)';
        sec.style.transition = 'opacity 350ms cubic-bezier(0,0,0.2,1), transform 350ms cubic-bezier(0,0,0.2,1)';
        observer.observe(sec);
    });
})();
</script>
@endpush
