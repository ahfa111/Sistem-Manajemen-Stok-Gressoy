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
