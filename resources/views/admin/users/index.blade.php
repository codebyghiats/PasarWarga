@extends('layouts.app')

@section('title', 'Kelola Pengguna — Pasar Warga')

@section('content')
<div class="container">

    <div class="page-heading" style="margin-top:20px">
        <h1 class="page-heading__title">Pengguna</h1>
        <p class="page-heading__sub">Semua akun terdaftar di platform.</p>
    </div>

    <div class="card-panel">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Toko</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td style="font-weight:700">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge badge--{{ $user->role === 'admin' ? 'approved' : ($user->role === 'pemilik_toko' ? 'pending' : 'dikonfirmasi') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>{{ $user->toko?->nama_toko ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top:24px">
        {{ $users->links() }}
    </div>

</div>
@endsection