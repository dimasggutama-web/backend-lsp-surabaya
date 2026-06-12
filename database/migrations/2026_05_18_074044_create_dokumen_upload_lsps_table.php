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
        Schema::create('dokumen_upload_lsp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_ujk_id')->nullable()->constrained('pengajuan_ujk')->cascadeOnDelete();
            $table->foreignId('pengajuan_ujk_detail_id')->nullable()->constrained('pengajuan_ujk_details')->cascadeOnDelete();
            $table->enum('jenis_dokumen', ['surat_balasan', 'berita_acara', 'spt_asesor']);
            $table->string('nama_file'); 
            $table->string('path_file'); 
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_upload_lsps');
    }
};
