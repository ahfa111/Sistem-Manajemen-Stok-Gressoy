<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\BahanBaku;

class BahanBakuController extends Controller
{
     public function index()
    {
        $data = BahanBaku::latest()->get();
        
        // Stats
        $totalItem = BahanBaku::count();
        $stokNormal = BahanBaku::whereColumn('stok_tersedia', '>=', 'stok_minimum')->count();
        $stokMenipis = BahanBaku::whereColumn('stok_tersedia', '<', 'stok_minimum')->count();

        return view('bahan-baku.index', compact('data', 'totalItem', 'stokNormal', 'stokMenipis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'kode_bahan' => 'required|unique:bahan_baku',
            'kategori' => 'required',
            'stok_tersedia' => 'required|numeric',
            'satuan' => 'required',
            'stok_minimum' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'supplier' => 'nullable',
            'terakhir_restok' => 'nullable|date',
            'keterangan' => 'nullable'
        ]);

        BahanBaku::create($request->all());

        return back()->with('success', 'Bahan baku berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $bahan->update($request->all());
        return back()->with('success', 'Data bahan baku berhasil diupdate');
    }

    public function destroy($id)
    {
        BahanBaku::findOrFail($id)->delete();
        return back()->with('success', 'Bahan baku berhasil dihapus');
    }

    public function tambahStok(Request $request)
    {
        // Not used directly in this design iteration but kept for route compatibility
        return back();
    }

    public function kurangStok(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bahan_baku,id',
            'jumlah' => 'required|numeric|min:0.01',
        ]);

        $bahan = BahanBaku::findOrFail($request->id);

        if ($bahan->stok_tersedia < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi untuk pengurangan ini.');
        }

        $bahan->stok_tersedia -= $request->jumlah;
        $bahan->save();

        return back()->with('success', 'Stok bahan baku berhasil dikurangi.');
    }
}
