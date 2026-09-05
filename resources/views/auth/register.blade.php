@extends('layouts.auth')

@section('title', 'Daftar — Pasar Warga')
@section('auth-title', 'Daftar Akun')
@section('auth-subtitle', 'Pilih peranmu untuk mulai.')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="role" id="role-input" value="{{ $selectedRole ?? '' }}">

        {{-- Role selector --}}
        <div class="form-field">
            <label class="form-label">Daftar sebagai</label>
            <div class="role-cards" id="role-cards">
                <button type="button" class="role-card {{ ($selectedRole ?? null) === 'warga' ? 'role-card--active' : '' }}"
                        data-role="warga">
                    <span class="role-card__icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </span>
                    <span class="role-card__label">Warga (Pembeli)</span>
                    <span class="role-card__desc">Cari & pesan produk dari UMKM sekitar</span>
                </button>
                <button type="button" class="role-card {{ ($selectedRole ?? null) === 'pemilik_toko' ? 'role-card--active' : '' }}"
                        data-role="pemilik_toko">
                    <span class="role-card__icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </span>
                    <span class="role-card__label">Pemilik Usaha</span>
                    <span class="role-card__desc">Daftarkan tokomu & terima pesanan</span>
                </button>
            </div>
            @error('role')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="name" class="form-label">Nama lengkap</label>
            <input type="text" id="name" name="name" class="form-input"
                   value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="Nama kamu">
            @error('name')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-input"
                   value="{{ old('email') }}" required autocomplete="email"
                   placeholder="nama@contoh.com">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-input"
                   required autocomplete="new-password" placeholder="Minimal 8 karakter">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="password_confirmation" class="form-label">Ulangi password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   class="form-input" required autocomplete="new-password" placeholder="Ketik ulang password">
        </div>

        <button type="submit" class="btn-primary btn-primary--block">Buat Akun</button>
    </form>

    <div class="auth-card__footer">
        Sudah punya akun?
        <a href="{{ route('login') }}">Masuk</a>
    </div>
@endsection

@push('scripts')
<script>
(() => {
    const cards = document.querySelectorAll('.role-card');
    const input = document.getElementById('role-input');
    cards.forEach(card => {
        card.addEventListener('click', () => {
            cards.forEach(c => c.classList.remove('role-card--active'));
            card.classList.add('role-card--active');
            input.value = card.dataset.role;
        });
    });
})();
</script>
@endpush