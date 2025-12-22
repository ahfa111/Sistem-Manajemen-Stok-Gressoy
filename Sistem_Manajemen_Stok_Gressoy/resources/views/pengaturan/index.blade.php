@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold">Pengaturan</h2>
            <p class="text-muted">Kelola pengaturan sistem Gressoy</p>
        </div>
    </div>

    <div class="row">
        {{-- SIDEBAR MENU --}}
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-4 overflow-hidden">
                        <a href="#profil" class="list-group-item list-group-item-action p-3 d-flex align-items-center active" data-bs-toggle="list">
                            <i class="bi bi-person me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">Profil Perusahaan</div>
                                <small class="text-muted text-white-50">Kelola info akun</small>
                            </div>
                        </a>
                        <a href="#perusahaan" class="list-group-item list-group-item-action p-3 d-flex align-items-center" data-bs-toggle="list">
                            <i class="bi bi-building me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">Info Perusahaan</div>
                                <small class="text-muted">Detail identitas bisnis</small>
                            </div>
                        </a>
                        <a href="#notifikasi" class="list-group-item list-group-item-action p-3 d-flex align-items-center" data-bs-toggle="list">
                            <i class="bi bi-bell me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">Notifikasi</div>
                                <small class="text-muted">Preferensi peringatan</small>
                            </div>
                        </a>
                        <a href="#keamanan" class="list-group-item list-group-item-action p-3 d-flex align-items-center" data-bs-toggle="list">
                            <i class="bi bi-shield-lock me-3 fs-5"></i>
                            <div>
                                <div class="fw-bold">Keamanan</div>
                                <small class="text-muted">Ubah password</small>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTENT FORMS --}}
        <div class="col-md-9">
            <div class="tab-content">
                
                {{-- PROFIL --}}
                <div class="tab-pane fade show active" id="profil">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h5 class="fw-bold text-success">Informasi Profil</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('pengaturan.updateProfile') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-bold">Nama Lengkap</label>
                                        <input type="text" name="full_name" class="form-control bg-light" value="{{ old('full_name', $user->full_name) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-bold">Email</label>
                                        <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly disabled>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-bold">Nomor Telepon</label>
                                        <input type="text" name="phone_number" class="form-control bg-light" value="{{ old('phone_number', $user->phone_number) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-bold">Jabatan</label>
                                        <input type="text" name="job_title" class="form-control bg-light" value="{{ old('job_title', $user->job_title) }}">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success rounded-pill px-4">
                                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- PERUSAHAAN --}}
                <div class="tab-pane fade" id="perusahaan">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h5 class="fw-bold text-success">Informasi Perusahaan</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('pengaturan.updateCompany') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-bold">Nama Lengkap Perusahaan</label>
                                        <input type="text" name="company_name" class="form-control bg-light" value="{{ old('company_name', $user->company_name) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-bold">Bidang Usaha</label>
                                        <input type="text" name="business_type" class="form-control bg-light" value="{{ old('business_type', $user->business_type) }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold">Alamat</label>
                                    <textarea name="company_address" class="form-control bg-light" rows="3">{{ old('company_address', $user->company_address) }}</textarea>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-bold">Telepon Kantor</label>
                                        <input type="text" name="company_phone" class="form-control bg-light" value="{{ old('company_phone', $user->company_phone) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted fw-bold">Email Perusahaan</label>
                                        <input type="email" name="company_email" class="form-control bg-light" value="{{ old('company_email', $user->company_email) }}">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success rounded-pill px-4">
                                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- NOTIFIKASI --}}
                <div class="tab-pane fade" id="notifikasi">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h5 class="fw-bold text-success">Pengaturan Notifikasi</h5>
                            <p class="text-muted small">Kelola bagaimana Anda menerima pemberitahuan</p>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('pengaturan.updateNotifications') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 form-check form-switch p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                    <label class="form-check-label ms-2" for="notify_low_stock">
                                        <strong>Notifikasi Stok Menipis</strong><br>
                                        <span class="text-muted small">Dapatkan notifikasi saat stok bahan baku atau produk menipis</span>
                                    </label>
                                    <input class="form-check-input fs-4" type="checkbox" id="notify_low_stock" name="notify_low_stock" {{ $user->notify_low_stock ? 'checked' : '' }}>
                                </div>
                                <div class="mb-3 form-check form-switch p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                    <label class="form-check-label ms-2" for="notify_stock_in">
                                        <strong>Notifikasi Input Stok Berhasil</strong><br>
                                        <span class="text-muted small">Dapatkan konfirmasi saat stok bahan baku berhasil diperbarui</span>
                                    </label>
                                    <input class="form-check-input fs-4" type="checkbox" id="notify_stock_in" name="notify_stock_in" {{ $user->notify_stock_in ? 'checked' : '' }}>
                                </div>
                                <div class="mb-3 form-check form-switch p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                    <label class="form-check-label ms-2" for="notify_transaction">
                                        <strong>Notifikasi Transaksi</strong><br>
                                        <span class="text-muted small">Dapatkan notifikasi untuk setiap transaksi keuangan</span>
                                    </label>
                                    <input class="form-check-input fs-4" type="checkbox" id="notify_transaction" name="notify_transaction" {{ $user->notify_transaction ? 'checked' : '' }}>
                                </div>
                                <div class="mb-3 form-check form-switch p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                    <label class="form-check-label ms-2" for="notify_expiry">
                                        <strong>Notifikasi Produk Kedaluwarsa</strong><br>
                                        <span class="text-muted small">Notifikasi peringatan untuk produk yang mendekati tanggal kedaluwarsa</span>
                                    </label>
                                    <input class="form-check-input fs-4" type="checkbox" id="notify_expiry" name="notify_expiry" {{ $user->notify_expiry ? 'checked' : '' }}>
                                </div>
                                <div class="mb-3 form-check form-switch p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                    <label class="form-check-label ms-2" for="notify_daily_report">
                                        <strong>Laporan Harian</strong><br>
                                        <span class="text-muted small">Terima ringkasan laporan bisnis setiap hari</span>
                                    </label>
                                    <input class="form-check-input fs-4" type="checkbox" id="notify_daily_report" name="notify_daily_report" {{ $user->notify_daily_report ? 'checked' : '' }}>
                                </div>
                                
                                <div class="text-end mt-4">
                                    <button type="submit" class="btn btn-success rounded-pill px-4">
                                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- KEAMANAN --}}
                <div class="tab-pane fade" id="keamanan">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                            <h5 class="fw-bold text-success">Keamanan Akun</h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('pengaturan.updatePassword') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold">Password Lama</label>
                                    <div class="input-group">
                                        <input type="password" name="current_password" class="form-control bg-light" required>
                                        <span class="input-group-text bg-light border-start-0"><i class="bi bi-eye-slash text-muted"></i></span>
                                    </div>
                                    @error('current_password')
                                        <span class="text-danger small">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label small text-muted fw-bold">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="new_password" class="form-control bg-light" required>
                                        <span class="input-group-text bg-light border-start-0"><i class="bi bi-eye-slash text-muted"></i></span>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label small text-muted fw-bold">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" name="new_password_confirmation" class="form-control bg-light" required>
                                        <span class="input-group-text bg-light border-start-0"><i class="bi bi-eye-slash text-muted"></i></span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success rounded-pill px-4">
                                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Active State for Sidebar */
    .list-group-item.active {
        background-color: #fff !important;
        border-left: 4px solid #28a745 !important;
        color: #28a745 !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .list-group-item.active .text-muted {
        color: #28a745 !important;
        opacity: 0.7;
    }
    .list-group-item {
        border: none;
        margin-bottom: 5px;
        border-radius: 8px !important;
        transition: all 0.2s;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .text-success { color: #2ecc71 !important; }
    .btn-success { background-color: #2ecc71; border-color: #2ecc71; }
    .btn-success:hover { background-color: #27ae60; border-color: #27ae60; }
</style>
@endsection
