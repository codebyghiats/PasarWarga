@extends('layouts.app')

@section('title', 'Daftar Toko — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Toko</h1>
        <p class="page-heading__sub">UMKM di sekitarmu, siap melayani.</p>
    </div>

    {{-- Search --}}
    <form class="search-wrap" role="search" action="{{ route('tokos.index') }}" method="GET">
        <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
        </svg>
        <label for="search-toko" class="sr-only">Cari toko</label>
        <input type="search" id="search-toko" name="q" class="search-input"
               value="{{ request('q') }}" placeholder="Cari nama toko...">
    </form>

    @if($tokos->count() > 0)
    <div class="shops-grid" role="list"
         style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px;margin-top:16px">
        @foreach($tokos as $toko)
            @include('components.shop-card', ['toko' => $toko])
        @endforeach
    </div>

    <div style="margin-top:24px">
        {{ $tokos->links() }}
    </div>
    @else
    <div class="empty-state" role="status">
        <svg class="empty-state__icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <p class="empty-state__title">Belum ada toko</p>
        <p class="empty-state__body">Coba kata kunci lain atau cek lagi nanti.</p>
    </div>
    @endif

</div>
@endsection