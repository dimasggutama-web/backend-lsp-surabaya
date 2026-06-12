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
            $table->enum('status_pelaksanaan', ['Belum Selesai', 'Selesai'])->default('Belum Selesai')->after('file_kurikulum');
            $table->enum('status_pembayaran', ['Belum Selesai', 'Selesai'])->default('Belum Selesai')->after('status_pelaksanaan');
            $table->enum('status_draft', ['Belum Selesai', 'Selesai'])->default('Belum Selesai')->after('status_pembayaran');
            $table->enum('status_cetak', ['Belum Selesai', 'Selesai'])->default('Belum Selesai')->after('status_draft');
            $table->enum('status_dikirim', ['Belum Selesai', 'Selesai'])->default('Belum Selesai')->after('status_cetak');
            $table->enum('status_diterima', ['Belum Selesai', 'Selesai'])->default('Belum Selesai')->after('status_dikirim');
            $table->enum('status_tt_sertifikat', ['Belum Selesai', 'Selesai'])->default('Belum Selesai')->after('status_diterima');

            $table->string('no_pleno')->nullable()->after('status_tt_sertifikat');
            $table->date('tanggal_pleno')->nullable()->after('no_pleno');
            $table->string('no_resi')->nullable()->after('tanggal_pleno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_ujk_details', function (Blueprint $table) {
            $table->dropColumn(['status_pelaksanaan', 'status_pembayaran', 'status_draft', 'status_cetak', 'status_dikirim', 'status_diterima', 'status_tt_sertifikat', 'no_pleno', 'tanggal_pleno', 'no_resi']);
        });
    }
};
