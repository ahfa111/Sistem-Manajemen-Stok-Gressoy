<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function index()
    {
        $data = Keuangan::latest()->get();
        
        // SUMMARY
        $totalPengeluaran = Keuangan::where('tipe', 'Pengeluaran')->sum('jumlah');

        // CHART: Pengeluaran Per Bulan
        $chartData = Keuangan::select(
                DB::raw('MONTH(tanggal) as month'),
                DB::raw('SUM(jumlah) as pengeluaran')
            )
            ->where('tipe', 'Pengeluaran')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
            
        $months = [];
        $pengeluaranPerBulan = [];

        // Initialize array for all months if needed, but for now just from DB
        foreach($chartData as $item) {
            $months[] = Carbon::create()->month($item->month)->format('F');
            $pengeluaranPerBulan[] = $item->pengeluaran;
        }

        return view('keuangan.index', compact(
            'data', 
            'totalPengeluaran',
            'months',
            'pengeluaranPerBulan'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required',
            'tanggal' => 'required|date',
            'kode' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|numeric',
            'deskripsi' => 'nullable'
        ]);

        Keuangan::create($request->all());

        return back()->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        Keuangan::findOrFail($id)->update($request->all());
        return back()->with('success', 'Transaksi berhasil diupdate');
    }

    public function destroy($id)
    {
        Keuangan::findOrFail($id)->delete();
        return back()->with('success', 'Transaksi berhasil dihapus');
    }
}