<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$listCabor = [];
foreach(\App\Cabor::orderBy('nama', 'asc')->get() as $c) {
    $listCabor[$c->kelompok_kode][] = $c->nama;
}
echo json_encode($listCabor);
