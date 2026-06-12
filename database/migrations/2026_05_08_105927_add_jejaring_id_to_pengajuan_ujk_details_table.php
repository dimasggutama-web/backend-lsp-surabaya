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
        Schema::table('pengajuan_ujk_details', function (Blueprint $table) {
            $table->foreignId('jejaring_id')
                ->after('skema_id')
                ->default(1)
                ->constrained('jejaring_lsp_blk_sby')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_ujk_details', function (Blueprint $table) {
            $table->dropForeign(['jejaring_id']);
            $table->dropColumn('jejaring_id');
        });
    }
};
