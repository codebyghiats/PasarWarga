@extends('layouts.app')

@section('title', 'Tambah Produk — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Tambah Produk</h1>
    </div>

    <div class="card-panel">
        <form method="POST" action="{{ route('toko.produks.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-field">
                <label for="nama_produk" class="form-label">Nama produk</label>
                <input type="text" id="nama_produk" name="nama_produk" class="form-input"
                       value="{{ old('nama_produk') }}" required placeholder="Contoh: Nasi Kuning Spesial">
                @error('nama_produk')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-textarea"
                          placeholder="Bahan, rasa, porsi...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select id="kategori_id" name="kategori_id" class="form-select" required>
                    <option value="" disabled {{ !old('kategori_id') ? 'selected' : '' }}>Pilih kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ (string) old('kategori_id') === (string) $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="harga" class="form-label">Harga (Rp)</label>
                <input type="number" id="harga" name="harga" class="form-input"
                       value="{{ old('harga') }}" required min="1" placeholder="15000">
                @error('harga')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" id="stok" name="stok" class="form-input"
                       value="{{ old('stok', 0) }}" required min="0">
                @error('stok')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="foto" class="form-label">Foto produk (opsional)</label>
                <input type="file" id="foto" name="foto" class="form-input" accept="image/jpeg,image/png,image/webp">
                @error('foto')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary">Simpan Produk</button>
            <a href="{{ route('toko.produks.index') }}" class="btn-secondary" style="margin-left:8px">Batal</a>
        </form>
    </div>

</div>
@endsection