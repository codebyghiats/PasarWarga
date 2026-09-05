@extends('layouts.app')

@section('title', $toko->nama_toko . ' — Pasar Warga')

@section('content')
<div class="container">

    {{-- Shop header --}}
    <section class="shop-hero" style="margin-top:20px">
        <div class="card-panel" style="display:flex;gap:16px;align-items:center;flex-wrap:wrap">
            <div class="shop-hero__avatar"
                 style="width:72px;height:72px;border-radius:50%;overflow:hidden;flex-shrink:0;background:var(--color-page);display:flex;align-items:center;justify-content:center">
                @if($toko->foto)
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($toko->foto) }}" alt="{{ $toko->nama_toko }}" style="width:100%;height:100%;object-fit:cover">
                @else
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="var(--color-primary)" stroke-width="1.5" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                @endif
            </div>
            <div style="flex:1;min-width:200px">
                <h1 class="page-heading__title" style="font-size:22px;margin-bottom:2px">{{ $toko->nama_toko }}</h1>
                <p style="font-size:14px;color:var(--color-text-secondary);display:flex;align-items:center;gap:4px">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $toko->lokasi }}
                </p>
                @if($toko->deskripsi)
                    <p style="font-size:14px;color:var(--color-text-secondary);margin-top:4px">{{ $toko->deskripsi }}</p>
                @endif
            </div>
            @if($toko->no_wa)
            <a href="{{ $toko->waUrl() }}?text={{ urlencode('Halo ' . $toko->nama_toko . ', saya mau tanya soal produkmu.') }}"
               target="_blank" rel="noopener" class="wa-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                Hubungi via WhatsApp
            </a>
            @endif
        </div>
    </section>

    {{-- Products --}}
    <section class="section" style="margin-top:24px" aria-labelledby="heading-produk-toko">
        <div class="section-header">
            <h2 class="section-title" id="heading-produk-toko">Produk {{ $toko->nama_toko }}</h2>
        </div>

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
        <div class="empty-state" role="status">
            <svg class="empty-state__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            <p class="empty-state__title">Belum ada produk</p>
            <p class="empty-state__body">Toko ini belum menambahkan produk.</p>
        </div>
        @endif
    </section>

</div>
@endsection