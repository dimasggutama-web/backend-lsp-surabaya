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
        Schema::create('absensi_peserta_ujk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_asesmen_id')->constrained('jadwal_asesmen')->cascadeOnDelete();
            $table->foreignId('peserta_id')->constrained('peserta_pengajuan_ujk')->cascadeOnDelete();
            $table->enum('jenis_absen', ['Pra_Asesmen', 'Hari_1', 'Hari_2']);
            $table->dateTime('waktu_hadir')->nullable();
            $table->enum('status_hadir', ['Hadir', 'Izin', 'Sakit', 'Alpa'])->default('Alpa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_peserta_ujk');
    }
};
