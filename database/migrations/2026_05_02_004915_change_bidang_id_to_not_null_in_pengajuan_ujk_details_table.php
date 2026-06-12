<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('pengajuan_ujk_details')->whereNull('bidang_id')->update(['bidang_id' => 1]);
        
        Schema::table('pengajuan_ujk_details', function (Blueprint $table) {
            $table->unsignedBigInteger('bidang_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_ujk_details', function (Blueprint $table) {
            $table->unsignedBigInteger('bidang_id')->nullable()->change();
        });
    }
};
