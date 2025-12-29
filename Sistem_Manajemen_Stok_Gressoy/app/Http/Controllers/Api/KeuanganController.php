<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Keuangan::latest()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'List Data Transaksi Keuangan',
            'data'    => $data
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keuangan = Keuangan::find($id);

        if ($keuangan) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Transaksi Keuangan',
                'data'    => $keuangan
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Transaksi Tidak Ditemukan',
        ], 404);
    }
}
