@extends('layouts.app')

@section('title', 'Tambah Kategori — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Tambah Kategori</h1>
    </div>

    <div class="card-panel">
        <form method="POST" action="{{ route('admin.kategoris.store') }}">
            @csrf

            <div class="form-field">
                <label for="nama" class="form-label">Nama kategori</label>
                <input type="text" id="nama" name="nama" class="form-input"
                       value="{{ old('nama') }}" required placeholder="Contoh: Makanan">
                @error('nama')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="icon" class="form-label">Icon (opsional)</label>
                <input type="text" id="icon" name="icon" class="form-input"
                       value="{{ old('icon') }}" placeholder="makanan, minuman, snack, sayuran, rumah tangga, fashion, kecantikan">
                <p class="form-hint">Kunci icon yang didukung: makanan, minuman, snack, sayuran, rumah tangga, fashion, kecantikan.</p>
                @error('icon')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary">Simpan Kategori</button>
            <a href="{{ route('admin.kategoris.index') }}" class="btn-secondary" style="margin-left:8px">Batal</a>
        </form>
    </div>

</div>
@endsection