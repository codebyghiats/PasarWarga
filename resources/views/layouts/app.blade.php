<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pasar Warga — temukan dan pesan produk dari UMKM sekitar tempat tinggalmu.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pasar Warga — Belanja dari Tetanggamu')</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>

    {{-- Top Bar --}}
    @include('components.topbar')

    {{-- Location Strip (optional per page) --}}
    @hasSection('location-strip')
        @yield('location-strip')
    @endif

    {{-- Flash Messages --}}
    <div class="container">
        @if(session('success'))
            <div class="flash flash--success" style="margin-top:12px">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash flash--error" style="margin-top:12px">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main id="main-content" role="main">
        @yield('content')
    </main>

    {{-- Bottom Tab Bar --}}
    @include('components.tab-bar', ['active' => $active ?? 'beranda'])

    @stack('scripts')
</body>
</html>
