<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BahanBaku;
use App\Models\Supplier;
use Carbon\Carbon;

class BahanBakuController extends Controller
{
    public function index()
    {
        $data = BahanBaku::latest()->get();
        
        // Stats
        $totalItem = BahanBaku::count();
        $stokNormal = BahanBaku::whereColumn('stok_tersedia', '>=', 'stok_minimum')->count();
        $stokMenipis = BahanBaku::whereColumn('stok_tersedia', '<', 'stok_minimum')->count();

        // Suppliers Data for the Tab
        $suppliers = Supplier::latest()->get();

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'List Data Bahan Baku',
                'data' => [
                    'bahan_baku' => $data,
                    'stats' => [
                        'total_item' => $totalItem,
                        'stok_normal' => $stokNormal,
                        'stok_menipis' => $stokMenipis
                    ],
                    'suppliers' => $suppliers
                ]
            ]);
        }

        return view('bahan-baku.index', compact('data', 'totalItem', 'stokNormal', 'stokMenipis', 'suppliers'));
    }

    public function create()
    {
        return view('bahan-baku.create');
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

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Bahan baku berhasil ditambahkan',
                'data' => $bahan
            ], 201);
        }

        return redirect()->route('bahan-baku.index')->with('success', 'Bahan baku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        return view('bahan-baku.edit', compact('bahan'));
    }

    public function update(Request $request, $id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $bahan->update($request->all());
        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Data bahan baku berhasil diupdate',
                'data' => $bahan
            ]);
        }

        return redirect()->route('bahan-baku.index')->with('success', 'Data bahan baku berhasil diupdate');
    }

    public function destroy($id)
    {
        $bahan = BahanBaku::findOrFail($id);
        $bahan->delete();

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Bahan baku berhasil dihapus'
            ]);
        }

        return back()->with('success', 'Bahan baku berhasil dihapus');
    }

    public function tambahStok(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bahan_baku,id',
            'jumlah' => 'required|numeric|min:0.01',
            'harga_baru' => 'required|numeric|min:0',
        ]);

        $bahan = BahanBaku::findOrFail($request->id);
        
        // Calculate Weighted Average Price
        // Current Value
        $oldStock = $bahan->stok_tersedia;
        $oldPrice = $bahan->harga_satuan;
        $oldTotalValue = $oldStock * $oldPrice;

        // New Value
        $newStock = $request->jumlah;
        $newPrice = $request->harga_baru;
        $newTotalValue = $newStock * $newPrice;

        // Final Calculation
        $totalStock = $oldStock + $newStock;
        
        // Prevent division by zero if total stock is somehow 0 (unlikely here but safe)
        if ($totalStock > 0) {
            $averagePrice = ($oldTotalValue + $newTotalValue) / $totalStock;
        } else {
            $averagePrice = $newPrice;
        }

        // Update Data
        $bahan->stok_tersedia = $totalStock;
        $bahan->harga_satuan = $averagePrice;
        $bahan->terakhir_restok = now();
        $bahan->save();

        return redirect()->route('bahan-baku.index')->with('success', 'Stok berhasil ditambahkan. Harga rata-rata diperbarui.');
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
