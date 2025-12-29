<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Daftar Supplier</h5>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary rounded-pill px-4 btn-sm">
            <i class="bi bi-person-plus me-2"></i>Tambah Supplier
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Nama Supplier</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $s)
                    <tr>
                        <td class="ps-4 fw-bold">{{ $s->nama_supplier }}</td>
                        <td>{{ $s->telepon ?? '-' }}</td>
                        <td>{{ $s->email ?? '-' }}</td>
                        <td class="small text-muted">{{ Str::limit($s->alamat, 30) }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('suppliers.edit', $s->id) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <form action="{{ route('suppliers.destroy', $s->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus supplier ini?')">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada data supplier.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
