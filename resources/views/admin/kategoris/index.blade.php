@extends('layouts.app')

@section('title', 'Kelola Kategori — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Kategori</h1>
        <p class="page-heading__sub">Kelola kategori produk.</p>
    </div>

    <div style="margin-bottom:16px">
        <a href="{{ route('admin.kategoris.create') }}" class="btn-primary btn-sm">
            + Tambah Kategori
        </a>
    </div>

    <div class="card-panel">
        @if($kategoris->count() > 0)
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Icon</th>
                        <th>Jumlah Produk</th>
                        <th class="sr-only">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoris as $kategori)
                    <tr>
                        <td style="font-weight:700">{{ $kategori->nama }}</td>
                        <td>
                            <span style="display:inline-flex;color:var(--color-primary)">
                                @include('components.category-icon', ['icon' => $kategori->icon])
                            </span>
                        </td>
                        <td>{{ $kategori->produks_count }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.kategoris.edit', $kategori) }}" class="btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('admin.kategoris.destroy', $kategori) }}"
                                      onsubmit="return confirm('Hapus kategori ini?')">
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
        @else
        <div class="empty-state" style="padding:24px">
            <p class="empty-state__body">Belum ada kategori.</p>
        </div>
        @endif
    </div>

</div>
@endsection