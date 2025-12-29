@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-warning mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Bahan Baku</h5>
                    <p class="text-muted small mt-1">Perbarui informasi bahan baku di bawah ini.</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('bahan-baku.update', $bahan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-muted small">Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" name="nama_bahan" class="form-control" value="{{ $bahan->nama_bahan }}" required>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">ID Barang <span class="text-danger">*</span></label>
                                <input type="text" name="kode_bahan" class="form-control" value="{{ $bahan->kode_bahan }}" required>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori" class="form-select" required>
                                    <option value="Bahan Baku" {{ $bahan->kategori == 'Bahan Baku' ? 'selected' : '' }}>Bahan Baku</option>
                                    <option value="Bahan Tambahan" {{ $bahan->kategori == 'Bahan Tambahan' ? 'selected' : '' }}>Bahan Tambahan</option>
                                    <option value="Kemasan" {{ $bahan->kategori == 'Kemasan' ? 'selected' : '' }}>Kemasan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Jumlah Stok <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="stok_tersedia" class="form-control" value="{{ $bahan->stok_tersedia }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Satuan <span class="text-danger">*</span></label>
                                <select name="satuan" class="form-select" required>
                                    <option value="Kg" {{ $bahan->satuan == 'Kg' ? 'selected' : '' }}>Kg</option>
                                    <option value="Liter" {{ $bahan->satuan == 'Liter' ? 'selected' : '' }}>Liter</option>
                                    <option value="Pcs" {{ $bahan->satuan == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="Pack" {{ $bahan->satuan == 'Pack' ? 'selected' : '' }}>Pack</option>
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Harga per Unit (Rp) <span class="text-danger">*</span></label>
                                <input type="number" name="harga_satuan" class="form-control" value="{{ $bahan->harga_satuan }}" required>
                            </div>
                             <div class="col-md-6">
                                <label class="form-label fw-bold text-muted small">Stok Minimum (Alert) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="stok_minimum" class="form-control" value="{{ $bahan->stok_minimum }}" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-muted small">Supplier</label>
                                <input type="text" name="supplier" class="form-control" value="{{ $bahan->supplier }}">
                            </div>
                             <div class="col-md-12">
                                <label class="form-label fw-bold text-muted small">Terakhir Restok</label>
                                <input type="date" name="terakhir_restok" class="form-control" value="{{ $bahan->terakhir_restok }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 gap-2">
                            <a href="{{ route('bahan-baku.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                            <button type="submit" class="btn btn-warning rounded-pill px-4 text-white">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
