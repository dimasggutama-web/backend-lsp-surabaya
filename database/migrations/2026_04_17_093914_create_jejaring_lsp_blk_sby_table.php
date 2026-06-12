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
        Schema::create('jejaring_lsp_blk_sby', function (Blueprint $table) {
            $table->id();
            $table->string('namaInstitusi')->unique();
            $table->string('alamat')->unique();
            $table->string('kota');
            $table->string('kodeInstansi')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jejaring_lsp_blk_sby');
    }
};
