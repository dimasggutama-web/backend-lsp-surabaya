<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SumberAnggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['namaAnggaran' => 'APBN', 'kodeAnggaran' => '01', 'created_at' => $now, 'updated_at' => $now],
            ['namaAnggaran' => 'APBD', 'kodeAnggaran' => '02', 'created_at' => $now, 'updated_at' => $now],
            ['namaAnggaran' => 'Perusahaan', 'kodeAnggaran' => '03', 'created_at' => $now, 'updated_at' => $now],
            ['namaAnggaran' => 'Mandiri', 'kodeAnggaran' => '04', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('sumber_anggaran')->insert($data);
    }
}
