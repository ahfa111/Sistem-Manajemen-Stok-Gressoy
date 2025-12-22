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
        <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-2"></i>Tambah Transaksi
        </button>
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
                                <button class="btn btn-sm btn-outline-warning me-1 btn-edit" 
                                    data-id="{{ $item->id }}"
                                    data-json="{{ json_encode($item) }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
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

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-2 mt-2">Tambah Transaksi</h5>
                <button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('keuangan.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tipe" value="Pengeluaran"> {{-- Default Pengeluaran per design --}}
                
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Tipe</label>
                        <input type="text" class="form-control bg-light border-0" value="Pengeluaran" readonly>
                        <input type="hidden" name="tipe" value="Pengeluaran">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Jumlah (RP)</label>
                        <input type="number" name="jumlah" class="form-control bg-light border-0" placeholder="Masukkan nominal" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Kategori</label>
                        <select name="kategori" class="form-select bg-light border-0" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Bahan Baku">Bahan Baku</option>
                            <option value="Bahan Tambahan">Bahan Tambahan</option>
                            <option value="Kemasan">Kemasan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control bg-light border-0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">ID</label>
                        <input type="text" name="kode" class="form-control bg-light border-0" placeholder="Contoh: TRX001" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control bg-light border-0" placeholder="Keterangan transaksi">
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-2 mt-2">Edit Transaksi</h5>
                <button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal"></button>
            </div>
            
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Tipe</label>
                        <input type="text" class="form-control bg-light border-0" value="Pengeluaran" readonly>
                        <input type="hidden" name="tipe" id="editTipe" value="Pengeluaran">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Jumlah (RP)</label>
                        <input type="number" name="jumlah" id="editJumlah" class="form-control bg-light border-0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Kategori</label>
                        <select name="kategori" id="editKategori" class="form-select bg-light border-0" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Bahan Baku">Bahan Baku</option>
                            <option value="Bahan Tambahan">Bahan Tambahan</option>
                            <option value="Kemasan">Kemasan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Tanggal</label>
                        <input type="date" name="tanggal" id="editTanggal" class="form-control bg-light border-0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">ID</label>
                        <input type="text" name="kode" id="editKode" class="form-control bg-light border-0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Deskripsi</label>
                        <input type="text" name="deskripsi" id="editDeskripsi" class="form-control bg-light border-0">
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT CHART & MODAL --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // EDIT MODAL LOGIC
    const editButtons = document.querySelectorAll('.btn-edit');
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
    const formEdit = document.getElementById('formEdit');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const data = JSON.parse(this.dataset.json);

            // Populate form
            document.getElementById('editTipe').value = data.tipe;
            document.getElementById('editJumlah').value = data.jumlah;
            document.getElementById('editKategori').value = data.kategori;
            document.getElementById('editTanggal').value = data.tanggal;
            document.getElementById('editKode').value = data.kode;
            document.getElementById('editDeskripsi').value = data.deskripsi;

            // Set Action URL
            formEdit.action = `/keuangan/${id}`;

            modalEdit.show();
        });
    });

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


