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
        Schema::table('users', function (Blueprint $table) {
            // 1. WAJIB: Hapus dulu foreign key lamanya di sini!
            $table->dropForeign(['instansi_id']);

            // 2. Baru ubah kolomnya jadi NOT NULL
            $table->unsignedBigInteger('instansi_id')->nullable(false)->change();

            // 3. Pasang lagi relasinya pakai 'restrict'
            $table->foreign('instansi_id')
                  ->references('id')
                  ->on('jejaring_lsp_blk_sby')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Bagian down kamu sudah benar urutannya
            $table->dropForeign(['instansi_id']);
            $table->unsignedBigInteger('instansi_id')->nullable()->change();

            // Pasang lagi relasi lama yang pakai 'set null'
            $table->foreign('instansi_id')
                  ->references('id')
                  ->on('jejaring_lsp_blk_sby')
                  ->onDelete('set null');
        });
    }
};