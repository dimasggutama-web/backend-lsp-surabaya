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
            $table->dropforeign(['jenisSkema_id']);
            $table->dropColumn('jenisSkema_id');
            $table->enum('jenisSkema', ['OKUPASI', 'KLASTER'])->after('bidang_id')->nullable();
        });
        Schema::dropIfExists('jenisSkema_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
