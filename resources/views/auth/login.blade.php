@extends('layouts.auth')

@section('title', 'Masuk — Pasar Warga')
@section('auth-title', 'Masuk')
@section('auth-subtitle', 'Selamat datang kembali.')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-field">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-input"
                   value="{{ old('email') }}" required autofocus autocomplete="email"
                   placeholder="nama@contoh.com">
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-input"
                   required autocomplete="current-password" placeholder="••••••••">
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-field">
            <label class="form-check">
                <input type="checkbox" name="remember" value="1">
                <span>Ingat saya</span>
            </label>
        </div>

        <button type="submit" class="btn-primary btn-primary--block">Masuk</button>
    </form>

    <div class="auth-card__footer">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
@endsection