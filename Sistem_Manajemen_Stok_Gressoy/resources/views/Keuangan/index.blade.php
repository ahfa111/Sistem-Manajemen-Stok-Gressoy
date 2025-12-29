@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/keuangan.css') }}">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="keuangan-container">
    {{-- HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 class="fw-bold mb-1">Keuangan Pembelian Bahan Baku</h2>
            <p class="text-muted mb-0">Kelola Pengeluaran Pembelian Bahan Baku perusahaan</p>
        </div>
        <a href="{{ route('keuangan.create') }}" class="btn btn-success rounded-pill px-4">
            <i class="bi bi-plus-lg me-2"></i>Tambah Transaksi
        </a>
    </div>

    {{-- SUMMARY CARD --}}
    <div class="card border-0 shadow-sm mb-4 summary-card">
        <div class="card-body d-flex align-items-center p-4">
            <div class="icon-box bg-light text-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-arrow-up-circle-fill fs-3"></i>
            </div>
            <div>
                <p class="text-muted mb-1 fw-bold">Total Pengeluaran Pembelian Bahan Baku</p>
                <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- CHARTS ROW --}}
    <div class="row mb-4">
        {{-- LINE CHART --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Pengeluaran Pembelian Bahan Baku</h5>
                    <div style="height: 300px;">
                        <canvas id="pengeluaranChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- BAR CHART --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Perbandingan Bulanan</h5>
                    <div style="height: 300px;">
                        <canvas id="perbandinganChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Daftar Transaksi Pembelian</h5>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 ps-3">Tanggal</th>
                            <th class="py-3">ID</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Deskripsi</th>
                            <th class="py-3">Jumlah (Rp)</th>
                            <th class="py-3 pe-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="ps-3">{{ $item->tanggal }}</td>
                            <td class="fw-bold text-primary">{{ $item->kode }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $item->kategori }}</span></td>
                            <td>{{Str::limit($item->deskripsi, 30)}}</td>
                            <td class="fw-bold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td class="text-end pe-3">
                                <a href="{{ route('keuangan.edit', $item->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus transaksi this?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT CHART --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const months = @json($months);
    const pengeluaran = @json($pengeluaranPerBulan);

    // Contexts
    const ctx1 = document.getElementById('pengeluaranChart').getContext('2d');
    const ctx2 = document.getElementById('perbandinganChart').getContext('2d');

    // Line Chart
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: months.length ? months : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
            datasets: [
                {
                    label: 'Pengeluaran',
                    data: pengeluaran.length ? pengeluaran : [20000000, 22000000, 1800000, 25000000, 19000000],
                    borderColor: '#e67e22', // Orange
                    backgroundColor: 'rgba(230, 126, 34, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            scales: {
                y: { grid: { borderDash: [5, 5] }, ticks: { callback: val => 'Rp ' + val/1000 + 'k' } },
                x: { grid: { display: false } }
            }
        }
    });

    // Bar Chart
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: months.length ? months : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
            datasets: [
                {
                    label: 'Pengeluaran',
                    data: pengeluaran.length ? pengeluaran : [20000000, 22000000, 1800000, 25000000, 19000000],
                    backgroundColor: '#e67e22',
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } },
            scales: {
                 y: { display: false },
                 x: { grid: { display: false } }
            }
        }
    });

    // Success Modal Check
    @if(session('success'))
        // Optional: Trigger a success modal or toast here if specific success UI is needed
    @endif
});
</script>
@endsection


