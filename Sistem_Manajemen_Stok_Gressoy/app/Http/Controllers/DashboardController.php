<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (request()->wantsJson() || request()->is('api/*')) {
            // Copy logic from BahanBakuController index briefly for summary, or ideally use Service/Model
            // For now, let's just return basic stats to avoid code duplication issues or need for imports
            // But to be useful, let's import the models
            $totalItem = \App\Models\BahanBaku::count();
            $stokMenipis = \App\Models\BahanBaku::whereColumn('stok_tersedia', '<', 'stok_minimum')->count();
            $totalPengeluaran = \App\Models\Keuangan::where('tipe', 'Pengeluaran')->sum('jumlah');

            return response()->json([
                'success' => true,
                'message' => 'Dashboard Data',
                'data' => [
                    'total_item' => $totalItem,
                    'stok_menipis' => $stokMenipis,
                    'total_pengeluaran' => $totalPengeluaran
                ]
            ]);
        }

        return view('dashboard.index');
    }
}
