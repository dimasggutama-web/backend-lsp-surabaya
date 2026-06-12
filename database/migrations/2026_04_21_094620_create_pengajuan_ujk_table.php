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
        Schema::create('pengajuan_ujk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_blk_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('jejaring_id')->constrained('jejaring_lsp_blk_sby')->onDelete('cascade');
            $table->string('nomor_surat_pengajuan')->unique();
            $table->foreignId('sumber_anggaran_id')->constrained('sumber_anggaran')->onDelete('cascade');
            $table->string('file_surat_pengajuan');
            $table->enum('status', ['Draft', 'Menunggu', 'Disetujui', 'Ditolak', 'Selesai'])->default('Draft');
            $table->text('catatan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_ujks');
    }
};
