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
        Schema::table('pengajuan_ujk', function (Blueprint $table) {
            $table->dropForeign(['jejaring_id']); 
            // Baru hapus kolomnya
            $table->dropColumn('jejaring_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_ujk', function (Blueprint $table) {
            $table->foreignId('jejaring_id')->nullable()->constrained('jejaring_lsp_blk_sby');
        });
    }
};
