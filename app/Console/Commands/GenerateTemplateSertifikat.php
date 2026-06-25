<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class GenerateTemplateSertifikat extends Command
{
    protected $signature   = 'template:sertifikat';
    protected $description = 'Generate file Excel template import sertifikat lama ke storage/app/templates/';

    public function handle()
    {
        $this->info('Membuat template sertifikat...');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Sertifikat');

        // ── Row 1 : kosong ────────────────────────────────────────────────────
        // (biarkan kosong, sesuai format yang diinginkan)

        // ── Row 2 : Header ────────────────────────────────────────────────────
        $headers = [
            'A2' => 'No.',
            'B2' => 'Nama Kandidat',
            'C2' => 'Skema Kompetensi',
            'D2' => 'No. Sertifikat',
            'E2' => 'No. Registrasi',
            'F2' => 'Tanggal Terbit',
            'G2' => 'Masa Berlaku',
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Style header: merah bold, center, border
        $headerStyle = [
            'font' => [
                'bold'  => true,
                'color' => ['argb' => 'FFCC0000'], // merah gelap
                'size'  => 11,
                'name'  => 'Calibri',
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FFB0B0B0'],
                ],
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFF2CC'], // kuning muda (seperti Excel default)
            ],
        ];
        $sheet->getStyle('A2:G2')->applyFromArray($headerStyle);

        // ── Row 3-7 : Data contoh ─────────────────────────────────────────────
        $contohData = [
            ['1.', 'Dewi Lestari',    'Pembuatan Batik Tulis',               '95300 2411 0000001 2026', 'REG.ITS.001.06.2026', '11/03/2026', '11/07/2029'],
            ['2.', 'Agus Pratama',    'Pengelola Administrasi Perkantoran',  '95300 2412 0000002 2026', 'REG.IPB.002.06.2026', '11/03/2026', '11/07/2029'],
            ['3.', 'Fitri Handayani', 'Menjahit dengan Mesin Lockstitch',    '95300 2413 0000003 2026', 'REG.MLI.003.06.2026', '11/03/2026', '11/07/2029'],
            ['4.', 'Eko Prasetyo',    'Pembuatan Sampel Garmen',             '95300 2414 0000004 2026', 'REG.MLI.004.06.2026', '11/03/2026', '11/07/2029'],
            ['5.', 'Maya Sari',       'Barista',                             '95300 2411 0000005 2026', 'REG.BTR.005.06.2026', '11/03/2026', '11/07/2029'],
        ];

        $dataStyle = [
            'font' => [
                'name' => 'Calibri',
                'size' => 11,
                'color' => ['argb' => 'FF1F3864'], // biru tua (sesuai screenshot)
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FFD0D0D0'],
                ],
            ],
        ];

        foreach ($contohData as $rowIndex => $rowData) {
            $excelRow = $rowIndex + 3; // mulai dari baris 3
            $cols = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
            foreach ($cols as $colIdx => $col) {
                $sheet->setCellValue("{$col}{$excelRow}", $rowData[$colIdx]);
            }
            $sheet->getStyle("A{$excelRow}:G{$excelRow}")->applyFromArray($dataStyle);
            // Kolom A (No.) center
            $sheet->getStyle("A{$excelRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            // Row height
            $sheet->getRowDimension($excelRow)->setRowHeight(18);
        }

        // ── Lebar kolom ───────────────────────────────────────────────────────
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(38);
        $sheet->getColumnDimension('D')->setWidth(28);
        $sheet->getColumnDimension('E')->setWidth(24);
        $sheet->getColumnDimension('F')->setWidth(16);
        $sheet->getColumnDimension('G')->setWidth(16);

        // Row 2 height
        $sheet->getRowDimension(2)->setRowHeight(20);

        // Freeze pane di A3 agar header tetap terlihat saat scroll
        $sheet->freezePane('A3');

        // ── Simpan file ───────────────────────────────────────────────────────
        $dir = storage_path('app/templates');
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $filePath = $dir . '/template_import_sertifikat.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        $this->info("✅ Template berhasil dibuat: {$filePath}");
        return Command::SUCCESS;
    }
}
