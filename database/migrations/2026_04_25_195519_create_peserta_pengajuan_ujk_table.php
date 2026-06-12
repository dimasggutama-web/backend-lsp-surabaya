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
        Schema::create('peserta_pengajuan_ujk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_ujk_detail_id')->constrained('pengajuan_ujk_details')->onDelete('cascade');
            $table->string('namaPeserta', 200);
            $table->string('nik', 100);
            $table->enum('jenisKelamin', ['L', 'P']);
            $table->string('tempatLahir', 100);
            $table->date('tanggalLahir');
            $table->string('alamat', 255);
            $table->string('rt', 20);
            $table->string('rw', 20);
            $table->string('kelurahan', 100);
            $table->string('kecamatan', 100);
            $table->string('nomorTelepon', 100);
            $table->string('email', 100);
            $table->string('pendidikanTerakhir', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_pengajuan_ujk');
    }
};
