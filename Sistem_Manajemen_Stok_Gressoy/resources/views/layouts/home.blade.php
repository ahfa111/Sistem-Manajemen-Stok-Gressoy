<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Gressoy')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>

{{-- NAVBAR --}}
<header class="navbar">
    <div class="brand">
        <!-- <img src="{{ asset('images/logo.png') }}" alt="GrekSOY Logo" style="height: 40px; margin-right: 10px;"> -->
        <div class="brand-text">
            <span class="brand-title">Gre<span style="color:#f0a500">s</span>SOY</span><br>
            <span class="brand-subtitle">Sistem Informasi<br>Manajemen Stok Gressoy</span>
        </div>
    </div>

    <nav class="menu">
        <a href="{{ route('home') }}" class="nav-link">Beranda</a>
        <a href="#" class="nav-link">FAQ</a>
        <a href="{{ route('login') }}" class="btn-login">LOGIN</a>
    </nav>
</header>

{{-- CONTENT --}}
@yield('content')

{{-- FOOTER --}}
<footer class="footer">
    Gressoy Stock Management Information System — Purwokerto Timur
</footer>

</body>
</html>
