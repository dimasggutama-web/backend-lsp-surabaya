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
        Schema::table('jejaring_lsp_blk_sby', function (Blueprint $table) {
            $table->dropUnique('jejaring_lsp_blk_sby_alamat_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jejaring_lsp_blk_sby', function (Blueprint $table) {
            $table->string('alamat')->unique()->change();
        });
    }
};
