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
            <button class="btn btn-warning text-white rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalKurangStok">
                 <i class="bi bi-dash-lg me-2"></i>Kurang Bahan Baku
            </button>
            <button class="btn btn-success rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg me-2"></i>Tambah Bahan Baku
            </button>
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
                                <button class="btn btn-sm btn-outline-warning me-1 btn-edit"
                                    data-id="{{ $item->id }}"
                                    data-json="{{ json_encode($item) }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>
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

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-3 mt-3">Tambah Bahan Baku</h5>
                <button type="button" class="btn-close me-3 mt-3" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('bahan-baku.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small">Nama Barang</label>
                            <input type="text" name="nama_bahan" class="form-control" placeholder="Contoh: Kacang Kedelai" required>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">ID Barang</label>
                            <input type="text" name="kode_bahan" class="form-control" placeholder="Contoh: BB001" required>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="Bahan Baku">Bahan Baku</option>
                                <option value="Bahan Tambahan">Bahan Tambahan</option>
                                <option value="Kemasan">Kemasan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Jumlah Stok</label>
                            <input type="number" step="0.01" name="stok_tersedia" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Satuan</label>
                            <select name="satuan" class="form-select" required>
                                <option value="Kg">Kg</option>
                                <option value="Liter">Liter</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Pack">Pack</option>
                            </select>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Harga per Unit (Rp)</label>
                            <input type="number" name="harga_satuan" class="form-control" required>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Stok Minimum (Alert)</label>
                            <input type="number" step="0.01" name="stok_minimum" class="form-control" value="10" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small">Supplier</label>
                            <input type="text" name="supplier" class="form-control" placeholder="Nama PT / Suplier">
                        </div>
                         <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small">Terakhir Restok</label>
                            <input type="date" name="terakhir_restok" class="form-control">
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

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-3 mt-3">Edit Bahan Baku</h5>
                <button type="button" class="btn-close me-3 mt-3" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small">Nama Barang</label>
                            <input type="text" name="nama_bahan" id="editNama" class="form-control" required>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">ID Barang</label>
                            <input type="text" name="kode_bahan" id="editKode" class="form-control" required>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Kategori</label>
                            <select name="kategori" id="editKategori" class="form-select" required>
                                <option value="Bahan Baku">Bahan Baku</option>
                                <option value="Bahan Tambahan">Bahan Tambahan</option>
                                <option value="Kemasan">Kemasan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Jumlah Stok</label>
                            <input type="number" step="0.01" name="stok_tersedia" id="editStok" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Satuan</label>
                            <select name="satuan" id="editSatuan" class="form-select" required>
                                <option value="Kg">Kg</option>
                                <option value="Liter">Liter</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Pack">Pack</option>
                            </select>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Harga per Unit (Rp)</label>
                            <input type="number" name="harga_satuan" id="editHarga" class="form-control" required>
                        </div>
                         <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold text-muted small">Stok Minimum</label>
                            <input type="number" step="0.01" name="stok_minimum" id="editMin" class="form-control" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small">Supplier</label>
                            <input type="text" name="supplier" id="editSupplier" class="form-control">
                        </div>
                         <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold text-muted small">Terakhir Restok</label>
                            <input type="date" name="terakhir_restok" id="editRestok" class="form-control">
                        </div>
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
    // EDIT MODAL LOGIC
    const editButtons = document.querySelectorAll('.btn-edit');
    const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
    const formEdit = document.getElementById('formEdit');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const data = JSON.parse(this.dataset.json);

            document.getElementById('editNama').value = data.nama_bahan;
            document.getElementById('editKode').value = data.kode_bahan;
            document.getElementById('editKategori').value = data.kategori;
            document.getElementById('editStok').value = data.stok_tersedia;
            document.getElementById('editSatuan').value = data.satuan;
            document.getElementById('editHarga').value = data.harga_satuan;
            document.getElementById('editMin').value = data.stok_minimum;
            document.getElementById('editSupplier').value = data.supplier;
            document.getElementById('editRestok').value = data.terakhir_restok;

            formEdit.action = `/bahan-baku/${id}`;
            modalEdit.show();
        });
    });

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

    // Success/Error Alerts
    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
});
</script>
@endsection
