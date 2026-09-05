@extends('layouts.app')

@section('title', 'Edit Kategori — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Edit Kategori</h1>
    </div>

    <div class="card-panel">
        <form method="POST" action="{{ route('admin.kategoris.update', $kategori) }}">
            @csrf
            @method('PUT')

            <div class="form-field">
                <label for="nama" class="form-label">Nama kategori</label>
                <input type="text" id="nama" name="nama" class="form-input"
                       value="{{ old('nama', $kategori->nama) }}" required>
                @error('nama')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="icon" class="form-label">Icon</label>
                <input type="text" id="icon" name="icon" class="form-input"
                       value="{{ old('icon', $kategori->icon) }}">
                <p class="form-hint">makanan, minuman, snack, sayuran, rumah tangga, fashion, kecantikan</p>
                @error('icon')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary">Perbarui Kategori</button>
            <a href="{{ route('admin.kategoris.index') }}" class="btn-secondary" style="margin-left:8px">Batal</a>
        </form>
    </div>

</div>
@endsection