<?php



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NakesJagaSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('nakes_jagas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [];
        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'jadwal_pertandingan_id' => $i + 1, // Matches JadwalPertandingan (which has 20)
                'nakes_id' => ($i % 15) + 1,        // Matches MasterNakes (which has 15)
                'tanggal' => now()->addDays($i % 3)->format('Y-m-d'),
                'cabor' => ['Sepak Bola', 'Bulu Tangkis', 'Renang', 'Atletik', 'Bola Basket'][$i % 5],
                'venue' => ['Stadion Benteng', 'GOR Dimyati', 'Kolam Renang Tirta', 'Track Atletik', 'GOR Basket'][$i % 5],
                'personil' => 'Driver Ambulans, Asisten Perawat',
                'keterangan' => 'Standby di pinggir lapangan dengan peralatan P3K lengkap.',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('nakes_jagas')->insert($data);
    }
}
