@extends('layouts.app')

@section('title', ($toko ? 'Edit Profil Toko' : 'Daftarkan Tokomu') . ' — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">{{ $toko ? 'Edit Profil Toko' : 'Daftarkan Tokomu' }}</h1>
        <p class="page-heading__sub">
            {{ $toko ? 'Perbarui informasi tokomu.' : 'Lengkapi info tokomu. Setelah disimpan, toko menunggu persetujuan admin.' }}
        </p>
    </div>

    <div class="card-panel">
        <form method="POST"
              action="{{ $toko ? route('toko.profil.update') : route('toko.profil.simpan') }}"
              enctype="multipart/form-data">
            @csrf
            @if($toko)
                @method('PUT')
            @endif

            <div class="form-field">
                <label for="nama_toko" class="form-label">Nama toko</label>
                <input type="text" id="nama_toko" name="nama_toko" class="form-input"
                       value="{{ old('nama_toko', $toko?->nama_toko) }}" required placeholder="Contoh: Warung Bu Sari">
                @error('nama_toko')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="form-textarea"
                          placeholder="Ceritakan sedikit tentang tokomu...">{{ old('deskripsi', $toko?->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="lokasi" class="form-label">Lokasi</label>
                <input type="text" id="lokasi" name="lokasi" class="form-input"
                       value="{{ old('lokasi', $toko?->lokasi) }}" required
                       placeholder="Contoh: Kel. Sukamaju, Kec. Sukamaju">
                <p class="form-hint">Kelurahan / kecamatan tempat tokomu berada.</p>
                @error('lokasi')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                <input type="tel" id="no_wa" name="no_wa" class="form-input"
                       value="{{ old('no_wa', $toko?->no_wa) }}" placeholder="81234567890 (tanpa 0 di depan)">
                <p class="form-hint">Dipakai untuk tombol "Hubungi via WhatsApp".</p>
                @error('no_wa')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="foto" class="form-label">Foto toko (opsional)</label>
                <input type="file" id="foto" name="foto" class="form-input" accept="image/jpeg,image/png,image/webp">
                @if($toko?->foto)
                    <p class="form-hint">Foto saat ini tersimpan. Pilih file baru untuk menggantinya.</p>
                @endif
                @error('foto')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary">
                {{ $toko ? 'Simpan Perubahan' : 'Daftarkan Toko' }}
            </button>
            <a href="{{ route('toko.dashboard') }}" class="btn-secondary" style="margin-left:8px">Batal</a>
        </form>
    </div>

</div>
@endsection