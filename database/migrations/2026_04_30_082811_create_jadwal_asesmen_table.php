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
        Schema::create('jadwal_asesmen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_ujk_detail_id')->constrained('pengajuan_ujk_details')->onDelete('cascade');
            $table->foreignId('penyilia_id')->constrained('penyilia_lsp')->onDelete('cascade');
            $table->date('tanggal_mulai_asesmen');
            $table->date('tanggal_selesai_asesmen');
            $table->enum('status_asesmen', ['menunggu','berjalan', 'selesai, dibatalkan'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_asesmen');
    }
};
