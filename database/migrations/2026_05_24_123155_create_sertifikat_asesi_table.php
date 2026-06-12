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
        Schema::create('sertifikat_asesi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_pengajuan_ujk_id');
            $table->foreign('peserta_pengajuan_ujk_id')->references('id')->on('peserta_pengajuan_ujk')->cascadeOnDelete();
            $table->string('no_sertifikat')->unique();
            $table->date('tanggal_penerbitan');
            $table->date('masa_berlaku');
            $table->enum('status', ['Aktif', 'Tidak-Aktif','Kadaluwarsa'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat_asesi');
    }
};
