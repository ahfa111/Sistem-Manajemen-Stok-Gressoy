<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Manajemen Stok</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Login -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">

        <h2 class="auth-title">Sistem Informasi Manajemen Stok</h2>
        <p class="auth-subtitle">Gressoy Plant Based Milk</p>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-submit">Login</button>
        </form>

        <p class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Buat Akun</a>
        </p>

    </div>
</div>

</body>
</html>
