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
                    <input type="password" name="new_password" class="form-control bg-light" required minlength="8" oninvalid="this.setCustomValidity('Password minimal harus 8 karakter')" oninput="this.setCustomValidity('')">
                    <span class="input-group-text bg-light border-start-0"><i class="bi bi-eye-slash text-muted"></i></span>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label small text-muted fw-bold">Konfirmasi Password Baru</label>
                <div class="input-group">
                    <input type="password" name="new_password_confirmation" class="form-control bg-light" required minlength="8" oninvalid="this.setCustomValidity('Password minimal harus 8 karakter')" oninput="this.setCustomValidity('')">
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
    
{{-- DELETE ACCOUNT SECTION --}}
<div class="card border-0 shadow-sm rounded-4 mt-4 border-danger">
    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
        <h5 class="fw-bold text-danger">Hapus Akun</h5>
    </div>
    <div class="card-body p-4">
        <p class="text-muted">Menghapus akun Anda akan menghapus semua data yang terkait dengan akun ini secara permanen. Tindakan ini tidak dapat dibatalkan.</p>
        <div class="text-end">
            <button type="button" class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                <i class="bi bi-trash me-2"></i>Hapus Akun
            </button>
        </div>
    </div>
</div>
