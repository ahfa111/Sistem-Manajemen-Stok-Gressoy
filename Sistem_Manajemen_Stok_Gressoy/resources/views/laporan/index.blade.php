@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/laporan.css') }}">

<div class="laporan-container">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1">Laporan</h2>
            <p class="text-muted mb-0">Analisis dan laporan bisnis</p>
        </div>
        <button class="btn btn-success rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalSimpanPDF">
            <i class="bi bi-download me-2"></i>Simpan PDF
        </button>
    </div>

    {{-- STATS ROW --}}
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="stats-card-laporan">
                <div class="label">Total Pembelian Barang</div>
                <div class="value">Rp. {{ number_format($totalPembelian, 0, ',', '.') }}</div>
                <div class="trend text-success"><i class="bi bi-arrow-up-right me-1"></i>+ 12,5%</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card-laporan">
                <div class="label">Total Barang Keluar</div>
                <div class="value">{{ $totalBarangKeluar }} Unit</div>
                <div class="trend text-secondary">Stabil</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card-laporan">
                <div class="label">Periode</div>
                <div class="value">Bulan Ini</div>
                <div class="trend text-secondary">Update Realtime</div>
            </div>
        </div>
    </div>

    {{-- CHART SECTION Placeholder --}}
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Pengeluaran Pembelian Bahan Baku</h5>
            <canvas id="laporanChart" height="100"></canvas>
        </div>
    </div>

    {{-- RIWAYAT LAPORAN (CRUD Table) --}}
    <div class="card history-card">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-4">Riwayat Laporan Tersimpan</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Judul Laporan</th>
                            <th>Periode</th>
                            <th>Total Pembelian</th>
                            <th>Barang Keluar</th>
                            <th>Tanggal Dibuat</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                        <tr>
                            <td class="fw-bold">{{ $laporan->judul }}</td>
                            <td><span class="badge bg-secondary">{{ $laporan->periode }}</span></td>
                            <td>Rp. {{ number_format($laporan->total_pembelian, 0, ',', '.') }}</td>
                            <td>{{ $laporan->total_barang_keluar }} Unit</td>
                            <td class="small text-muted">{{ $laporan->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-warning me-1 btn-edit-laporan"
                                    data-id="{{ $laporan->id }}"
                                    data-json="{{ json_encode($laporan) }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
                                <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus laporan ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada laporan yang disimpan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL SIMPAN PDF (CRUD INPUT) --}}
<div class="modal fade" id="modalSimpanPDF" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-3 mt-3">Simpan Laporan Baru</h5>
                <button type="button" class="btn-close me-3 mt-3" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('laporan.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Judul Laporan</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Laporan Keuangan Sept 2024" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Periode</label>
                        <select name="periode" class="form-select">
                            <option value="Mingguan">Mingguan</option>
                            <option value="Bulanan">Bulanan</option>
                            <option value="Tahunan">Tahunan</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Total Pembelian (Rp)</label>
                            <input type="number" name="total_pembelian" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Total Barang Keluar (Unit)</label>
                            <input type="number" name="total_barang_keluar" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Catatan Tambahan</label>
                        <textarea name="catatan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="bi bi-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT LAPORAN --}}
<div class="modal fade" id="modalEditLaporan" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-3 mt-3">Edit Laporan</h5>
                <button type="button" class="btn-close me-3 mt-3" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditLaporan" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Judul Laporan</label>
                        <input type="text" name="judul" id="editJudul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Periode</label>
                        <select name="periode" id="editPeriode" class="form-select">
                            <option value="Mingguan">Mingguan</option>
                            <option value="Bulanan">Bulanan</option>
                            <option value="Tahunan">Tahunan</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Total Pembelian (Rp)</label>
                            <input type="number" name="total_pembelian" id="editTotalPembelian" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-muted">Total Barang Keluar (Unit)</label>
                            <input type="number" name="total_barang_keluar" id="editTotalBarangKeluar" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Catatan Tambahan</label>
                        <textarea name="catatan" id="editCatatan" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">
                        <i class="bi bi-save me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // EDIT MODAL LOGIC FOR LAPORAN
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.btn-edit-laporan');
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEditLaporan'));
        const formEdit = document.getElementById('formEditLaporan');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const data = JSON.parse(this.dataset.json);

                document.getElementById('editJudul').value = data.judul;
                document.getElementById('editPeriode').value = data.periode;
                document.getElementById('editTotalPembelian').value = data.total_pembelian;
                document.getElementById('editTotalBarangKeluar').value = data.total_barang_keluar;
                document.getElementById('editCatatan').value = data.catatan;

                formEdit.action = `/laporan/${id}`;
                modalEdit.show();
            });
        });
    });

    // Simple Chart for Visual
    const ctx = document.getElementById('laporanChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Pembelian (Rp)',
                data: [12000000, 19000000, 30000000, 5000000, 2000000, 3000000],
                backgroundColor: '#a29bfe',
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection