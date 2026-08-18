<?php



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterNakesSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('master_nakes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $nakesData = [
            ['nama' => 'Dr. Andi Gunawan', 'spesialisasi' => 'Dokter Umum', 'instansi' => 'Puskesmas Pamulang'],
            ['nama' => 'Dr. Rina Sulistyaningsih', 'spesialisasi' => 'Dokter Olahraga', 'instansi' => 'RSUD Tangsel'],
            ['nama' => 'Siti Nurhaliza, S.Kep', 'spesialisasi' => 'Perawat', 'instansi' => 'Puskesmas Ciputat'],
            ['nama' => 'Budi Santoso, S.Ft', 'spesialisasi' => 'Fisioterapi', 'instansi' => 'Klinik Fisio Bintaro'],
            ['nama' => 'Dr. Hendi Setiawan', 'spesialisasi' => 'Dokter Ortopedi', 'instansi' => 'RS Premier Bintaro'],
            ['nama' => 'Ahmad Fauzi, Amd.Kep', 'spesialisasi' => 'Perawat', 'instansi' => 'PMI Tangsel'],
            ['nama' => 'Dr. Dewi Sartika', 'spesialisasi' => 'Dokter Umum', 'instansi' => 'Puskesmas Pondok Aren'],
            ['nama' => 'Rizky Pratama, S.Ft', 'spesialisasi' => 'Fisioterapi', 'instansi' => 'KONI Tangsel'],
            ['nama' => 'Ratna Galih, S.Kep', 'spesialisasi' => 'Perawat', 'instansi' => 'RSUD Banten'],
            ['nama' => 'Dr. Taufik Hidayat', 'spesialisasi' => 'Dokter Olahraga', 'instansi' => 'Kemenpora'],
            ['nama' => 'Maya Wulan, Amd.Kep', 'spesialisasi' => 'Perawat', 'instansi' => 'Klinik Sehat BSD'],
            ['nama' => 'Dr. Doni Monardo', 'spesialisasi' => 'Dokter Umum', 'instansi' => 'Dinkes Tangsel'],
            ['nama' => 'Aris Kurniawan, S.Ft', 'spesialisasi' => 'Fisioterapi', 'instansi' => 'RS Hermina Ciputat'],
            ['nama' => 'Dr. Yulia Rahman', 'spesialisasi' => 'Dokter Umum', 'instansi' => 'Puskesmas Serpong'],
            ['nama' => 'Dian Sastro, S.Kep', 'spesialisasi' => 'Perawat', 'instansi' => 'PMI Banten'],
        ];

        $data = [];
        foreach ($nakesData as $index => $nakes) {
            $data[] = [
                'nama' => $nakes['nama'],
                'spesialisasi' => $nakes['spesialisasi'],
                'no_str' => 'STR-3674' . str_pad($index, 5, '0', STR_PAD_LEFT),
                'instansi' => $nakes['instansi'],
                'no_wa' => '0812' . rand(10000000, 99999999),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('master_nakes')->insert($data);
    }
}
