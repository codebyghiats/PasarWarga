<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pasar Warga — Belanja dari Tetanggamu.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pasar Warga')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="no-tab-bar">

    <div class="auth-container">
        <div class="auth-card">
            <a href="{{ route('home') }}" class="auth-card__brand" style="display:block;text-align:center;margin-bottom:16px;">
                <span style="font-size:22px;font-weight:700;color:var(--color-primary-deep);letter-spacing:-0.02em;">
                    Pasar Warga
                </span>
            </a>

            <h1 class="auth-card__title">@yield('auth-title')</h1>
            <p class="auth-card__subtitle">@yield('auth-subtitle', 'Masuk untuk melanjutkan belanja.')</p>

            @if(session('error'))
                <div class="flash flash--error" style="margin-bottom:16px">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="flash flash--error" style="margin-bottom:16px;flex-direction:column;gap:4px">
                    @foreach ($errors->all() as $err)
                        <span>{{ $err }}</span>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>