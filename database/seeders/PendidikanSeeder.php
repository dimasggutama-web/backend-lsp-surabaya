<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $data = [
            ['jenjangPendidikan' => 'SD', 'kodePendidikan'=> '01', 'created_at' => $now, 'updated_at' => $now],
            ['jenjangPendidikan' => 'SMP', 'kodePendidikan'=> '02', 'created_at' => $now, 'updated_at' => $now],
            ['jenjangPendidikan' => 'SMA/Sederajat', 'kodePendidikan'=> '03', 'created_at' => $now, 'updated_at' => $now],
            ['jenjangPendidikan' => 'D2', 'kodePendidikan'=> '04', 'created_at' => $now, 'updated_at' => $now],
            ['jenjangPendidikan' => 'D3', 'kodePendidikan'=> '05', 'created_at' => $now, 'updated_at' => $now],
            ['jenjangPendidikan' => 'D4', 'kodePendidikan'=> '06', 'created_at' => $now, 'updated_at' => $now],
            ['jenjangPendidikan' => 'S1', 'kodePendidikan'=> '07', 'created_at' => $now, 'updated_at' => $now],
            ['jenjangPendidikan' => 'S2', 'kodePendidikan'=> '08', 'created_at' => $now, 'updated_at' => $now],
            ['jenjangPendidikan' => 'S3', 'kodePendidikan'=> '09', 'created_at' => $now, 'updated_at' => $now],
            ['jenjangPendidikan' => 'D1', 'kodePendidikan'=> '10', 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('pendidikan')->insert($data);
    }
}
