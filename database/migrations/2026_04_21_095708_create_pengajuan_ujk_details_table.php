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
        Schema::create('pengajuan_ujk_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_ujk_id')->constrained('pengajuan_ujk')->onDelete('cascade');
            $table->foreignId('skema_id')->constrained('data_skema_sertifikasi_lsp_blk_sby')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('file_nominatif');
            $table->integer('jumlah_peserta');
            $table->string('file_kurikulum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_ujk_details');
    }
};
