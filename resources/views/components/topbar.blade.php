<header class="topbar" role="banner">
    <div class="container topbar__inner">
        <a href="{{ route('home') }}" class="topbar__wordmark" aria-label="Pasar Warga — Beranda">
            Pasar Warga
        </a>
        <div class="topbar__actions">
            {{-- Cart icon --}}
            <a href="{{ route('cart.index') }}" class="topbar__icon-btn" aria-label="Keranjang belanja">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
                @if(auth()->check() && session('cart_count', 0) > 0)
                    <span class="topbar__badge" id="cart-count-badge" aria-label="{{ session('cart_count') }} item di keranjang">{{ session('cart_count') }}</span>
                @endif
            </a>

            @auth
            {{-- Dashboard link depends on role --}}
            <a href="{{ auth()->user()->isPemilikToko() ? route('toko.dashboard') : route('profile.edit') }}"
               class="topbar__icon-btn" aria-label="Profil saya">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
            </a>
            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="topbar__logout" style="display:inline">
                @csrf
                <button type="submit" class="topbar__icon-btn" aria-label="Keluar" title="Keluar">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="topbar__icon-btn" aria-label="Masuk">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
            </a>
            @endauth
        </div>
    </div>
</header>