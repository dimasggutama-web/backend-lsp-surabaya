<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('data_skema_sertifikasi_lsp_blk_sby', function (Blueprint $table) {
            $table->unsignedBigInteger('bidang_id')->nullable()->after('profesi');
        });
        $skemaList = DB::table('data_skema_sertifikasi_lsp_blk_sby')->get();

        foreach ($skemaList as $skema) {
            if (empty($skema->bidang)) {
                $bidangMaster = DB::table('bidang')->where('namaBidang', $skema->bidang)->first();
                if ($bidangMaster) {
                    DB::table('data_skema_sertifikasi_lsp_blk_sby')
                        ->where('id', $skema->id)
                        ->update(['bidang_id' => $bidangMaster->id]);
                }
            }
        }
        schema::table('data_skema_sertifikasi_lsp_blk_sby', function (Blueprint $table) {
            $table->foreign('bidang_id')->references('id')->on('bidang')->onDelete('cascade');
            $table->dropColumn('bidang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_skema_sertifikasi_lsp_blk_sby', function (Blueprint $table) {
            $table->dropForeign(['bidang_id']);
            $table->dropColumn('bidang_id');
            $table->string('bidang')->nullable;
        });
    }
};
