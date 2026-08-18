<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KegiatanSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kegiatans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $kegiatans = [
            ['nama_kegiatan' => 'Pawai Obor', 'lokasi' => '-', 'tanggal_mulai' => '2026-11-13', 'tanggal_selesai' => '2026-11-13', 'is_khusus' => true],
            ['nama_kegiatan' => 'PORPROV Banten Ke-VII', 'lokasi' => 'Banten', 'tanggal_mulai' => '2026-11-13', 'tanggal_selesai' => '2026-11-22', 'is_khusus' => false],
            ['nama_kegiatan' => 'Opening Ceremony', 'lokasi' => '-', 'tanggal_mulai' => '2026-11-15', 'tanggal_selesai' => '2026-11-15', 'is_khusus' => true],
            ['nama_kegiatan' => 'Closing Ceremony', 'lokasi' => '-', 'tanggal_mulai' => '2026-11-23', 'tanggal_selesai' => '2026-11-23', 'is_khusus' => true],
        ];


        $data = [];
        foreach ($kegiatans as $keg) {
            $data[] = [
                'nama_kegiatan' => $keg['nama_kegiatan'],
                'tanggal_mulai' => $keg['tanggal_mulai'],
                'tanggal_selesai' => $keg['tanggal_selesai'],
                'lokasi' => $keg['lokasi'],
                'deskripsi' => 'Kegiatan olahraga bergengsi tingkat wilayah PORPROV Banten Ke-VII.',
                'is_khusus' => $keg['is_khusus'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('kegiatans')->insert($data);
    }
}
