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
        Schema::table('jadwal_asesmen', function (Blueprint $table) {
            $table->dropColumn('status_asesmen');
        });
        Schema::table('penugasan_asesor', function (Blueprint $table) {
            $table->dropColumn('status_penugasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_asesmen', function (Blueprint $table) {
            $table->enum('status_asesmen', ['menunggu', 'berjalan', 'selesai', 'dibatalkan'])->default('menunggu');
        });
        Schema::table('penugasan_asesor', function (Blueprint $table) {
            $table->enum('status_penugasan', ['menunggu', 'aktif', 'selesai'])->default('menunggu');
        });
    }
};
