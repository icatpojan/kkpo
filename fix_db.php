foreach(\App\PelakuOlahraga::where('kel_cabor', 'Umum')->get() as $p) {
    $cabor = \App\Cabor::where('nama', $p->cabor)->first();
    if($cabor) {
        $kel = \App\KelompokCabor::where('kode', $cabor->kelompok_kode)->first();
        if($kel) {
            $p->kel_cabor = $kel->nama;
            $p->save();
        }
    }
}
echo "Done\n";
