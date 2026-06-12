<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NamaPekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('nama_pekerjaan')->truncate();
        $now = Carbon::now();
        $data = [
            ['namaPekerjaan' => 'Belum/Tidak Bekerja', 'kodePekerjaan' => '1', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Mengurus Rumah Tangga', 'kodePekerjaan' => '2', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pelajar/Mahasiswa', 'kodePekerjaan' => '3', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pensiunan', 'kodePekerjaan' => '4', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pegawai Negeri Sipil (PNS)', 'kodePekerjaan' => '5', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tentara Nasional Indonesia (TNI)', 'kodePekerjaan' => '6', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Kepolisian RI (POLRI)', 'kodePekerjaan' => '7', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Perdagangan', 'kodePekerjaan' => '8', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Petani/Pekebun', 'kodePekerjaan' => '9', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Peternak', 'kodePekerjaan' => '10', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Nelayan/Perikanan', 'kodePekerjaan' => '11', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Industri', 'kodePekerjaan' => '12', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Konstruksi', 'kodePekerjaan' => '13', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Transportasi', 'kodePekerjaan' => '14', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Karyawan Swasta', 'kodePekerjaan' => '15', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Karyawan BUMN', 'kodePekerjaan' => '16', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Karyawan BUMD', 'kodePekerjaan' => '17', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Karyawan Honorer', 'kodePekerjaan' => '18', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Buruh Harian Lepas', 'kodePekerjaan' => '19', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Buruh Tani/Perkebunan', 'kodePekerjaan' => '20', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Buruh Nelayan/Perikanan', 'kodePekerjaan' => '21', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Buruh Peternakan', 'kodePekerjaan' => '22', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pembantu Rumah Tangga', 'kodePekerjaan' => '23', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tukang Cukur', 'kodePekerjaan' => '24', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tukang Listrik', 'kodePekerjaan' => '25', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tukang Batu', 'kodePekerjaan' => '26', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tukang Kayu', 'kodePekerjaan' => '27', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tukang Sol Sepatu', 'kodePekerjaan' => '28', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tukang Las/Pandai Besi', 'kodePekerjaan' => '29', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tukang Jahit', 'kodePekerjaan' => '30', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tukang Gigi', 'kodePekerjaan' => '31', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Penata Rias', 'kodePekerjaan' => '32', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Penata Busana', 'kodePekerjaan' => '33', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Penata Rambut', 'kodePekerjaan' => '34', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Mekanik', 'kodePekerjaan' => '35', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Seniman', 'kodePekerjaan' => '36', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Tabib', 'kodePekerjaan' => '37', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Paraji', 'kodePekerjaan' => '38', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Perancang Busana', 'kodePekerjaan' => '39', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Penterjemah', 'kodePekerjaan' => '40', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Imam Masjid', 'kode' => '41', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pendeta', 'kodePekerjaan' => '42', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pastor', 'kodePekerjaan' => '43', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Wartawan', 'kodePekerjaan' => '44', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Ustaz/Mubaligh', 'kodePekerjaan' => '45', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Juru Masak', 'kodePekerjaan' => '46', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Promotor Acara', 'kodePekerjaan' => '47', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Anggota DPR-RI', 'kodePekerjaan' => '48', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Anggota DPD', 'kodePekerjaan' => '49', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Anggota BPK', 'kodePekerjaan' => '50', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Presiden', 'kodePekerjaan' => '51', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Wakil Presiden', 'kodePekerjaan' => '52', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Anggota Mahkamah', 'kodePekerjaan' => '53', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Konstitusi', 'kodePekerjaan' => '54', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Anggota Kabinet/Kementerian', 'kodePekerjaan' => '55', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Duta Besar', 'kodePekerjaan' => '56', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Gubernur', 'kodePekerjaan' => '57', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Wakil Gubernur', 'kodePekerjaan' => '58', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Bupati', 'kodePekerjaan' => '59', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Wakil Bupati', 'kodePekerjaan' => '60', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Walikota', 'kodePekerjaan' => '61', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Wakil Walikota', 'kodePekerjaan' => '62', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Anggota DPRD Provinsi/ Anggota DPRD Kabupaten/Kota', 'kodePekerjaan' => '63', 'created_at' => $now, 'updated_at' => $now], // Data dari gambarmu
            ['namaPekerjaan' => 'Dosen', 'kodePekerjaan' => '64', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Guru', 'kodePekerjaan' => '65', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pilot', 'kodePekerjaan' => '66', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pengacara', 'kodePekerjaan' => '67', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Notaris', 'kodePekerjaan' => '68', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Arsitek', 'kodePekerjaan' => '69', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Akuntan', 'kodePekerjaan' => '70', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Konsultan', 'kodePekerjaan' => '71', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Dokter', 'kodePekerjaan' => '72', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Bidan', 'kodePekerjaan' => '73', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Perawat', 'kodePekerjaan' => '74', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Apoteker', 'kodePekerjaan' => '75', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Psikiater/Psikolog', 'kodePekerjaan' => '76', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Penyiar Televisi', 'kodePekerjaan' => '77', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Penyiar Radio', 'kodePekerjaan' => '78', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pelaut', 'kodePekerjaan' => '79', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Peneliti', 'kodePekerjaan' => '80', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Sopir', 'kodePekerjaan' => '81', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pialang', 'kodePekerjaan' => '82', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Paranormal', 'kodePekerjaan' => '83', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Pedagang', 'kodePekerjaan' => '84', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Perangkat Desa', 'kodePekerjaan' => '85', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Kepala Desa', 'kodePekerjaan' => '86', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Biarawati', 'kodePekerjaan' => '87', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Wiraswasta', 'kodePekerjaan' => '88', 'created_at' => $now, 'updated_at' => $now],
            ['namaPekerjaan' => 'Lainnya', 'kodePekerjaan' => '89', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('nama_pekerjaan')->insertOrIgnore($data);
    }
}
