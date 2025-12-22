<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('no_transaksi', 50)->unique();
            $table->enum('jenis_transaksi', ['masuk', 'keluar']);
            $table->dateTime('tanggal_transaksi');
            $table->decimal('total_nilai', 15, 2)->default(0);
            $table->enum('status', ['draft', 'completed', 'cancelled'])->default('draft');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('no_transaksi');
            $table->index('tanggal_transaksi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};