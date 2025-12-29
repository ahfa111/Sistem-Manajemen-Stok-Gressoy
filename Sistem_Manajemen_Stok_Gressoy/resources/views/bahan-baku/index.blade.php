@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/bahan-baku.css') }}">

<div class="bahan-baku-container">
    {{-- HEADER --}}
    <div class="page-header d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 class="fw-bold mb-1">Bahan Baku</h2>
            <p class="text-muted mb-0">Kelola Bahan Baku Stok Produksi</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary text-white rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahStok">
                 <i class="bi bi-cart-plus me-2"></i>Restock
            </button>
            <button class="btn btn-warning text-white rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalKurangStok">
                 <i class="bi bi-dash-lg me-2"></i>Kurang Bahan Baku
            </button>
            <a href="{{ route('bahan-baku.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Tambah Bahan Baku
            </a>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="icon-box-stats bg-light text-success me-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 small fw-bold">Total Bahan Baku</p>
                        <h4 class="fw-bold mb-0">{{ $totalItem }} Item</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="icon-box-stats bg-light text-secondary me-3">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 small fw-bold">Stok Normal</p>
                        <h4 class="fw-bold mb-0">{{ $stokNormal }} Item</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stats-card shadow-sm h-100">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="icon-box-stats bg-light text-danger me-3">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1 small fw-bold">Stok Menipis</p>
                        <h4 class="fw-bold mb-0">{{ $stokMenipis }} Item</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if($stokMenipis > 0)
    <div class="alert alert-custom d-flex align-items-center mb-4 shadow-sm border-0" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
        <div>
            <div class="fw-bold">Peringatan Stok Menipis</div>
            <div class="small">{{ $stokMenipis }} Bahan baku memerlukan restok segera</div>
        </div>
    </div>
    @endif

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Daftar Bahan Baku</h5>
                {{-- Filter/Search placeholder if needed --}}
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Terakhir Restok</th>
                            <th>Harga (Rp)</th>
                            <th>Supplier</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $item->kode_bahan }}</td>
                            <td class="fw-semibold">{{ $item->nama_bahan }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $item->kategori }}</span></td>
                            <td class="{{ $item->stok_tersedia < $item->stok_minimum ? 'text-danger fw-bold' : '' }}">
                                {{ $item->stok_tersedia }} {{ $item->satuan }}
                            </td>
                            <td class="text-muted small">
                                {{ $item->terakhir_restok ? \Carbon\Carbon::parse($item->terakhir_restok)->format('d M Y') : '-' }}
                            </td>
                            <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-muted small">{{ $item->supplier ?? '-' }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('bahan-baku.edit', $item->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('bahan-baku.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Belum ada data bahan baku.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH STOK --}}
<div class="modal fade" id="modalTambahStok" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-3 mt-3">Restock (Tambah Stok)</h5>
                <button type="button" class="btn-close me-3 mt-3" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('bahan-baku.tambahStok') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info small mb-4">
                        <i class="bi bi-info-circle me-1"></i>
                        Harga rata-rata akan otomatis disesuaikan jika harga beli baru berbeda dari harga saat ini.
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small">Nama / ID Barang</label>
                            <select name="id" id="tambahId" class="form-select" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($data as $item)
                                    <option value="{{ $item->id }}" 
                                        data-kategori="{{ $item->kategori }}"
                                        data-satuan="{{ $item->satuan }}"
                                        data-harga="{{ $item->harga_satuan }}">
                                        {{ $item->kode_bahan }} - {{ $item->nama_bahan }} (Rp {{ number_format($item->harga_satuan, 0, ',', '.') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Kategori</label>
                            <input type="text" id="tambahKategori" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Satuan</label>
                            <input type="text" id="tambahSatuan" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Jumlah Stok Baru</label>
                            <input type="number" step="0.01" name="jumlah" class="form-control" placeholder="Masukkan jumlah stok baru" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Harga Beli Baru (per Unit)</label>
                            <input type="number" name="harga_baru" id="tambahHarga" class="form-control" placeholder="Masukkan harga beli baru" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 pe-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan & Hitung</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL KURANG STOK --}}
<div class="modal fade" id="modalKurangStok" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-3 mt-3">Kurang Bahan Baku</h5>
                <button type="button" class="btn-close me-3 mt-3" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('bahan-baku.kurangStok') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small">Nama / ID Barang</label>
                            <select name="id" id="kurangId" class="form-select" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($data as $item)
                                    <option value="{{ $item->id }}" 
                                        data-kategori="{{ $item->kategori }}"
                                        data-satuan="{{ $item->satuan }}"
                                        data-stok="{{ $item->stok_tersedia }}">
                                        {{ $item->kode_bahan }} - {{ $item->nama_bahan }} (Stok: {{ $item->stok_tersedia }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Kategori</label>
                            <input type="text" id="kurangKategori" class="form-control" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Satuan</label>
                            <input type="text" id="kurangSatuan" class="form-control" readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small">Jumlah</label>
                            <input type="number" step="0.01" name="jumlah" class="form-control" placeholder="Masukkan jumlah yang dikurangi" required>
                        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // KURANG STOK LOGIC
    const selectBarang = document.getElementById('kurangId');
    const inputKategori = document.getElementById('kurangKategori');
    const inputSatuan = document.getElementById('kurangSatuan');

    selectBarang.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            inputKategori.value = selectedOption.dataset.kategori;
            inputSatuan.value = selectedOption.dataset.satuan;
        } else {
            inputKategori.value = '';
            inputSatuan.value = '';
        }
    });

    // TAMBAH STOK LOGIC
    const selectTambah = document.getElementById('tambahId');
    const inputTambahKategori = document.getElementById('tambahKategori');
    const inputTambahSatuan = document.getElementById('tambahSatuan');
    const inputTambahHarga = document.getElementById('tambahHarga');

    selectTambah.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            inputTambahKategori.value = selectedOption.dataset.kategori;
            inputTambahSatuan.value = selectedOption.dataset.satuan;
            inputTambahHarga.value = selectedOption.dataset.harga; // Default to current price
        } else {
            inputTambahKategori.value = '';
            inputTambahSatuan.value = '';
            inputTambahHarga.value = '';
        }
    });


    // Success/Error Alerts
    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
});
</script>
@endsection
