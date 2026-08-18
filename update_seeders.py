import re
import os

with open("c:\\Users\\irsya\\codingan\\kkpo\\jadwal_temp.php", "r") as f:
    jadwal_array = f.read()

kegiatan_seeder_code = """<?php

use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Facades\\DB;
use Carbon\\Carbon;

class KegiatanSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kegiatans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $kegiatans = [
            ['nama_kegiatan' => 'Pawai Obor PORPROV Banten Ke-VII', 'lokasi' => '-', 'tanggal_mulai' => '2026-11-13', 'tanggal_selesai' => '2026-11-13', 'is_khusus' => true],
            ['nama_kegiatan' => 'PORPROV Banten Ke-VII', 'lokasi' => 'Banten', 'tanggal_mulai' => '2026-11-13', 'tanggal_selesai' => '2026-11-22', 'is_khusus' => false],
            ['nama_kegiatan' => 'Opening Ceremony PORPROV Banten Ke-VII', 'lokasi' => '-', 'tanggal_mulai' => '2026-11-15', 'tanggal_selesai' => '2026-11-15', 'is_khusus' => true],
            ['nama_kegiatan' => 'Closing Ceremony PORPROV Banten Ke-VII', 'lokasi' => '-', 'tanggal_mulai' => '2026-11-23', 'tanggal_selesai' => '2026-11-23', 'is_khusus' => true],
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
"""

with open("c:\\Users\\irsya\\codingan\\kkpo\\database\\seeds\\KegiatanSeeder.php", "w") as f:
    f.write(kegiatan_seeder_code)

jadwal_seeder_code = f"""<?php

use Illuminate\\Database\\Seeder;
use Illuminate\\Support\\Facades\\DB;
use App\\Kegiatan;

class JadwalPertandinganSeeder extends Seeder
{{
    public function run()
    {{
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('jadwal_pertandingans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $kegiatan = Kegiatan::where('nama_kegiatan', 'PORPROV Banten Ke-VII')->first();
        $kegiatan_id = $kegiatan ? $kegiatan->id : 2; // Fallback to 2

        $jadwals = {jadwal_array};

        $data = [];
        foreach ($jadwals as $j) {{
            $data[] = [
                'kegiatan_id' => $kegiatan_id,
                'jenis_cabor' => $j['cabor'],
                'kel_cabor' => null,
                'venue' => $j['venue'],
                'alamat' => '',
                'link_google_map' => '',
                'jumlah_lapangan' => null,
                'tanggal' => $j['tanggal'],
                'waktu' => '08:00', // Default time as not provided
                'nakes' => $j['nakes'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }}

        DB::table('jadwal_pertandingans')->insert($data);
    }}
}}
"""

with open("c:\\Users\\irsya\\codingan\\kkpo\\database\\seeds\\JadwalPertandinganSeeder.php", "w") as f:
    f.write(jadwal_seeder_code)

