<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JenisSkemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $data =[
            ['jenisSkema' => 'KLASTER', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['jenisSkema' => 'OKUPASI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('jenis_skema')->insert($data);
    }
}
