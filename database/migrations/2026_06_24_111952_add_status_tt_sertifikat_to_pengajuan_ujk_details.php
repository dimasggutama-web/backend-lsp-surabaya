<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan_ujk_details', function (Blueprint $table) {
            $table->string('status_tt_sertifikat')->default('Belum Selesai')->after('status_sertifikat_blk');
        });
    }

    public function down(): void
    {
        Schema::table('pengajuan_ujk_details', function (Blueprint $table) {
            $table->dropColumn('status_tt_sertifikat');
        });
    }
};
