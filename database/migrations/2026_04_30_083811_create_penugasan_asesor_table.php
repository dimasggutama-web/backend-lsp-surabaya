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
        Schema::create('penugasan_asesor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_asesmen_id')->constrained('jadwal_asesmen')->onDelete('cascade');
            $table->foreignId('asesor_id')->constrained('asesor')->onDelete('cascade');
            $table->enum('status_penugasan', ['menunggu','aktif', 'selesai'])->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasan_asesor');
    }
};
