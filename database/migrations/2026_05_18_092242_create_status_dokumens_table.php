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
        Schema::create('status_dokumen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_ujk_detail_id')->constrained('pengajuan_ujk_details')->cascadeOnDelete();
            $table->string('kategori');
            $table->string('nama_surat');
            $table->enum('status', ['Sudah Dicetak'])->default('Sudah Dicetak');
            $table->timestamp('waktu_cetak');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_dokumen');
    }
};
