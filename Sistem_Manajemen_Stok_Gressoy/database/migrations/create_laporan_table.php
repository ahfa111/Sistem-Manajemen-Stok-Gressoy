<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('jenis_laporan', 50);
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->string('file_path', 255)->nullable();
            $table->enum('status', ['generated', 'archived'])->default('generated');
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('jenis_laporan');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};