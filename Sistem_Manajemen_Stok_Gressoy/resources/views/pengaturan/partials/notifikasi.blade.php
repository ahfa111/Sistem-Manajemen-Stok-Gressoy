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
