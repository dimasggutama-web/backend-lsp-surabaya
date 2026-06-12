<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['namaBidang' => 'Manufaktur', 'kodeBidang' => '01', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Las', 'kodeBidang' => '02', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Otomotif', 'kodeBidang' => '03', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Listrik', 'kodeBidang' => '04', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Bisman', 'kodeBidang' => '05', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Refrigerasi', 'kodeBidang' => '06', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Bangunan', 'kodeBidang' => '07', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Tata Rias', 'kodeBidang' => '08', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'TIK', 'kodeBidang' => '09', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Garmen', 'kodeBidang' => '10', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Pariwisata', 'kodeBidang' => '11', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Batik', 'kodeBidang' => '13', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Kreatif', 'kodeBidang' => '14', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Elektronika', 'kodeBidang' => '15', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Metodologi', 'kodeBidang' => '16', 'created_at' => $now, 'updated_at' => $now],
            ['namaBidang' => 'Sipil', 'kodeBidang' => '17', 'created_at' => $now, 'updated_at' => $now],

        ];
        DB::table('bidang')->insert($data);
    }
}
