<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe',
        'jumlah',
        'kategori',
        'tanggal',
        'id_transaksi',
        'deskripsi'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public function getFormattedJumlahAttribute()
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }
}