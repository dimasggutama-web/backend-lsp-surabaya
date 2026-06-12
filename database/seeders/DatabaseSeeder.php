<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Tulis nama-nama class seeder lo di sini
            // Pastikan file UserSeeder.php benar-benar ada di folder seeders
            
            
            // Contoh kalau ada seeder lain, buka comment-nya:
            // SkemaSeeder::class,
            // JejaringSeeder::class,
        ]);
    }
}