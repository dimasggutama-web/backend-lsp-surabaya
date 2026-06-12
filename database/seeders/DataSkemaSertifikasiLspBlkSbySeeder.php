<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataSkemaSertifikasiLspBlkSbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        
        $semuaBidang = DB::table('bidang')->get();
        $kamusBidang = [];
        foreach ($semuaBidang as $bidang) {
            $kodePadded = str_pad($bidang->kodeBidang, 3, '0', STR_PAD_LEFT);
            $kamusBidang[$kodePadded] = $bidang->id;
        }
        $data = [
            // BATIK
            ['namaSkema' => 'Pembuatan Batik Tulis', 'kodeSkema' => 'SS.BATIK-013-001-LSP.BLK SURABAYA-2026', 'profesi' => 'Pembatik', 'bidang' => 'Batik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Membatik Dengan Canting', 'kodeSkema' => 'SS.BATIK-013-002-LSP BLK SURABAYA-2026', 'profesi' => 'Pembatik', 'bidang' => 'Batik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],

            // BISMAN
            ['namaSkema' => 'Junior Administrative Assistant', 'kodeSkema' => 'SS.BISMAN-005-001-LSP.BLK SURABAYA-2026', 'profesi' => 'Bisman', 'bidang' => 'Bisman', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pelayanan Pelanggan', 'kodeSkema' => 'SS.BISMAN-005-002-LSP BLK SURABAYA-2026', 'profesi' => 'Bisman', 'bidang' => 'Bisman', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pengelola Administrasi Perkantoran', 'kodeSkema' => 'SS.BISMAN-005-003-LSP BLK SURABAYA-2026', 'profesi' => 'Bisman', 'bidang' => 'Bisman', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi Akuntansi Junior', 'kodeSkema' => 'SS.BISMAN-005-004-LSP BLK SURABAYA-2026', 'profesi' => 'Bisman', 'bidang' => 'Bisman', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Junior Sekretaris', 'kodeSkema' => 'SS.BISMAN-005-005-LSP BLK SURABAYA-2026', 'profesi' => 'Bisman', 'bidang' => 'Bisman', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],

            // ELEKTRO
            ['namaSkema' => 'Teknisi Embedded System (Microcontroller)', 'kodeSkema' => 'SS.ELEKTRO-015-001-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Elektronika', 'bidang' => 'Elektronika', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi Telepon Seluler Perangkat Keras', 'kodeSkema' => 'SS.ELEKTRO-015-002-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Elektronika', 'bidang' => 'Elektronika', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi Telepon Seluler Perangkat Lunak', 'kodeSkema' => 'SS.ELEKTRO-015-003-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Elektronika', 'bidang' => 'Elektronika', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi Audio Video', 'kodeSkema' => 'SS.ELEKTRO-015-004-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Elektronika', 'bidang' => 'Elektronika', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi Otomasi Elektronika Industri', 'kodeSkema' => 'SS.ELEKTRO-015-005-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Elektronika', 'bidang' => 'Elektronika', 'jenisSkema' => 'OKUPASI','created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemograman Smart Home (Rumah Cerdas)', 'kodeSkema' => 'SS.ELEKTRO-015-006-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Elektronika', 'bidang' => 'Elektronika', 'jenisSkema' => 'OKUPASI','created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Operator Pengoperasian Otomasi Elektronika Industri', 'kodeSkema' => 'SS.ELEKTRO-015-007-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Elektronika', 'bidang' => 'Elektronika', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],

            // GARMEN
            ['namaSkema' => 'Menjahit dengan Mesin Lockstich', 'kodeSkema' => 'SS.GARMEN-010-001-LSP BLK SURABAYA-2026', 'profesi' => 'Operator Garmen', 'bidang' => 'Garmen', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pembuatan Sampel Garmen', 'kodeSkema' => 'SS.GARMEN-010-002-LSP BLK SURABAYA-2026', 'profesi' => 'Operator Garmen', 'bidang' => 'Garmen', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Menjahit Upper Sepatu', 'kodeSkema' => 'SS.GARMEN-010-003-LSP BLK SURABAYA-2026', 'profesi' => 'Operator Garmen', 'bidang' => 'Garmen', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Perancangan Desain Busana', 'kodeSkema' => 'SS.GARMEN-010-004-LSP BLK SURABAYA-2026', 'profesi' => 'Operator Garmen', 'bidang' => 'Garmen', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Operator Sewing', 'kodeSkema' => 'SS.GARMEN-010-005-LSP BLK SURABAYA-2026', 'profesi' => 'Operator Garmen', 'bidang' => 'Garmen', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pembuatan Hiasan Busana Dengan Mesin Bordir Manual', 'kodeSkema' => 'SS.GARMEN-010-006-LSP BLK SURABAYA-2026', 'profesi' => 'Operator Garmen', 'bidang' => 'Garmen', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],

            // LAS
            ['namaSkema' => 'Plate Welder GTAW 1G/PA', 'kodeSkema' => 'SS.LAS-002-001-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Plate Welder SMAW 3G-Up/PF', 'kodeSkema' => 'SS.LAS-002-002-LSP.BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Fillet Welder SMAW 3F /PF', 'kodeSkema' => 'SS.LAS-002-003-LSP.BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Fillet Welder GMAW 3F /PF', 'kodeSkema' => 'SS.LAS-002-004-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Fillet Welder FCAW 3F /PF', 'kodeSkema' => 'SS.LAS-002-005-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Fillet Welder GTAW 3F/PF', 'kodeSkema' => 'SS.LAS-002-006-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Plate Welder SMAW 1G/PA', 'kodeSkema' => 'SS.LAS-002-007-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Plate Welder GMAW 1G/PA', 'kodeSkema' => 'SS.LAS-002-008-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Plate Welder FCAW 1G/PA', 'kodeSkema' => 'SS.LAS-002-009-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Plate Welder GMAW 3G-Up/PF', 'kodeSkema' => 'SS.LAS-002-010-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Plate Welder FCAW 3G-Up/PF', 'kodeSkema' => 'SS.LAS-002-011-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Plate Welder GTAW 3G-Up/PF', 'kodeSkema' => 'SS.LAS-002-012-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pipe Welder SMAW 6GUp Hill/HL0-45', 'kodeSkema' => 'SS.LAS-002-013-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pipe Welder GTAW-SMAW 6G Up Hill/HL0-45', 'kodeSkema' => 'SS.LAS-002-014-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pipe Welder SMAW 1G/PA', 'kodeSkema' => 'SS.LAS-002-015-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pipe Welder SMAW 2G/PC', 'kodeSkema' => 'SS.LAS-002-016-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pipe Welder GTAW 6G Up Hill/HL0-45', 'kodeSkema' => 'SS.LAS-002-017-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pipe Welder GMAW 6G Up Hill/HL0-45', 'kodeSkema' => 'SS.LAS-002-018-LSP BLK SURABAYA-2026', 'profesi' => 'Juru Las', 'bidang' => 'Las', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],

            // LISTRIK
            ['namaSkema' => 'Pemasangan Instalasi Listrik Bangunan Sederhana', 'kodeSkema' => 'SS.LISTRIK-004-001-LSP BLK SURABAYA-2026', 'profesi' => 'Instalatir Listrik', 'bidang' => 'Listrik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemasangan Instalasi Otomasi Listrik Industri', 'kodeSkema' => 'SS.LISTRIK-004-002-LSP BLK SURABAYA-2026', 'profesi' => 'Instalatir Listrik', 'bidang' => 'Listrik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pengoperasian Instalasi Kontrol Industri Berbasis PLC', 'kodeSkema' => 'SS.LISTRIK-004-003-LSP BLK SURABAYA-2026', 'profesi' => 'Instalatir Listrik', 'bidang' => 'Listrik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pembuatan Program Sistem Kontrol Kelistrikan Dan Pneumatic Berbasis PLC', 'kodeSkema' => 'SS.LISTRIK-004-004-LSP BLK SURABAYA-2026', 'profesi' => 'Instalatir Listrik', 'bidang' => 'Listrik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pembuatan Program Human Machine Interface Berbasis PLC', 'kodeSkema' => 'SS.LISTRIK-004-005-LSP BLK SURABAYA-2026', 'profesi' => 'Instalatir Listrik', 'bidang' => 'Listrik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemasangan Pembangkit Listrik Tenaga Surya Off Grid', 'kodeSkema' => 'SS.LISTRIK-004-006-LSP BLK SURABAYA-2026', 'profesi' => 'Instalatir Listrik', 'bidang' => 'Listrik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemasangan Pembangkit Listrik Tenaga Surya On Grid', 'kodeSkema' => 'SS.LISTRIK-004-007-LSP BLK SURABAYA-2026', 'profesi' => 'Instalatir Listrik', 'bidang' => 'Listrik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pengoperasian Instrumen Dan Kontrol', 'kodeSkema' => 'SS.LISTRIK-004-008-LSP.BLK SURABAYA-2026', 'profesi' => 'Instalatir Listrik', 'bidang' => 'Listrik', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],

            // MANUFAKTUR
            ['namaSkema' => 'Pengoperasian Mesin CNC', 'kodeSkema' => 'SS.MANUFAKTUR-001-001-LSP BLK SURABAYA-2026', 'profesi' => 'Operator Mesin', 'bidang' => 'Manufaktur', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Penggambaran Model 3D dengan CAD', 'kodeSkema' => 'SS.MANUFAKTUR-001-002-LSP BLK SURABAYA-2026', 'profesi' => 'Drafter CAD', 'bidang' => 'Manufaktur', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pengoperasian Mesin Bubut', 'kodeSkema' => 'SS.MANUFAKTUR-001-003-LSP BLK SURABAYA-2026', 'profesi' => 'Operator Mesin', 'bidang' => 'Manufaktur', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pengoperasian Mesin CNC dengan Program CAM', 'kodeSkema' => 'SS.MANUFAKTUR-001-004-LSP.BLK SURABAYA-2026', 'profesi' => 'Operator Mesin', 'bidang' => 'Manufaktur', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pengoperasian Mesin Produksi', 'kodeSkema' => 'SS.MANUFAKTUR-001-005-LSP BLK SURABAYA-2026', 'profesi' => 'Operator Mesin', 'bidang' => 'Manufaktur', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],

            // METODOLOGI
            ['namaSkema' => 'Instruktur Terampil', 'kodeSkema' => 'SS.METODOLOGI-016-001-LSP BLK SURABAYA-2026', 'profesi' => 'Instruktur Latihan Kerja', 'bidang' => 'Metodologi', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Instruktur Pertama', 'kodeSkema' => 'SS.METODOLOGI-016-002-LSP BLK SURABAYA-2026', 'profesi' => 'Instruktur Latihan Kerja', 'bidang' => 'Metodologi', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pelaksanaan Pelatihan Tatap Muka', 'kodeSkema' => 'SS.METODOLOGI-016-003-LSP BLK SURABAYA-2026', 'profesi' => 'Instruktur Latihan Kerja', 'bidang' => 'Metodologi', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],

            // OTOMOTIF
            ['namaSkema' => 'Service Sepeda Motor Injeksi', 'kodeSkema' => 'SS.OTOMOTIF-003-001-LSP.BLK SURABAYA-2026', 'profesi' => 'Mekanik Otomotif', 'bidang' => 'Otomotif', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Service Sepeda Motor Konvensional', 'kodeSkema' => 'SS.OTOMOTIF-003-002-LSP.BLK SURABAYA-2026', 'profesi' => 'Mekanik Otomotif', 'bidang' => 'Otomotif', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Tune Up Mesin Diesel', 'kodeSkema' => 'SS.OTOMOTIF-003-003-LSP BLK SURABAYA-2026', 'profesi' => 'Mekanik Otomotif', 'bidang' => 'Otomotif', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemeliharaan Kendaraan Ringan Sistem Injeksi', 'kodeSkema' => 'SS.OTOMOTIF-003-004-LSP.BLK SURABAYA-2026', 'profesi' => 'Mekanik Otomotif', 'bidang' => 'Otomotif', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemeliharaan Berkala Kendaraan Ringan', 'kodeSkema' => 'SS.OTOMOTIF-003-005-LSP BLK SURABAYA-2026', 'profesi' => 'Mekanik Otomotif', 'bidang' => 'Otomotif', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemeliharaan Kendaraan Ringan Sistem Konvensional', 'kodeSkema' => 'SS.OTOMOTIF-003-006-LSP BLK SURABAYA-2026', 'profesi' => 'Mekanik Otomotif', 'bidang' => 'Otomotif','jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pengoperasian Forklift', 'kodeSkema' => 'SS.OTOMOTIF-003-007-LSP BLK SURABAYA-2026', 'profesi' => 'Mekanik Otomotif', 'bidang' => 'Otomotif', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Operator Wheel Excavator', 'kodeSkema' => 'SS.OTOMOTIF-003-008-LSP BLK SURABAYA-2026', 'profesi' => 'Mekanik Otomotif', 'bidang' => 'Otomotif', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Operator Backhoe Loader', 'kodeSkema' => 'SS.OTOMOTIF-003-009-LSP BLK SURABAYA-2026', 'profesi' => 'Mekanik Otomotif', 'bidang' => 'Otomotif', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],

            // PARIWISATA
            ['namaSkema' => 'Housekeeping', 'kodeSkema' => 'SS.PARIWISATA-011-001-LSP BLK SURABAYA-2026', 'profesi' => 'Perhotelan', 'bidang' => 'Pariwisata', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Restaurant Attendant', 'kodeSkema' => 'SS.PARIWISATA-011-002-LSP BLK SURABAYA-2026', 'profesi' => 'Perhotelan', 'bidang' => 'Pariwisata', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Bakery', 'kodeSkema' => 'SS.PARIWISATA-011-003-LSP BLK SURABAYA-2026', 'profesi' => 'Perhotelan', 'bidang' => 'Pariwisata', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pembuatan Produk Roti dan Pattiserie', 'kodeSkema' => 'SS.PARIWISATA-011-004-LSP BLK SURABAYA-2026', 'profesi' => 'Perhotelan', 'bidang' => 'Pariwisata', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Room Attendant', 'kodeSkema' => 'SS.PARIWISATA-011-005-LSP BLK SURABAYA-2026', 'profesi' => 'Perhotelan', 'bidang' => 'Pariwisata', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Room Division', 'kodeSkema' => 'SS.PARIWISATA-011-006-LSP BLK SURABAYA-2026', 'profesi' => 'Perhotelan', 'bidang' => 'Pariwisata', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pembuatan Roti Dan Kue', 'kodeSkema' => 'SS.PARIWISATA-011-007-LSP BLK SURABAYA-2026', 'profesi' => 'Perhotelan', 'bidang' => 'Pariwisata', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Barista', 'kodeSkema' => 'SS.PARIWISATA-011-008-LSP BLK SURABAYA-2026', 'profesi' => 'Perhotelan', 'bidang' => 'Pariwisata', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],

            // REFRIGRASI
            ['namaSkema' => 'Asisten Teknisi Refrigerasi dan AC (RAC)', 'kodeSkema' => 'SS.REFRIGRASI-006-001-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Refrigerasi', 'bidang' => 'Refrigerasi', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi Perawatan AC Residential', 'kodeSkema' => 'SS.REFRIGRASI-006-002-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Refrigerasi', 'bidang' => 'Refrigerasi', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi AC Residential', 'kodeSkema' => 'SS.REFRIGRASI-006-003-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Refrigerasi', 'bidang' => 'Refrigerasi', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi Refrigerasi Domestik', 'kodeSkema' => 'SS.REFRIGRASI-006-004-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Refrigerasi', 'bidang' => 'Refrigerasi', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi Pemasangan Refrigerasi dan AC', 'kodeSkema' => 'SS.REFRIGRASI-006-005-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Refrigerasi', 'bidang' =>  'Refrigerasi', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemeliharaan dan Perbaikan AC untuk Rumah Tangga', 'kodeSkema' => 'SS.REFRIGRASI-006-006-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Refrigerasi', 'bidang' => 'Refrigerasi', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],

            // RIAS
            ['namaSkema' => 'Tata Rias Pengantin Muslim Modifikasi', 'kodeSkema' => 'SS.RIAS-008-001-LSP BLK SURABAYA-2026', 'profesi' => 'Perias', 'bidang' => 'Tata Rias', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Tata Rias Pengantin Gaun Panjang', 'kodeSkema' => 'SS.RIAS-008-002-LSP BLK SURABAYA-2026', 'profesi' => 'Perias', 'bidang' => 'Tata Rias', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],

            // TIK
            ['namaSkema' => 'Multimedia', 'kodeSkema' => 'SS.TIK-009-001-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemasangan Jaringan Komputer', 'kodeSkema' => 'SS.TIK-009-002-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Perakitan Komputer', 'kodeSkema' => 'SS.TIK-009-003-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Practical Office Advance', 'kodeSkema' => 'SS.TIK-009-004-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Practical Office', 'kodeSkema' => 'SS.TIK-009-005-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pembuatan Desain Grafis', 'kodeSkema' => 'SS.TIK-009-006-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemrograman Perangkat Lunak untuk Bisnis', 'kodeSkema' => 'SS.TIK-009-007-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Computer Operator Asistant', 'kodeSkema' => 'SS.TIK-009-008-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pemrograman Web', 'kodeSkema' => 'SS.TIK-009-009-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Desainer Grafis Madya', 'kodeSkema' => 'SS.TIK-009-010-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Basic Office', 'kodeSkema' => 'SS.TIK-009-011-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pembuatan Aset Animasi 3D', 'kodeSkema' => 'SS.TIK-009-012-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Desainer Grafis Muda', 'kodeSkema' => 'SS.TIK-009-013-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Operator Komputer Muda', 'kodeSkema' => 'SS.TIK-009-014-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Pembuatan Gerak Animasi 3D', 'kodeSkema' => 'SS.TIK-009-015-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'KLASTER', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Junior Web Developer', 'kodeSkema' => 'SS.TIK-009-016-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Animator Muda (Junior Animator)', 'kodeSkema' => 'SS.TIK-009-017-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Video Editor', 'kodeSkema' => 'SS.TIK-009-018-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
            ['namaSkema' => 'Teknisi Utama Jaringan Komputer', 'kodeSkema' => 'SS.TIK-009-019-LSP BLK SURABAYA-2026', 'profesi' => 'Teknisi Komputer', 'bidang' => 'TIK', 'jenisSkema' => 'OKUPASI', 'created_at' => $now, 'updated_at' => $now],
        ];
        $dataInsertYangBersih = [];
        foreach ($data as $skema) {
           $potongan = explode('-', $skema['kodeSkema']);
           $bidangIdDitemukan = null;
           if (count($potongan) >= 2) {
                $kodeBidang = $potongan[1];
                if (isset($kamusBidang[$kodeBidang])) {
                    $bidangIdDitemukan = $kamusBidang[$kodeBidang]; 
                }
            }
            $dataInsertYangBersih[] = [
                'namaSkema'  => $skema['namaSkema'],
                'kodeSkema'  => $skema['kodeSkema'],
                'profesi'    => $skema['profesi'],
                'bidang_id'  => $bidangIdDitemukan, 
                'jenisSkema' => $skema['jenisSkema'],
                'created_at' => $skema['created_at'],
                'updated_at' => $skema['updated_at'],
            ];
        }
        DB::table('data_skema_sertifikasi_lsp_blk_sby')->insert($dataInsertYangBersih);
    }
}
