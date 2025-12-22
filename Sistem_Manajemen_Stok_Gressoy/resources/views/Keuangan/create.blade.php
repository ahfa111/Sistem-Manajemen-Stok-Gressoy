@extends('layouts.app')

@section('content')
<div class="p-8">
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('keuangan.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800 mb-6 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Keuangan
        </a>

        <div class="bg-white rounded-xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Transaksi</h2>
            
            <form id="transactionForm" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe</label>
                    <select name="tipe" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <option value="">Pilih Tipe</option>
                        <option value="Pemasukan">Pemasukan</option>
                        <option value="Pengeluaran">Pengeluaran</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" required min="0" step="0.01" placeholder="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                        <option value="">Pilih Kategori</option>
                        <option value="Pembelian Bahan Baku">Pembelian Bahan Baku</option>
                        <option value="Operasional">Operasional</option>
                        <option value="Gaji Karyawan">Gaji Karyawan</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="tanggal" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">ID</label>
                    <input type="text" name="id_transaksi" placeholder="ID Transaksi (opsional)" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" placeholder="Tambahkan catatan..." class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none"></textarea>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('keuangan.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 rounded-lg font-medium text-center transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-3 rounded-lg font-medium transition-colors">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-sm w-full mx-4 text-center relative animate-fadeIn">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-2xl leading-none transition-colors">×</button>
        
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Berhasil!</h3>
        <p class="text-gray-600 mb-6">Transaksi berhasil disimpan</p>
        
        <button onclick="redirectToIndex()" class="w-full bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg font-medium transition-colors">OK</button>
    </div>
</div>

@push('styles')
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-fadeIn { animation: fadeIn 0.3s ease-out; }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('transactionForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitButton = this.querySelector('button[type="submit"]');
        
        submitButton.disabled = true;
        submitButton.textContent = 'Menyimpan...';
        
        try {
            const response = await fetch('{{ route("keuangan.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (response.ok && data.success) {
                document.getElementById('successModal').classList.remove('hidden');
            } else {
                alert('