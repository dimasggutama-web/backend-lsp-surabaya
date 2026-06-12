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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan email setelah role. 
            // Kita beri nullable() agar user yang sudah ada sebelumnya tidak error karena emailnya kosong.
            $table->string('email')->unique()->nullable()->after('role');
            
            // Tambahkan foto_profil setelah email.
            $table->string('fotoProfil')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kedua kolom jika migration di-rollback
            $table->dropColumn(['email', 'fotoProfil']);
        });
    }
};