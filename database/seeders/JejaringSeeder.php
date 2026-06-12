<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JejaringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['namaInstitusi' => 'UPT BLK Surabaya', 'alamat' => 'Jl. Dukuh Menanggal III/29', 'kota' => 'Surabaya', 'kodeInstitusi' => '001', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Mojokerto', 'alamat' => 'Jl. Raya Jabon', 'kota' => 'Mojokerto', 'kodeInstitusi' => '002', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Jombang', 'alamat' => 'Jl. Anggrek No. 04', 'kota' => 'Jombang', 'kodeInstitusi' => '003', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Nganjuk', 'alamat' => 'Jl. Kapten Kasihin HS. No 3', 'kota' => 'Nganjuk', 'kodeInstitusi' => '004', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Madiun', 'alamat' => 'Jl. Sumatra No. 27', 'kota' => 'Madiun', 'kodeInstitusi' => '005', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Ponorogo', 'alamat' => 'Jl. Ngudi Kaweruh, Karanglo Lor', 'kota' => 'Ponorogo', 'kodeInstitusi' => '006', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Bojonegoro', 'alamat' => 'Jl. KH. R. Moh. Rosyid', 'kota' => 'Bojonegoro', 'kodeInstitusi' => '007', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Tuban', 'alamat' => 'Jl. Dr. Wahidin Sudiro Husodo', 'kota' => 'Tuban', 'kodeInstitusi' => '008', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Sumenep', 'alamat' => 'Jl. Gapura Parsanga', 'kota' => 'Sumenep', 'kodeInstitusi' => '009', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLK NTB', 'alamat' => 'Jl. TGH Saleh Hambali No 2', 'kota' => 'Mataram', 'kodeInstitusi' => '012', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLK Bangkalan', 'alamat' => 'Jl. Halim Perdana Kusuma No 2', 'kota' => 'Bangkalan', 'kodeInstitusi' => '013', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LLK Selong', 'alamat' => 'Jl. Selaparang No. 3', 'kota' => 'Selong', 'kodeInstitusi' => '017', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLK Lombok Tengah', 'alamat' => 'Jl. Pejanggik No. 3', 'kota' => 'Praya', 'kodeInstitusi' => '018', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Jember', 'alamat' => 'Jl. Basuki Rahmat No. 203', 'kota' => 'Jember', 'kodeInstitusi' => '019', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Tulungagung', 'alamat' => 'Jl. Raya Pulosari No. KM 8, Salamrejo', 'kota' => 'Tulungagung', 'kodeInstitusi' => '020', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BPVP Sidoarjo', 'alamat' => 'Jl. Raya Kebaron No 1', 'kota' => 'Sidoarjo', 'kodeInstitusi' => '023', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLK Pamekasan', 'alamat' => 'Lebi, Ceguk, Tlanakan', 'kota' => 'Pamekasan', 'kodeInstitusi' => '024', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLK Sampang', 'alamat' => 'Jl. Syamsul Arifin', 'kota' => 'Sampang', 'kodeInstitusi' => '025', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Wonojati', 'alamat' => 'Jl. Raya Mondoro No.1', 'kota' => 'Malang', 'kodeInstitusi' => '030', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPK Melangta Trainee Centre', 'alamat' => 'KSB Kav. Pelopor Blok. A 233 / C 33', 'kota' => 'Batam', 'kodeInstitusi' => '031', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPK Modes Sri Rejeki Jombang', 'alamat' => 'Jl. KH Hasyim Asy\'ari IV / 3', 'kota' => 'Jombang', 'kodeInstitusi' => '032', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPK Inti Komputer', 'alamat' => 'Jl. DR. Sutomo No.67', 'kota' => 'Pare', 'kodeInstitusi' => '034', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Pasuruan', 'alamat' => 'Jl. Pahlawan Sunaryo No 96S', 'kota' => 'Pasuruan', 'kodeInstitusi' => '037', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPTD BLK Sumbawa', 'alamat' => 'Jl. Garuda No 79A', 'kota' => 'Sumbawa', 'kodeInstitusi' => '038', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMK Sultan Agung 2 Tebuireng Jombang', 'alamat' => 'Jl. Jatipelem No. 09', 'kota' => 'Jombang', 'kodeInstitusi' => '039', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Kediri', 'alamat' => 'Jl. Pare-Wates, Ds Gedangsewu', 'kota' => 'Kediri', 'kodeInstitusi' => '040', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT LKD Kab Pasuruan', 'alamat' => 'Jl. Raya Pasuruan Km 4', 'kota' => 'Kab Pasuruan', 'kodeInstitusi' => '041', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Universitas Muhammadiyah Sidoarjo', 'alamat' => 'Jl. Raya Celam No 250', 'kota' => 'Kab. Sidoarjo', 'kodeInstitusi' => '042', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Kepulauan Arjasa', 'alamat' => 'Pandeman, Arjasa, Kabupaten Sumenep', 'kota' => 'Kab. Sumenep', 'kodeInstitusi' => '043', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BPVP BLK Banyuwangi', 'alamat' => 'Jl. Ahmad Yani, Krajan, Kedungrejo Muncar', 'kota' => 'Banyuwangi', 'kodeInstitusi' => '044', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Dinas Tenaga Kerja Kabupaten Sidoarjo', 'alamat' => 'Jl. Raya Jati No. 4 Sidoarjo', 'kota' => 'Sidoarjo', 'kodeInstitusi' => '045', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPK Femy', 'alamat' => 'Jl. Taman Melati No 10', 'kota' => 'Kediri', 'kodeInstitusi' => '047', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Lamongan', 'alamat' => 'Boringin, Tumenggungan', 'kota' => 'Lamongan', 'kodeInstitusi' => '048', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMKN 1 Mojokerto', 'alamat' => 'Jl. Kedung Sari, Mergelo', 'kota' => 'Mojokerto', 'kodeInstitusi' => '049', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMKN 2 Mojokerto', 'alamat' => 'Jl. Pulorejo', 'kota' => 'Mojokerto', 'kodeInstitusi' => '050', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPTD BLK Sumbawa Barat', 'alamat' => 'Jl. Raya Poto Tano', 'kota' => 'Sumbawa Barat', 'kodeInstitusi' => '051', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPTD BLK Kudus', 'alamat' => 'Jl. Conge Ngembalrejo No. 99', 'kota' => 'Kudus', 'kodeInstitusi' => '052', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLK Kabupaten Batang', 'alamat' => 'Gg. 32, Kalisalak, Kauman', 'kota' => 'Batang', 'kodeInstitusi' => '053', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Kab Tulungagung', 'alamat' => 'Jl. Joyong Kusuma No 19', 'kota' => 'Tulungagung', 'kodeInstitusi' => '054', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Dinas Tenaga Kerja Kab Mojokerto', 'alamat' => 'Jl. Pemuda No. 55 A', 'kota' => 'Mojokerto', 'kodeInstitusi' => '055', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPK Minhajut Thullab', 'alamat' => 'Dsn. Jawot Ds. Dukuhdimoro', 'kota' => 'Jombang', 'kodeInstitusi' => '056', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPTD BLK Kota Pekalongan', 'alamat' => 'Jl. Hos Cokroaminoto', 'kota' => 'Pekalongan', 'kodeInstitusi' => '057', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLKK Nurul Islam', 'alamat' => 'Ds. Karangcempaka Kecamatan Bluto', 'kota' => 'Sumenep', 'kodeInstitusi' => '058', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Situbondo', 'alamat' => 'Jl. Basuki Rahmat No. 357', 'kota' => 'Situbondo', 'kodeInstitusi' => '059', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLKK Darut Thayyibah', 'alamat' => 'Legung Timur Batang', 'kota' => 'Sumenep', 'kodeInstitusi' => '060', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPTD BLKI Balikpapan', 'alamat' => 'Jl. Sepinggan Baru No. 31', 'kota' => 'Balikpapan', 'kodeInstitusi' => '061', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPKS Citra Catur Utama Karya', 'alamat' => 'Jl. Wringinanom Km-32 Lebaniwaras', 'kota' => 'Gresik', 'kodeInstitusi' => '062', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLKK Yayasan 1001 Ilmu', 'alamat' => 'Jl. Wali Sodiran No. 2 Podang Laju', 'kota' => 'Tuban', 'kodeInstitusi' => '063', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPK Intermedia', 'alamat' => 'Jl. Kelapa Gading 57B Rembang', 'kota' => 'Blitar', 'kodeInstitusi' => '064', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BPVP Ternate', 'alamat' => 'Jl. Melati Kel. Bastiong', 'kota' => 'Ternate', 'kodeInstitusi' => '065', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLKK Yayasan Fatimah Binti Said Gauzan', 'alamat' => 'Ds. Jabaan Kecamatan Manding', 'kota' => 'Sumenep', 'kodeInstitusi' => '066', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'PT. Alkon Trainindo Utama', 'alamat' => 'Pulau Obi', 'kota' => 'Maluku Utara', 'kodeInstitusi' => '067', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPK Lasa Padma Trawang', 'alamat' => 'Jl. Niam Kiri Kepanjen Kidul', 'kota' => 'Blitar', 'kodeInstitusi' => '068', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLKK Al Amien Prenduan', 'alamat' => 'Desa Pragaan Laok Pragaan', 'kota' => 'Sumenep', 'kodeInstitusi' => '069', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLK Sound Electric', 'alamat' => 'Jl. Kurma 11', 'kota' => 'Blitar', 'kodeInstitusi' => '070', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLKI Mandiri Kutai Timur', 'alamat' => 'Jl. Sidodadi RT.43 RW.005 Teluk Lingga', 'kota' => 'Kutai Timur', 'kodeInstitusi' => '071', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BLK Disnaker Kab. Karangasem', 'alamat' => 'Jl. A. Yani 29 Amlapura', 'kota' => 'Bali', 'kodeInstitusi' => '072', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPK Solusi Terampil Global', 'alamat' => 'Desa Gunungan RT 003/ RW 0021 Kec. Dawarblandong', 'kota' => 'Mojokerto', 'kodeInstitusi' => '073', 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'PT. Insera Sena', 'alamat' => 'Jl. Veteran, Lingkar Timur, Kel. Wadungasih', 'kota' => 'Sidoarjo', 'kodeInstitusi' => '078', 'created_at' => $now, 'updated_at' => $now],
            
            // --- Data Tanpa Kode Instansi
            ['namaInstitusi' => 'UPT BLK Singosari', 'alamat' => 'Jl. Raya Singosari', 'kota' => 'Singosari', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Kota Probolinggo', 'alamat' => 'Jl. Brantas Km.1', 'kota' => 'Probolinggo', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMAN 1 Grabagan', 'alamat' => 'Jl. Ps. Wage No.1, Klampayan', 'kota' => 'Tuban', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMKN 1 Bojonegoro', 'alamat' => 'Jl. Panglima Polim No. 50', 'kota' => 'Bojonegoro', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMK Dr Soetomo', 'alamat' => 'Jl. Jojoran IV No 2B', 'kota' => 'Surabaya', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMK PGRI 1 Jombang', 'alamat' => 'Jl. Pattimura V No. 75', 'kota' => 'Jombang', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BBPK K Semarang', 'alamat' => 'Jl. Brigjen Sudiarto No 118,', 'kota' => 'Semarang', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPTD BLK Kota Semarang', 'alamat' => 'Jl. Slamet Riyadi No 6 A', 'kota' => 'Semarang', 'kodeInstituisi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'UPT BLK Banyuwangi', 'alamat' => 'Dusun Krajan, Kedungrejo', 'kota' => 'Banyuwangi', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LPKS RUM Inovasi Teknik', 'alamat' => 'Jl. Raya Jengawah Muluk', 'kota' => 'Kab Sumbawa', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Cabang Dinas Pendidikan Kab Lamongan', 'alamat' => 'Jl. Kombes Pol Moh. Duryat No.7', 'kota' => 'Kab Lamongan', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LSP Administrasi Bisnis Perkantoran Modern', 'alamat' => 'Perum. Sambong Permai Blok H No.10', 'kota' => 'Jombang', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Politeknik Negeri Madura', 'alamat' => 'Jl. Raya Taddan Km. 4 Sampang', 'kota' => 'Sampang', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LSP Pariwisata Pesona Indonesia', 'alamat' => 'Jl. Ngurah Rai No. 12 Badung', 'kota' => 'Bali', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Biro Kesejahteraan Rakyat Setda Prov Jatim', 'alamat' => 'Jl. Pahlawan No. 110 Surabaya', 'kota' => 'Surabaya', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMKN 6 Surabaya', 'alamat' => 'Jl. Margorejo No.76', 'kota' => 'Surabaya', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Dinas Perindustrian Dan Tenaga Kerja Kabupaten Bangkalan', 'alamat' => 'Jl. Halim Perdana Kusuma No.2', 'kota' => 'Bangkalan', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LSP BLKI Singosari', 'alamat' => 'Jl. Raya Singosari', 'kota' => 'Singosari', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'ILC Surabaya', 'alamat' => 'Jl. Pucang Anom Timur I No. 50', 'kota' => 'Surabaya', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Batik Aulia', 'alamat' => 'Dsn Ngaglik', 'kota' => 'Kediri', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMK Dewa Bhakti 1 Jombang', 'alamat' => 'Jl. Kusuma Bangsa No. 71', 'kota' => 'Jombang', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Dinas Perindustrian Dan Tenaga Kerja Kota Probolinggo', 'alamat' => 'Jl. KH. Hasan Geng Kyai Jawis 65 Kota Probolinggo', 'kota' => 'Probolinggo', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Biro Pengadaan Barang Jasa Setda Prov Jatim', 'alamat' => 'Jl. Pahlawan No. 110 Surabaya', 'kota' => 'Surabaya', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Dinas Tenaga Kerja dan Transmigrasi Provinsi Jawa Timur', 'alamat' => 'Jl. Dukuh Menanggal 124 - 126', 'kota' => 'Surabaya', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Balai Diklat Industri Surabaya', 'alamat' => 'Jl. Gayung Kebonsari Dalam 12', 'kota' => 'Surabaya', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMA AT Tibyan', 'alamat' => 'Jln. Surabaya Malang KM. 42 Kepulungan', 'kota' => 'Kab. Pasuruan', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'Program Studi Sastra Inggris Universitas Diponegoro', 'alamat' => 'Jl. Prof. Soedarto', 'kota' => 'Kota Semarang', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMK Negeri 2 Ponorogo', 'alamat' => 'Jl. Ponorogo - Pacitan No.21a, Krandegan', 'kota' => 'Kab. Ponorogo', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BBPVP Bandung', 'alamat' => 'Jl. Gatot Subroto No.170', 'kota' => 'Bandung', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'SMKN 1 Lingsar Lombok Barat', 'alamat' => 'Jl. Batu Kumbung, Kec. Lingsar, Kabupaten', 'kota' => 'Kab. Lombok Barat', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'BPPMPV BOE Malang', 'alamat' => 'Jl. Teluk Mandar, Arjosari, Kec. Blimbing, Kota Malang', 'kota' => 'Malang', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LSP-T2K3 Indonesia', 'alamat' => 'Jl. Kedung Doro, Sawahan, Kec. Sawahan', 'kota' => 'Surabaya', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
            ['namaInstitusi' => 'LSP Pariwisata Nasional', 'alamat' => 'Jl. Bendul Merisi Utara VIII No.23', 'kota' => 'Surabaya', 'kodeInstitusi' => null, 'created_at' => $now, 'updated_at' => $now],
        ];  
        DB::table('jejaring_lsp_blk_sby')->insertOrIgnore($data);
    }
}
