@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 class="fw-bold mb-1">Dashboard</h2>
            <p class="text-muted mb-0">Selamat datang di Sistem Informasi Manajemen Stok Gressoy - Susu Kedelai Premium</p>
        </div>
    </div>

    <!-- CARDS -->
    <div class="row g-4 mb-5">
        <!-- Card 1 -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box bg-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                    <i class="bi bi-arrow-up-right text-success"></i>
                </div>
                <h5 class="fw-bold mb-1">Rp 45.000.000</h5>
                <p class="text-muted small mb-2">Total Pembelian Bahan Baku</p>
                <small class="text-success fw-bold">+ 12,5 %</small>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box bg-light text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <i class="bi bi-arrow-down-right text-warning"></i>
                </div>
                <h5 class="fw-bold mb-1">1,248</h5>
                <p class="text-muted small mb-2">Stok produk tersedia</p>
                <small class="text-danger fw-bold">-5,2%</small>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box bg-light text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-cart fs-4"></i>
                    </div>
                    <i class="bi bi-arrow-up-right text-success"></i>
                </div>
                <h5 class="fw-bold mb-1">89</h5>
                <p class="text-muted small mb-2">Penambahan Bahan Baku</p>
                <small class="text-success fw-bold">+ 8.1%</small>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 p-3" style="border-radius: 15px;">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="icon-box bg-light text-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-exclamation-circle fs-4"></i>
                    </div>
                    <i class="bi bi-exclamation-circle text-danger"></i>
                </div>
                <h5 class="fw-bold mb-1">12</h5>
                <p class="text-muted small mb-2">Bahan Baku Menipis</p>
                <small class="text-danger fw-bold">Perlu Restock</small>
            </div>
        </div>
    </div>

    <!-- CHART -->
    <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
        <h5 class="fw-bold mb-4">Total Pembelian bahan baku Perbulan</h5>
        <div style="height: 400px;">
            <canvas id="pembelianChart"></canvas>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('pembelianChart').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(153, 102, 255, 0.8)'); // Purple top
    gradient.addColorStop(1, 'rgba(153, 102, 255, 0.2)'); // Purple bottom

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli'],
            datasets: [{
                label: 'Pembelian Bahan Baku',
                data: [2500000, 6000000, 5800000, 6000000, 9000000, 7800000, 3200000],
                backgroundColor: '#9b88ff',
                borderRadius: 5,
                barPercentage: 0.7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        borderDash: [5, 5],
                        color: '#f0f0f0'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('id-ID'); // Format Y axis
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endsection
