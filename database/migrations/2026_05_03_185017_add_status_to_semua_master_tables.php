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
        $tabelMaster = [
            'bidang', 
            'data_skema_sertifikasi_lsp_blk_sby', 
            'jejaring_lsp_blk_sby', 
            'nama_kementerian', 
            'nama_pekerjaan', 
            'pendidikan', 
            'sumber_anggaran'
        ];

        foreach ($tabelMaster as $namaTabel) {
            Schema::table($namaTabel, function (Blueprint $table){
                $table->enum('status', ['Aktif', 'Non-aktif'])->default('Aktif');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tabelMaster = [
            'bidang', 'data_skema_sertifikasi', 'jejaring_lsp_blk', 
            'nama_kementerian', 'pekerjaan', 'pendidikan', 
            'sumber_anggaran', 'penyilia'
        ];

        foreach ($tabelMaster as $namaTabel) {
            Schema::table($namaTabel, function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
