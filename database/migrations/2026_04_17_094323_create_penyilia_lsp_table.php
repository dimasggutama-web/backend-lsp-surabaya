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
        Schema::create('penyilia_lsp', function (Blueprint $table) {
            $table->id();
            $table->string('namaPenyilia')->unique();
            $table->string('jabatan');
            $table->string('noRegistrasi')->unique();
            $table->string('institusi');
            $table->string('alamat');
            $table->string('kota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengurus_lsp');
    }
};
