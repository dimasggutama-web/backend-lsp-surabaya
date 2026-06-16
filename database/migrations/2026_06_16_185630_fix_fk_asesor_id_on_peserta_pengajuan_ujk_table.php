<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peserta_pengajuan_ujk', function (Blueprint $table) {
            // 1. Putus (Drop) relasi lama yang salah arah
            // Laravel otomatis nyari nama index: namaTabel_namaKolom_foreign
            $table->dropForeign(['asesor_id']);

            // 2. Pasang (Add) relasi baru yang bener ke tabel asesor
            $table->foreign('asesor_id')
                  ->references('id')
                  ->on('asesor')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_pengajuan_ujk', function (Blueprint $table) {
            // Kalau di-rollback, balikin lagi ke state awal (walaupun salah)
            $table->dropForeign(['asesor_id']);
            
            $table->foreign('asesor_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }
};