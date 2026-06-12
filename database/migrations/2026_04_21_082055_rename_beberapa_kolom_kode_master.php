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
        Schema::table('jejaring_lsp_blk_sby', function (Blueprint $table) {
            $table->renameColumn('kodeInstansi', 'kodeInstitusi');
        });
        Schema::table('nama_kementerian', function (Blueprint $table) {
            $table->renameColumn('kode', 'kodeKementerian');
        });
        Schema::table('nama_pekerjaan', function (Blueprint $table) {
            $table->renameColumn('kode', 'kodePekerjaan');
        });
        Schema::table('pendidikan', function (Blueprint $table) {
            $table->renameColumn('kode', 'kodePendidikan');
        });
        Schema::table('sumber_anggaran', function (Blueprint $table) {
            $table->renameColumn('kode', 'kodeAnggaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jejaring_lsp_blk_sby', function (Blueprint $table) {
            $table->renameColumn('kodeInstitusi', 'kodeInstansi');
        });
        Schema::table('nama_kementerian', function (Blueprint $table) {
            $table->renameColumn('kodeKementerian', 'kode');
        });
        Schema::table('nama_pekerjaan', function (Blueprint $table) {
            $table->renameColumn('kodePekerjaan', 'kode');
        });
        Schema::table('pendidikan', function (Blueprint $table) {
            $table->renameColumn('kodePendidikan', 'kode');
        });
        Schema::table('sumber_anggaran', function (Blueprint $table) {
            $table->renameColumn('kodeAnggaran', 'kode');
        });
    }
};
