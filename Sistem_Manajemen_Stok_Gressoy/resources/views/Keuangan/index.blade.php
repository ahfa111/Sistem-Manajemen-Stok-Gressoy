<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Keuangan Pembelian Bahan Baku - Gressoy</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f5f5;
            display: flex;
        }

        .sidebar {
            width: 200px;
            background: white;
            min-height: 100vh;
            padding: 20px;
            border-right: 1px solid #e0e0e0;
            position: fixed;
            left: 0;
            top: 0;
        }

        .logo-section {
            margin-bottom: 40px;
        }

        .logo-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .logo-subtitle {
            font-size: 11px;
            color: #666;
            line-height: 1.4;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-weight: 600;
        }

        .user-details {
            flex: 1;
        }

        .user-email {
            font-size: 11px;
            color: #666;
        }

        .user-name {
            font-size: 12px;
            color: #333;
            font-weight: 500;
            margin-top: 2px;
        }

        .menu {
            margin-top: 30px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            margin-bottom: 5px;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .menu-item:hover {
            background: #f0f0f0;
        }

        .menu-item.active {
            background: #2ecc71;
            color: white;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
        }

        .logout {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: #e74c3c;
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            text-align: left;
        }

        .logout-btn:hover {
            background: #fee;
        }

        .main-content {
            flex: 1;
            margin-left: 200px;
            padding: 30px 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .header-subtitle {
            font-size: 13px;
            color: #666;
        }

        .add-btn {
            background: #2ecc71;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .add-btn:hover {
            background: #27ae60;
            transform: translateY(-1px);
        }

        .summary-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: 1px solid #e8e8e8;
        }

        .summary-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
        }

        .summary-icon {
            width: 45px;
            height: 45px;
            background: #e8f8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2ecc71;
        }

        .summary-label {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
        }

        .summary-amount {
            font-size: 22px;
            font-weight: 700;
            color: #2ecc71;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: 1px solid #e8e8e8;
        }

        .chart-title {
            font-size: 15px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        .chart-container {
            position: relative;
            height: 300px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-section">
            <div class="logo-title">Gressoy</div>
            <div class="logo-subtitle">Sistem Manajemen Stok</div>
            
            <div class="user-info">
                <div class="user-avatar">👤</div>
                <div class="user-details">
                    <div class="user-email">Enan@gmail.com</div>
                    <div class="user-name">Shanyesha Erlend Wijayina</div>
                </div>
            </div>
        </div>

        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="menu-item">
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('keuangan.index') }}" class="menu-item active">
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                Keuangan
            </a>

            <a href="{{ route('bahan-baku') }}" class="menu-item">
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
                Bahan Baku
            </a>

            <a href="{{ route('laporan') }}" class="menu-item">
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="9" y1="15" x2="15" y2="15"></line>
                    <line x1="9" y1="12" x2="15" y2="12"></line>
                </svg>
                Laporan
            </a>

            <a href="{{ route('pengaturan') }}" class="menu-item">
                <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M12 1v6m0 6v6"></path>
                    <path d="m4.93 4.93 4.24 4.24m5.66 5.66 4.24 4.24"></path>
                    <path d="M1 12h6m6 0h6"></path>
                    <path d="m4.93 19.07 4.24-4.24m5.66-5.66 4.24-4.24"></path>
                </svg>
                Pengaturan
            </a>
        </nav>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" onclick="return confirm('Yakin ingin keluar?')">
                    <svg class="menu-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div>
                <h1 class="header-title">Keuangan Pembelian Bahan Baku</h1>
                <p class="header-subtitle">Kelola Pengeluaran dan Pembelian Bahan Baku perusahaan</p>
            </div>
            <button class="add-btn" onclick="alert('Fitur tambah transaksi akan segera tersedia')">
                <span style="font-size: 18px;">+</span>
                Tambah Transaksi
            </button>
        </div>

        @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
        @endif

        <!-- Total Pengeluaran -->
        <div class="summary-card">
            <div class="summary-header">
                <div class="summary-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>
                        <path d="M12 18V6"></path>
                    </svg>
                </div>
            </div>
            <div class="summary-label">Total Pengeluaran Pembelian Bahan Baku</div>
            <div class="summary-amount">Rp. {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
        </div>

        <!-- Line Chart - Pengeluaran Pembelian Bahan Baku -->
        <div class="chart-card">
            <h2 class="chart-title">Pengeluaran Pembelian Bahan Baku</h2>
            <div class="chart-container">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart - Perbandingan Bulanan -->
        <div class="chart-card">
            <h2 class="chart-title">Perbandingan Bulanan</h2>
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Data dari Laravel Controller
        const dataPengeluaran = @json($dataPengeluaran);
        const dataPerbandingan = @json($dataPerbandingan);

        // Line Chart - Sesuai Design
        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: dataPengeluaran.map(d => d.bulan),
                datasets: [
                    {
                        label: 'Pembelian',
                        data: dataPengeluaran.map(d => d.pembelian),
                        borderColor: '#2ecc71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: '#2ecc71',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Pengeluaran',
                        data: dataPengeluaran.map(d => d.pengeluaran),
                        borderColor: '#f39c12',
                        backgroundColor: 'rgba(243, 156, 18, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointBackgroundColor: '#f39c12',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 13
                        },
                        bodyFont: {
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000) + 'jt';
                            },
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        // Bar Chart - Sesuai Design
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: dataPerbandingan.map(d => d.bulan),
                datasets: [
                    {
                        label: 'Pembelian',
                        data: dataPerbandingan.map(d => d.pembelian),
                        backgroundColor: '#2ecc71',
                        borderRadius: 6,
                        borderSkipped: false
                    },
                    {
                        label: 'Pengeluaran',
                        data: dataPerbandingan.map(d => d.pengeluaran),
                        backgroundColor: '#f39c12',
                        borderRadius: 6,
                        borderSkipped: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 13
                        },
                        bodyFont: {
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000) + 'jt';
                            },
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>