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

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Laporan',
                'data' => [
                    'laporan' => $laporans,
                    'stats' => [
                        'total_pembelian' => $totalPembelian,
                        'total_barang_keluar' => $totalBarangKeluar
                    ]
                ]
            ]);
        }

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

        $laporan = Laporan::create($request->all());

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil disimpan',
                'data' => $laporan
            ], 201);
        }

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

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil diperbarui',
                'data' => $laporan
            ]);
        }

        return back()->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Laporan::findOrFail($id)->delete();

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dihapus'
            ]);
        }

        return back()->with('success', 'Laporan berhasil dihapus.');
    }
}
