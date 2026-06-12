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
    'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'], 

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    

    'exposed_headers' => ['Content-Disposition'],

    'max_age' => 0,

    'supports_credentials' => true, // PASTIKAN INI TRUE jika memakai Sanctum
];