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
        Schema::create('dokumen_administrasi_ujk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_asesmen_id')->constrained('jadwal_asesmen')->onDelete('cascade');
            $table->enum('jenis_dokumen', [
                'Surat_Balasan', 
                'Surat_SPT', 
                'Laporan_Penyilia', 
                'BA_Baru', 
                'Penerapan_TUK', 
                'SK_Penyelenggara',
                'Lampiran_SK',
                'DH_Pra',
                'DH_1',
                'DH_2',
                'Tanda_Terima_Dokumen',
                'Pernyataaan_Asesor_1',
                'Pernyataaan_Asesor_2',
                'Pengembalian_Dokumen_Asesmen',
            ]);
            $table->string('nomor_surat')->nullable();
            $table->string('file_path');
            $table->foreignId('uploaded_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_administrasi_ujk');
    }
};
