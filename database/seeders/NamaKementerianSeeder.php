<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NamaKementerianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['namaKementerian' => 'Kementerian Koordinator Bidang Politik, Hukum, dan Keamanan', 'kodeKementerian' => '1', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Koordinator Bidang Perekonomian', 'kodeKementerian' => '2', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Koordinator Bidang Pembangunan Manusia dan Kebudayaan', 'kodeKementerian' => '3', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Koordinator Bidang Kemaritiman', 'kodeKementerian' => '4', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Dalam Negeri', 'kodeKementerian' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Luar Negeri', 'kodeKementerian' => '6', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Pertahanan', 'kodeKementerian' => '7', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Agama', 'kodeKementerian' => '8', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Hukum dan Hak Asasi Manusia', 'kodeKementerian' => '9', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Keuangan', 'kodeKementerian' => '10', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Pendidikan dan Kebudayaan', 'kodeKementerian' => '11', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Riset, Teknologi, dan Pendidikan Tinggi', 'kodeKementerian' => '12', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Sosial', 'kodeKementerian' => '13', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Kesehatan', 'kodeKementerian' => '14', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Ketenagakerjaan', 'kodeKementerian' => '15', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Perindustrian', 'kodeKementerian' => '16', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Perdagangan', 'kodeKementerian' => '17', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Energi dan Sumber Daya Mineral', 'kodeKementerian' => '18', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Pekerjaan Umum dan Perumahan Rakyat', 'kodeKementerian' => '19', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Perhubungan', 'kodeKementerian' => '20', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Komunikasi dan Informatika', 'kodeKementerian' => '21', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Pertanian', 'kodeKementerian' => '22', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Lingkungan Hidup dan Kehutanan', 'kodeKementerian' => '23', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Kelautan dan Perikanan', 'kodeKementerian' => '24', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Desa, Pembangunan Daerah Tertinggal, dan Transmigrasi', 'kodeKementerian' => '25', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Agraria dan Tata Ruang', 'kodeKementerian' => '26', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Perencanaan Pembangunan Nasional', 'kodeKementerian' => '27', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Pendayagunaan Aparatur Negara dan Reformasi Birokrasi', 'kodeKementerian' => '28', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Badan Usaha Milik Negara', 'kodeKementerian' => '29', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Koperasi dan Usaha Kecil dan Menengah', 'kodeKementerian' => '30', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Pariwisata', 'kodeKementerian' => '31', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Pemberdayaan Perempuan dan Perlindungan Anak', 'kodeKementerian' => '32', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Kementerian Sekretariat Negara', 'kodeKementerian' => '34', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Lembaga Sandi Negara', 'kodeKementerian' => '35', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Kepegawaian Negara', 'kodeKementerian' => '36', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Lembaga Administrasi Negara', 'kodeKementerian' => '37', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Lembaga Penerbangan dan Antariksa Nasional', 'kodeKementerian' => '38', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Lembaga Ilmu Pengetahuan Indonesia', 'kodeKementerian' => '39', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Tenaga Nuklir Nasional', 'kodeKementerian' => '40', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Pusat Statistik', 'kodeKementerian' => '41', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Arsip Nasional Republik Indonesia', 'kodeKementerian' => '42', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Informasi Geospasial', 'kodeKementerian' => '43', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Kependudukan dan Keluarga Berencana Nasional (BKKBN)', 'kodeKementerian' => '44', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Koordinasi Penanaman Modal', 'kodeKementerian' => '45', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Pengkajian dan Penerapan Teknologi', 'kodeKementerian' => '46', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Pengawasan Keuangan dan Pembangunan', 'kodeKementerian' => '47', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Perpustakaan Nasional', 'kodeKementerian' => '48', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Standardisasi Nasional', 'kodeKementerian' => '49', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Pengawas Obat dan Makanan', 'kodeKementerian' => '50', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Lembaga Ketahanan Nasional RI', 'kodeKementerian' => '51', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Meteorologi Klimatologi dan Geofisika', 'kodeKementerian' => '52', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Narkotika Nasional', 'kodeKementerian' => '53', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Nasional Penanggulangan Bencana', 'kodeKementerian' => '54', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Nasional Penempatan dan Perlindungan Tenaga Kerja Indonesia', 'kodeKementerian' => '55', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Keamanan Laut', 'kodeKementerian' => '56', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Nasional Pencarian dan Pertolongan (Badan SAR Nasional)', 'kodeKementerian' => '57', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah', 'kodeKementerian' => '58', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Nasional Penanggulangan Terorisme', 'kodeKementerian' => '59', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Ekonomi Kreatif', 'kodeKementerian' => '60', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Badan Pengawas Tenaga Nuklir', 'kodeKementerian' => '61', 'created_at' => $now, 'updated_at' => $now],
            ['namaKementerian' => 'Biaya dari Pemda', 'kodeKementerian' => '62', 'created_at' => $now, 'updated_at' => $now], 
            ['namaKementerian' => 'Biaya Mandiri', 'kodeKementerian' => '100', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('nama_kementerian')->insert($data);
    }
}
