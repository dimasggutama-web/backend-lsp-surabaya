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
        Schema::table('pengajuan_ujk_details', function (Blueprint $table) {
            $table->string('status_cetak')->default('Belum Selesai')->after('tanggal_pleno');; 
            $table->string('status_dikirim')->default('Belum Selesai')->after('status_cetak');
            $table->string('no_resi')->nullable()->after('status_dikirim');
            $table->string('status_diterima')->default('Belum Selesai')->after('no_resi');
            $table->string('status_sertifikat_blk')->default('belum dicetak')->after('status_diterima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_ujk_details', function (Blueprint $table) {
            $table->dropColumn(['status_cetak', 'status_dikirim', 'no_resi', 'status_diterima', 'status_sertifikat_blk']);
        });
    }
};
