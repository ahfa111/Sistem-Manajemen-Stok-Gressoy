<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bahan_baku', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bahan', 100);
            $table->string('kode_bahan', 50)->unique();
            $table->string('kategori', 50)->nullable();
            $table->string('satuan', 20);
            $table->decimal('stok_minimum', 10, 2)->default(0);
            $table->decimal('stok_tersedia', 10, 2)->default(0);
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->string('supplier', 100)->nullable();
            $table->date('terakhir_restok')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index('kode_bahan');
            $table->index('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bahan_baku');
    }
};