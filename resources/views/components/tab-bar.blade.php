@php
    $active = $active ?? 'beranda';
@endphp
<nav class="tab-bar" role="navigation" aria-label="Navigasi utama">
    <a href="{{ route('home') }}" class="tab-item {{ $active === 'beranda' ? 'tab-item--active' : '' }}" aria-label="Beranda"
       {{ $active === 'beranda' ? 'aria-current=page' : '' }}>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="{{ $active === 'beranda' ? 'currentColor' : 'none' }}" stroke="{{ $active !== 'beranda' ? 'currentColor' : 'none' }}" stroke-width="2" aria-hidden="true">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
        </svg>
        Beranda
    </a>
    <a href="{{ route('katalog.index') }}" class="tab-item {{ $active === 'kategori' ? 'tab-item--active' : '' }}" aria-label="Katalog produk"
       {{ $active === 'kategori' ? 'aria-current=page' : '' }}>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
            <rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>
        </svg>
        Kategori
    </a>
    @php
        $pesananUrl = auth()->check() && auth()->user()->isPemilikToko()
            ? route('toko.dashboard')
            : route('pesanan.index');
    @endphp
    <a href="{{ $pesananUrl }}" class="tab-item {{ $active === 'pesanan' ? 'tab-item--active' : '' }}" aria-label="Pesanan saya"
       {{ $active === 'pesanan' ? 'aria-current=page' : '' }}>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
            <line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>
        </svg>
        Pesanan
    </a>
    @auth
    <a href="{{ route('profile.edit') }}" class="tab-item {{ $active === 'profil' ? 'tab-item--active' : '' }}" aria-label="Profil saya"
       {{ $active === 'profil' ? 'aria-current=page' : '' }}>
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        Profil
    </a>
    @else
    <a href="{{ route('login') }}" class="tab-item {{ $active === 'masuk' ? 'tab-item--active' : '' }}" aria-label="Masuk ke akun">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
            <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
        </svg>
        Masuk
    </a>
    @endauth
</nav>