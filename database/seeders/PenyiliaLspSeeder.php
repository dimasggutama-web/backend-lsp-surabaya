<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenyiliaLspSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penyilia_lsp')->truncate();
        $now = Carbon::now();
        $data = [
            ['namaPenyilia' => 'Miftahul Huda', 'jabatan' => 'Manajer Administrasi', 'noRegistrasi' => 'REG.LSP-254-0001-2024', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Bibiet Andrianto JR', 'jabatan' => 'Ketua LSP', 'noRegistrasi' => 'REG.LSP-254-0002-20244', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Onie Meiyanto', 'jabatan' => 'Manajer Mutu', 'noRegistrasi' => 'REG.LSP-254-0003-2024', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Ongki Permono Aji', 'jabatan' => 'Koordinator Skema', 'noRegistrasi' => 'REG.LSP-254-0004-2024', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Mohamad Andrian A', 'jabatan' => 'Manajer Data dan Informasi', 'noRegistrasi' => 'REG.LSP-254-0005-2024', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Yudo Sembodo H.L', 'jabatan' => 'Manajer Sertifikasi', 'noRegistrasi' => 'REG.LSP-254-0006-2024', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/30', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Emi Dwi Wulandario', 'jabatan' => 'Staf Keuangan', 'noRegistrasi' => 'REG.LSP-254-0007-2024', 'institusi' => 'Bidang Keuangan Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur', 'alamat' => 'Jl. Dukuh Menanggal 124-126', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Bani Sofwansyaho', 'jabatan' => 'Staf Sertifikasii', 'noRegistrasi' => 'REG.LSP-254-0009-2024', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Irfan', 'jabatan' => 'Staf Sertifikasi', 'noRegistrasi' => 'REG.LSP-254-0010-2024', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Ramadhan Budi Prasetyo', 'jabatan' => 'Staf Data', 'noRegistrasi' => 'REG.LSP-254-0011-2024', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
            ['namaPenyilia' => 'Rizqi Octavian Nur Firmansyaho', 'jabatan' => 'Staf Administrasi ', 'noRegistrasi' => 'REG.LSP-254-0001-2025', 'institusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('penyilia_lsp')->insertOrIgnore($data);
    }
}
