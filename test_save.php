<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$req = new \Illuminate\Http\Request();
$req->merge(['jenis_status'=>'dikirim', 'status'=>'Selesai', 'no_resi'=>'AABB1122']);

$c = new \App\Http\Controllers\Api\AdminLspController();
$id = \App\Models\PengajuanUjkDetail::first()->id;
$resp = $c->updateStatusPemantauan($req, $id);

$d = \App\Models\PengajuanUjkDetail::find($id);
echo 'no_resi is: ' . $d->no_resi;
