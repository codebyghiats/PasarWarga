@extends('layouts.app')

@section('title', 'Checkout — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Checkout</h1>
        <p class="page-heading__sub">Lengkapi detail pengirimanmu.</p>
    </div>

    <form method="POST" action="{{ route('pesanan.store') }}">
        @csrf

        {{-- Delivery details --}}
        <div class="card-panel">
            <p class="card-panel__title">Detail Penerima</p>

            <div class="form-field">
                <label for="nama_penerima" class="form-label">Nama penerima</label>
                <input type="text" id="nama_penerima" name="nama_penerima" class="form-input"
                       value="{{ old('nama_penerima', auth()->user()->name) }}" required>
                @error('nama_penerima')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="alamat_pengiriman" class="form-label">Alamat pengiriman</label>
                <textarea id="alamat_pengiriman" name="alamat_pengiriman" class="form-textarea"
                          required placeholder="Jalan, RT/RW, kelurahan, kecamatan, kota...">{{ old('alamat_pengiriman') }}</textarea>
                @error('alamat_pengiriman')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-field">
                <label for="catatan" class="form-label">Catatan (opsional)</label>
                <textarea id="catatan" name="catatan" class="form-textarea"
                          style="min-height:64px" placeholder="Contoh: antar sebelum jam 5 sore">{{ old('catatan') }}</textarea>
                @error('catatan')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Order summary --}}
        <div class="card-panel" style="margin-top:16px">
            <p class="card-panel__title">Ringkasan Pesanan</p>
            @foreach($items as $line)
                @php $produk = $line['produk']; @endphp
                <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--color-border);font-size:14px">
                    <div>
                        <span style="font-weight:700">{{ $produk->nama_produk }}</span>
                        <span style="color:var(--color-text-secondary)"> × {{ $line['qty'] }}</span>
                    </div>
                    <span style="font-weight:700">{{ format_rupiah($line['subtotal']) }}</span>
                </div>
            @endforeach

            <div class="total-row" style="padding-bottom:0">
                <span>Total</span>
                <span class="total-row__value">{{ format_rupiah($total) }}</span>
            </div>
        </div>

        <button type="submit" class="btn-primary btn-primary--block" style="margin-top:20px">
            Buat Pesanan
        </button>
    </form>

</div>
@endsection