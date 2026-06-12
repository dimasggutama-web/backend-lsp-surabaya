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
        Schema::table('data_skema_sertifikasi_lsp_blk_sby', function (Blueprint $table) {
            $table->unsignedBigInteger('jenisSkema_id')->nullable()->after('bidang_id');
            $table->foreign('jenisSkema_id')->references('id')->on('jenis_skema')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_skema_sertifikasi_lsp_blk_sby', function (Blueprint $table) {
            $table->dropForeign(['jenisSkema_id']);
            $table->dropColumn('jenisSkema_id');
        });
    }
};
