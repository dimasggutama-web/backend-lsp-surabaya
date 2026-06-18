<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'storage/*'],

    'allowed_methods' => ['*'],

    // UBAH BAGIAN INI: Masukkan alamat Vite React Anda
    'allowed_origins' => ['http://localhost:5173', 'https://lspblksurabaya.id', 'http://127.0.0.1:5173', 'http://localhost:5174', 'http://127.0.0.1:5174'],
    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    

    'exposed_headers' => ['Content-Disposition'],

    'max_age' => 0,

    'supports_credentials' => true, // PASTIKAN INI TRUE jika memakai Sanctum
];