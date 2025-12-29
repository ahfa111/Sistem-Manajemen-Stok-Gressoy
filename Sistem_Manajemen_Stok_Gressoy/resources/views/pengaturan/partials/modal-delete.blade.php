{{-- DELETE ACCOUNT MODAL --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-danger">Hapus Akun?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted mb-4">Apakah Anda yakin ingin menghapus akun ini? Masukkan password Anda untuk mengonfirmasi tindakan ini.</p>
                <form action="{{ route('pengaturan.deleteAccount') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control bg-light" required placeholder="Masukkan password Anda">
                            <span class="input-group-text bg-light border-start-0"><i class="bi bi-eye-slash text-muted"></i></span>
                        </div>
                        @if($errors->has('password'))
                            <span class="text-danger small mt-1 d-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4">Hapus Permanen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
