<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateFile;

class TemplateSertifikatSeeder extends Seeder
{
    public function run(): void
    {
        // Coba baca dari storage/app/templates/ (hasil copy manual sebelumnya)
        $storagePath = storage_path('app/templates/template_import_sertifikat.xlsx');

        if (!file_exists($storagePath)) {
            $this->command->warn('File template tidak ditemukan di storage. Seeder dilewati.');
            return;
        }

        $fileContent = file_get_contents($storagePath);
        $base64      = base64_encode($fileContent);

        TemplateFile::updateOrCreate(
            ['nama' => 'template_sertifikat'],
            [
                'nama_file' => 'template_import_sertifikat.xlsx',
                'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'data'      => $base64,
            ]
        );

        $this->command->info('✅ Template sertifikat berhasil disimpan ke database.');
    }
}
