<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dokumen_upload_lsp', function (Blueprint $table) {
            DB::statement("ALTER TABLE dokumen_upload_lsp MODIFY COLUMN jenis_dokumen ENUM('surat_balasan', 'berita_acara_1', 'berita_acara_2', 'spt_asesor_1', 'spt_asesor_2') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokumen_upload_lsp', function (Blueprint $table) {
            DB::statement("ALTER TABLE dokumen_upload_lsp MODIFY COLUMN jenis_dokumen ENUM('surat_balasan', 'berita_acara', 'spt_asesor') NOT NULL");
        });
    }
};
