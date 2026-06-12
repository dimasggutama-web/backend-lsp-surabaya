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
        Schema::table('penyilia_lsp', function (Blueprint $table) {
            $table->enum('status', ['Aktif', 'Non-aktif'])->default('Aktif')->after('namaPenyilia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penyilia_lsp', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
