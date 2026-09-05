@extends('layouts.app')

@section('title', 'Produk Saya — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Produk Saya</h1>
        <p class="page-heading__sub">Kelola daftar produk tokomu.</p>
    </div>

    <div style="margin-bottom:16px">
        <a href="{{ route('toko.produks.create') }}" class="btn-primary btn-sm">+ Tambah Produk</a>
    </div>

    <div class="card-panel">
        @if($produks->count() > 0)
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="sr-only">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr>
                        <td style="font-weight:700">{{ $produk->nama_produk }}</td>
                        <td>{{ $produk->kategori?->nama ?? '—' }}</td>
                        <td>{{ $produk->formatHarga() }}</td>
                        <td>{{ $produk->stok }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('toko.produks.edit', $produk) }}" class="btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('toko.produks.destroy', $produk) }}"
                                      onsubmit="return confirm('Hapus produk {{ $produk->nama_produk }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:16px">
            {{ $produks->links() }}
        </div>
        @else
        <div class="empty-state" style="padding:24px">
            <p class="empty-state__body">Belum ada produk. Tambahkan produk pertamamu!</p>
        </div>
        @endif
    </div>

</div>
@endsection