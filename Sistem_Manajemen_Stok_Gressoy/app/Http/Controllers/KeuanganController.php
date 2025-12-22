<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        // Data total pengeluaran
        $totalPengeluaran = 20000000;

        // Data untuk chart pengeluaran pembelian bahan baku (line chart)
        $dataPengeluaran = [
            ['bulan' => 'Jan', 'pembelian' => 35000000, 'pengeluaran' => 30000000],
            ['bulan' => 'Feb', 'pembelian' => 32000000, 'pengeluaran' => 28000000],
            ['bulan' => 'Mar', 'pembelian' => 45000000, 'pengeluaran' => 40000000],
            ['bulan' => 'Apr', 'pembelian' => 38000000, 'pengeluaran' => 35000000],
            ['bulan' => 'Mei', 'pembelian' => 42000000, 'pengeluaran' => 38000000],
            ['bulan' => 'Jun', 'pembelian' => 30000000, 'pengeluaran' => 28000000],
        ];

        // Data untuk chart perbandingan bulanan (bar chart)
        $dataPerbandingan = [
            ['bulan' => 'Jan', 'pembelian' => 40000000, 'pengeluaran' => 48000000],
            ['bulan' => 'Feb', 'pembelian' => 35000000, 'pengeluaran' => 52000000],
            ['bulan' => 'Mar', 'pembelian' => 42000000, 'pengeluaran' => 45000000],
            ['bulan' => 'Apr', 'pembelian' => 38000000, 'pengeluaran' => 49000000],
            ['bulan' => 'Mei', 'pembelian' => 41000000, 'pengeluaran' => 51000000],
            ['bulan' => 'Jun', 'pembelian' => 36000000, 'pengeluaran' => 53000000],
        ];

        return view('keuangan.index', compact('totalPengeluaran', 'dataPengeluaran', 'dataPerbandingan'));
    }

    public function tambahTransaksi(Request $request)
    {
        // Method untuk menambah transaksi baru
        // Implementasi sesuai kebutuhan database Anda
        return redirect()->route('keuangan.index')->with('success', 'Transaksi berhasil ditambahkan');
    }
}