@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/keuangan.css') }}">

<div class="keuangan-container">
    <div class="page-header d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h2 class="fw-bold mb-1">Edit Transaksi</h2>
            <p class="text-muted mb-0">Perbarui data transaksi keuangan</p>
        </div>
        <a href="{{ route('keuangan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="{{ route('keuangan.update', $keuangan->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="tipe" value="{{ $keuangan->tipe }}"> 
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-muted">ID Transaksi</label>
                        <input type="text" name="kode" class="form-control bg-light border-0" value="{{ $keuangan->kode }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-muted">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control bg-light border-0" value="{{ $keuangan->tanggal }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-muted">Tipe</label>
                        <input type="text" class="form-control bg-light border-0" value="{{ $keuangan->tipe }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold small text-muted">Kategori</label>
                        <select name="kategori" class="form-select bg-light border-0" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Bahan Baku" {{ $keuangan->kategori == 'Bahan Baku' ? 'selected' : '' }}>Bahan Baku</option>
                            <option value="Bahan Tambahan" {{ $keuangan->kategori == 'Bahan Tambahan' ? 'selected' : '' }}>Bahan Tambahan</option>
                            <option value="Kemasan" {{ $keuangan->kategori == 'Kemasan' ? 'selected' : '' }}>Kemasan</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold small text-muted">Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control bg-light border-0" value="{{ $keuangan->jumlah }}" required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label fw-bold small text-muted">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control bg-light border-0" rows="3">{{ $keuangan->deskripsi }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-warning text-white rounded-pill px-5">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
