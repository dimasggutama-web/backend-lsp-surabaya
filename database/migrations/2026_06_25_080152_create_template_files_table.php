<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_files', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique()->comment('Identifier unik template, contoh: template_sertifikat');
            $table->string('nama_file')->comment('Nama file asli saat diupload');
            $table->string('mime_type')->default('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            $table->longText('data')->comment('Isi file dalam format base64');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_files');
    }
};
