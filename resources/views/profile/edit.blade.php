@extends('layouts.app')

@section('title', 'Profil Saya — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Profil Saya</h1>
        <p class="page-heading__sub">Kelola informasi akunmu.</p>
    </div>

    {{-- Info account --}}
    <div class="card-panel">
        <p class="card-panel__title">Informasi Akun</p>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <div class="form-field">
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" name="name" class="form-input"
                       value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-input"
                       value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <span class="form-label">Role</span>
                <p style="font-size:14px;color:var(--color-text-secondary)">
                    {{ $user->role === 'admin' ? 'Admin' : ($user->role === 'pemilik_toko' ? 'Pemilik Toko' : 'Warga') }}
                </p>
            </div>

            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    {{-- Password --}}
    <div class="card-panel" style="margin-top:16px">
        <p class="card-panel__title">Ganti Password</p>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')

            <div class="form-field">
                <label for="current_password" class="form-label">Password saat ini</label>
                <input type="password" id="current_password" name="current_password" class="form-input" required>
                @error('current_password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="password" class="form-label">Password baru</label>
                <input type="password" id="password" name="password" class="form-input" required>
                @error('password')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="password_confirmation" class="form-label">Ulangi password baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
            </div>

            <button type="submit" class="btn-secondary">Ganti Password</button>
        </form>
    </div>

</div>
@endsection