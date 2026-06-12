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
        Schema::create('data_skema_sertifikasi_lsp_blk_sby', function (Blueprint $table) {
            $table->id();
            $table->string('namaSkema')->unique();
            $table->string('kodeSkema')->unique();
            $table->string('profesi');
            $table->string('bidang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_skema_sertifikasi_lsp_blk_sby');
    }
};
