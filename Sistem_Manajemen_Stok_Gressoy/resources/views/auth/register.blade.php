<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Sistem Informasi Manajemen Stok</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Login -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-card">

        <h2 class="auth-title">Buat Akun Baru</h2>
        <p class="auth-subtitle">Daftar untuk mengakses sistem</p>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" value="{{ old('username') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" placeholder="Masukkan konfirmasi password" required>
            </div>

            <button type="submit" class="btn-submit">Daftar</button>
        </form>

        <p class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk Sini</a>
        </p>

    </div>
</div>

</body>
</html>
