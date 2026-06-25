<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TemplateFile;

class TemplateNominatifSeeder extends Seeder
{
    public function run(): void
    {
        $storagePath = "C:/Users/HP/Downloads/Template Nominatif UJK 2026 (1).xlsx";

        if (!file_exists($storagePath)) {
            $this->command->warn('File template nominatif tidak ditemukan. Seeder dilewati.');
            return;
        }

        $fileContent = file_get_contents($storagePath);
        $base64      = base64_encode($fileContent);

        TemplateFile::updateOrCreate(
            ['nama' => 'template_nominatif'],
            [
                'nama_file' => 'Template Nominatif UJK 2026.xlsx',
                'mime_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'data'      => $base64,
            ]
        );

        $this->command->info('✅ Template nominatif berhasil disimpan ke database.');
    }
}
