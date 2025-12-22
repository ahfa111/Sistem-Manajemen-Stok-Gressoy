<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Gressoy') }} - Sistem Manajemen Stok</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-green: #2ecc71;
            --dark-green: #27ae60;
            --text-dark: #333;
            --text-light: #888;
            --bg-light: #f5f6fa;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background-color: #ffffff;
            position: fixed;
            height: 100vh;
            border-right: 1px solid #eee;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            padding: 30px 25px;
        }

        .brand-section {
            margin-bottom: 30px;
        }

        .brand-name {
            font-size: 24px;
            font-weight: 800;
            color: #000;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 13px;
            color: #888;
            font-weight: 500;
        }

        .user-section {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 0;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #e0e0e0;
            margin-right: 15px;
            /* Placeholder for user image */
        }

        .user-info .user-email {
            font-size: 12px;
            font-weight: 600;
            color: #000;
        }

        .user-info .user-name {
            font-size: 12px;
            color: #888;
        }

        /* NAVIGATION */
        .nav-menu {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .nav-item-custom {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 10px;
            text-decoration: none;
            color: #000;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
        }

        .nav-item-custom:hover {
            background-color: #f0f0f0;
        }

        .nav-item-custom.active {
            background-color: var(--primary-green);
            color: #fff;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.2);
        }

        .nav-icon {
            width: 24px;
            margin-right: 15px;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-item-custom.logout {
            color: #ff4757;
            margin-top: auto;
            font-weight: 600;
        }

        .nav-item-custom.logout:hover {
            background-color: #fee;
        }

        /* MAIN CONTENT */
        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 40px;
        }

        /* RESPONSIVE */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .content-wrapper {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <div class="app-wrapper">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <!-- Brand -->
            <div class="brand-section">
                <div class="brand-name">Gressoy</div>
                <div class="brand-subtitle">Sistem Manajemen Stok</div>
            </div>

            <!-- User -->
            <div class="user-section">
                <div class="user-avatar"></div> <!-- Placeholder Avatar -->
                <div class="user-info">
                    @auth
                        <div class="user-email">{{ auth()->user()->email }}</div>
                        <div class="user-name">{{ auth()->user()->name }}</div>
                    @else
                        <div class="user-email">Guest</div>
                    @endauth
                </div>
            </div>

            <!-- Menu -->
            <nav class="nav-menu">
                <a href="{{ route('dashboard') }}" class="nav-item-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="bi bi-grid-fill"></i></div>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('keuangan.index') }}" class="nav-item-custom {{ request()->routeIs('keuangan.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="bi bi-currency-dollar"></i></div>
                    <span>Keuangan</span>
                </a>

                <a href="{{ route('bahan-baku.index') }}" class="nav-item-custom {{ request()->routeIs('bahan-baku.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="bi bi-box-seam-fill"></i></div>
                    <span>Bahan Baku</span>
                </a>

                <a href="{{ route('laporan.index') }}" class="nav-item-custom {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="bi bi-file-text-fill"></i></div>
                    <span>Laporan</span>
                </a>

                <a href="{{ route('pengaturan.index') }}" class="nav-item-custom {{ Request::routeIs('pengaturan.*') ? 'active' : '' }}">
                    <div class="nav-icon"><i class="bi bi-gear"></i></div>
                    <span>Pengaturan</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="nav-item-custom logout w-100 border-0 bg-transparent text-start p-2">
                        <div class="nav-icon"><i class="bi bi-box-arrow-left"></i></div>
                        <span>Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- CONTENT -->
        <div class="content-wrapper">
            <main class="main-content">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


