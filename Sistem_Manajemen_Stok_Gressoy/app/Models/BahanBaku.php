<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_baku';

    protected $fillable = [
        'nama_bahan',
        'kode_bahan',
        'kategori',
        'satuan',
        'stok_minimum',
        'stok_tersedia',
        'harga_satuan',
        'supplier',
        'terakhir_restok',
        'keterangan'
    ];
}
