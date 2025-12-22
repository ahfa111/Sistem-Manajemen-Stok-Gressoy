<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Laporan;
use App\Models\Keuangan; // Assuming we use Keuangan for stats

class LaporanController extends Controller
{
     public function index()
    {
        // History of saved reports
        $laporans = Laporan::latest()->get();

        // Stats integrated with Laporan data (Sum of all saved reports for now, or could be filtered by period)
        $totalPembelian = Laporan::sum('total_pembelian');
        $totalBarangKeluar = Laporan::sum('total_barang_keluar');

        return view('laporan.index', compact('laporans', 'totalPembelian', 'totalBarangKeluar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'periode' => 'required',
            'total_pembelian' => 'required|numeric',
            'total_barang_keluar' => 'required|numeric',
            'catatan' => 'nullable'
        ]);

        Laporan::create($request->all());

        return back()->with('success', 'Laporan berhasil disimpan dan diarsipkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'periode' => 'required',
            'total_pembelian' => 'required|numeric',
            'total_barang_keluar' => 'required|numeric',
            'catatan' => 'nullable'
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->update($request->all());

        return back()->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Laporan::findOrFail($id)->delete();
        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}
