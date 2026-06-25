<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sertifikat_asesi', function (Blueprint $table) {
            // 1. Lepas gembok Foreign Key dulu
            $table->dropForeign(['peserta_pengajuan_ujk_id']);

            // 2. Ubah kolom ID Peserta jadi nullable (boleh kosong untuk data lama)
            $table->unsignedBigInteger('peserta_pengajuan_ujk_id')->nullable()->change();

            // 3. Pasang lagi gembok Foreign Key-nya
            $table->foreign('peserta_pengajuan_ujk_id')
                  ->references('id')->on('peserta_pengajuan_ujk')
                  ->cascadeOnDelete();

            // 4. Tambahin kolom khusus untuk nampung data manual dari Excel
            $table->string('nama_peserta_lama')->nullable()->after('peserta_pengajuan_ujk_id');
            $table->string('skema_sertifikasi_lama')->nullable()->after('nama_peserta_lama');
        });
    }

    public function down(): void
    {
        Schema::table('sertifikat_asesi', function (Blueprint $table) {
            // Balikin lagi jadi NOT NULL kalau misal di-rollback
            $table->dropForeign(['peserta_pengajuan_ujk_id']);
            $table->unsignedBigInteger('peserta_pengajuan_ujk_id')->nullable(false)->change();
            $table->foreign('peserta_pengajuan_ujk_id')
                  ->references('id')->on('peserta_pengajuan_ujk')
                  ->cascadeOnDelete();

            // Hapus kolom-kolom data lama
            $table->dropColumn([
                'nama_peserta_lama', 
                'skema_sertifikasi_lama'
            ]);
        });
    }
};