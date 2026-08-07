<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom 'kabupaten' setelah kolom 'kecamatan'
     * pada tabel peserta_pengajuan_ujk sesuai tambahan kolom di template Excel nominatif.
     */
    public function up(): void
    {
        Schema::table('peserta_pengajuan_ujk', function (Blueprint $table) {
            $table->string('kabupaten', 100)->nullable()->after('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peserta_pengajuan_ujk', function (Blueprint $table) {
            $table->dropColumn('kabupaten');
        });
    }
};
