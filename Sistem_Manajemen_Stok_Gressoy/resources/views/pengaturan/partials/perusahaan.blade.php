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
