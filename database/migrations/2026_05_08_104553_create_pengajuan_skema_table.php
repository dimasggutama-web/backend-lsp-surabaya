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
        Schema::create('pengajuan_skema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuan_id')->constrained('pengajuan_ujk')->onDelete('cascade');
            $table->foreignId('skema_id')->constrained('data_skema_sertifikasi_lsp_blk_sby')->onDelete('cascade');
            $table->foreignId('jejaring_id')->constrained('jejaring_lsp_blk_sby')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_skema');
    }
};
