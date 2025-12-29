<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BahanBaku;

class BahanBakuController extends Controller
{
    /**
     * Get all bahan baku
     */
    public function index()
    {
        $bahanBaku = BahanBaku::latest()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'List Data Bahan Baku',
            'data'    => $bahanBaku
        ], 200);
    }

    /**
     * Get specific bahan baku by ID
     */
    public function show($id)
    {
        $bahanBaku = BahanBaku::find($id);

        if ($bahanBaku) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Bahan Baku',
                'data'    => $bahanBaku
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Bahan Baku Tidak Ditemukan',
        ], 404);
    }
}
